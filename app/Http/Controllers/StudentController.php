<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\EnrolledStudent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = EnrolledStudent::query();
        
        // Handle search
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = strtolower($request->search);
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('email', 'like', "%{$searchTerm}%")
                  ->orWhere('contact_number', 'like', "%{$searchTerm}%")
                  ->orWhere('whatsapp_number', 'like', "%{$searchTerm}%")
                  ->orWhere(function($q) use ($searchTerm) {
                      if (str_contains($searchTerm, 'looking for job')) {
                          $q->where('looking_for_job', true);
                      }
                      if (str_contains($searchTerm, 'pursuing')) {
                          $q->orWhere('is_pursuing', true);
                      }
                  });
            });
        }

        // Handle batch filter
        if ($request->has('batch') && !empty($request->batch)) {
            $query->where('batch_no', $request->batch);
        }
        
        $students = $query->orderBy('created_at', 'desc')->paginate(10);
        
        // Get unique batch numbers for the filter
        $batches = EnrolledStudent::distinct()
            ->pluck('batch_no')
            ->filter()
            ->values()
            ->toArray();

        // Preserve search parameters in pagination
        $students->appends($request->only(['search', 'batch']));

        return view('students.index', compact('students', 'batches'));
    }

    public function create()
    {
        return view('students.create');
    }

    protected function validateStudent(Request $request)
    {
        return $request->validate([
            'batch_no' => 'required|string|max:255',
            'batch_timings' => 'required',
            'faculty_name' => 'required|string|max:255',
            'full_name' => 'required|string',
            'email' => 'required|email|unique:enrolled_students,email',
            'id_proof_type' => 'required|in:Aadhar,Voter ID,Driving License,PAN',
            'id_proof_number' => 'required|string|unique:enrolled_students,id_proof_number',
            'date_of_birth' => 'required|date',
            'contact_number' => 'required|string|size:10',
            'whatsapp_number' => 'required|string|size:10',
            'gender' => 'required|in:Male,Female,Other',
            'qualification' => 'required|string',
            'college_name' => 'required|string',
            'college_address' => 'required|string|max:1000',
            'is_pursuing' => 'boolean',
            'looking_for_job' => 'boolean',
            'student_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'student_signature' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'course_enrolled' => 'required|string',
        ]);
    }

    public function store(Request $request)
    {
        \Log::info('Store request data:', $request->all());
        
        $validatedData = $request->validate([
            'batch_no' => 'required',
            'batch_timings' => 'required',
            'faculty_name' => 'required',
            'full_name' => 'required|string',
            'email' => 'required|email|unique:enrolled_students,email',
            'student_user_id' => 'required|string',
            'user_credential' => 'nullable',
            'id_proof_type' => 'required',
            'id_proof_number' => 'required|unique:enrolled_students,id_proof_number',
            'date_of_birth' => 'required|date',
            'contact_number' => 'required|string|size:10',
            'whatsapp_number' => 'required|string|size:10',
            'gender' => 'required|in:Male,Female,Other',
            'qualification' => 'required',
            'college_name' => 'required',
            'college_address' => 'required',
            'is_pursuing' => 'boolean',
            'looking_for_job' => 'boolean',
            'student_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'student_signature' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'course_enrolled' => 'required|string',
        ]);

        try {
            DB::beginTransaction();

            // Prepare student data
            // Remove user_id from validatedData since we'll use student_user_id
            unset($validatedData['user_id']);

            $studentData = array_merge($validatedData, [
                'name' => $validatedData['full_name'],
                'enrollment_date' => now(),
                'course_enrolled' => $validatedData['course_enrolled'],
                'status' => 'active',
                'is_pursuing' => $request->has('is_pursuing'),
                'looking_for_job' => $request->has('looking_for_job'),
            ]);

            // Handle file uploads
            if ($request->hasFile('student_photo')) {
                $studentData['student_photo'] = $request->file('student_photo')->store('students/photos', 'public');
            }

            if ($request->hasFile('student_signature')) {
                $studentData['student_signature'] = $request->file('student_signature')->store('students/signatures', 'public');
            }

            // Create or find user account
            if (!empty($validatedData['user_credential'])) {
                $studentData['user_credential'] = $validatedData['user_credential'];
            } else {
            // Create new user account
            $user = User::create([
                'name' => $validatedData['full_name'],
                'username' => $request->input('student_user_id'),
                'email' => $validatedData['email'],
                'password' => Hash::make('password'), // Default password
                'role' => 'student'
            ]);
                $studentData['user_credential'] = $user->id;
            }
            $studentData['student_user_id'] = strtolower(trim($request->input('student_user_id'))); // Ensure plain text format

            // Create student record
            $student = EnrolledStudent::create($studentData);

            DB::commit();

            return redirect()->route('students.index')
                ->with('success', 'Student created successfully. Default password is: password');
                
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error creating student: ' . $e->getMessage());
            throw $e;
        }
    }

    public function show(EnrolledStudent $student)
    {
        return view('students.show', compact('student'));
    }

    public function edit(EnrolledStudent $student)
    {
        return view('students.edit', compact('student'));
    }

    protected function validateUpdateStudent(Request $request, EnrolledStudent $student)
    {
        return $request->validate([
            'batch_no' => 'required|string|max:255',
            'batch_timings' => 'required',
            'faculty_name' => 'required|string|max:255',
            'full_name' => 'required|string',
            'email' => 'required|email',
            'user_id' => 'nullable|string',
            'user_credential' => 'nullable|string',
            'id_proof_type' => 'required|in:Aadhar,Voter ID,Driving License,PAN',
            'id_proof_number' => 'required|string|unique:enrolled_students,id_proof_number,' . $student->id,
            'date_of_birth' => 'required|date',
            'contact_number' => 'required|string|size:10',
            'whatsapp_number' => 'required|string|size:10',
            'gender' => 'required|in:Male,Female,Other',
            'qualification' => 'required|string',
            'college_name' => 'required|string',
            'college_address' => 'required|string|max:1000',
            'is_pursuing' => 'boolean',
            'looking_for_job' => 'boolean',
            'student_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'student_signature' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'course_enrolled' => 'required|string',
        ]);
    }

    public function update(Request $request, EnrolledStudent $student)
    {
        $validatedData = $this->validateUpdateStudent($request, $student);

        Log::info('Update request data:', $request->all());

        try {
            DB::beginTransaction();

            // Update or create user account
            if ($validatedData['user_credential']) {
                $user = User::find($validatedData['user_credential']);
                if ($user) {
                    $user->update([
                        'name' => $validatedData['full_name'],
                        'username' => $request->input('user_id')
                    ]);
                }
            } else {
                // Create new user if not exists
                $user = User::create([
                    'name' => $validatedData['full_name'],
                    'username' => $request->input('student_user_id'),
                    'email' => $validatedData['email'],
                    'password' => Hash::make('password'), // Default password
                    'role' => 'student'
                ]);
                $validatedData['user_credential'] = $user->id;
            }

            // Remove user_id from validatedData since we'll use student_user_id
            unset($validatedData['user_id']);

            $updateData = [
                'batch_no' => $validatedData['batch_no'],
                'batch_timings' => $validatedData['batch_timings'],
                'faculty_name' => $validatedData['faculty_name'],
                'full_name' => $validatedData['full_name'],
                'name' => $validatedData['full_name'],
                'email' => $validatedData['email'],
                'id_proof_type' => $validatedData['id_proof_type'],
                'id_proof_number' => $validatedData['id_proof_number'],
                'date_of_birth' => $validatedData['date_of_birth'],
                'contact_number' => $validatedData['contact_number'],
                'whatsapp_number' => $validatedData['whatsapp_number'],
                'gender' => $validatedData['gender'],
                'qualification' => $validatedData['qualification'],
                'college_name' => $validatedData['college_name'],
                'college_address' => $validatedData['college_address'],
                'is_pursuing' => $request->has('is_pursuing'),
                'looking_for_job' => $request->has('looking_for_job'),
                'user_credential' => $validatedData['user_credential'],
                'student_user_id' => strtolower(trim($request->input('student_user_id'))), // Ensure plain text format
                'course_enrolled' => $validatedData['course_enrolled']
            ];

            // Handle file uploads
            if ($request->hasFile('student_photo')) {
                if ($student->student_photo) {
                    Storage::disk('public')->delete($student->student_photo);
                }
                $updateData['student_photo'] = $request->file('student_photo')->store('students/photos', 'public');
            }

            if ($request->hasFile('student_signature')) {
                if ($student->student_signature) {
                    Storage::disk('public')->delete($student->student_signature);
                }
                $updateData['student_signature'] = $request->file('student_signature')->store('students/signatures', 'public');
            }

            // Update student record
            $student->update($updateData);

            DB::commit();

            return redirect()->route('students.show', $student)
                ->with('success', 'Student updated successfully. If a new user account was created, the default password is: password');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating student: ' . $e->getMessage());
            return back()->withInput()->withErrors(['error' => 'Failed to update student. Please try again.']);
        }
    }

    public function destroy(EnrolledStudent $student)
    {
        // Delete associated files if they exist
        if ($student->student_photo) {
            Storage::disk('public')->delete($student->student_photo);
        }
        if ($student->student_signature) {
            Storage::disk('public')->delete($student->student_signature);
        }
        
        // Delete the associated user if it exists
        if ($student->user) {
            $student->user->delete();
        } else {
            // If no associated user, delete the student directly
            $student->delete();
        }
        
        return redirect()->route('students.index')
            ->with('success', 'Student deleted successfully');
    }

    public function exportCsv()
    {
        $students = EnrolledStudent::all();
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=students.csv'
        ];

        $callback = function() use ($students) {
            $file = fopen('php://output', 'w');
            
            // Add headers
            fputcsv($file, [
                'ID',
                'Batch No',
                'Batch Timings',
                'Faculty Name',
                'Full Name',
                'Student User ID',
                'User Credential',
                'Email',
                'Contact Number',
                'WhatsApp Number',
                'Date of Birth',
                'ID Proof Type',
                'ID Proof Number',
                'Gender',
                'Qualification',
                'College Name',
                'College Address',
                'Currently Pursuing',
                'Looking for Job',
                'Course Enrolled',
                'Status',
                'Enrollment Date'
            ]);

            // Add data rows
            foreach ($students as $student) {
                fputcsv($file, [
                    $student->id,
                    $student->batch_no,
                    $student->batch_timings,
                    $student->faculty_name,
                    $student->full_name,
                    $student->student_user_id,
                    $student->user_credential,
                    $student->email,
                    $student->contact_number,
                    $student->whatsapp_number,
                    optional($student->date_of_birth)->format('d/m/Y'),
                    $student->id_proof_type,
                    $student->id_proof_number,
                    $student->gender,
                    $student->qualification,
                    $student->college_name,
                    $student->college_address,
                    $student->is_pursuing ? 'Yes' : 'No',
                    $student->looking_for_job ? 'Yes' : 'No',
                    $student->course_enrolled,
                    $student->status,
                    optional($student->enrollment_date)->format('d/m/Y')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
