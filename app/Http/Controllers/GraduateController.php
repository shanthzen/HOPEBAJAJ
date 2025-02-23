<?php

namespace App\Http\Controllers;

use App\Models\Graduate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GraduateController extends Controller
{
    public function index(Request $request)
    {
        $query = Graduate::query();

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('batch_no', 'like', "%{$search}%")
                  ->orWhere('course_name', 'like', "%{$search}%")
                  ->orWhere('certificate_no', 'like', "%{$search}%");
            });
        }

        // Batch filter
        if ($request->has('batch') && $request->batch) {
            $query->where('batch_no', $request->batch);
        }

        // Course filter
        if ($request->has('course') && $request->course) {
            $query->where('course_name', $request->course);
        }

        // Get unique batches and courses for filters
        $batches = Graduate::distinct()->pluck('batch_no');
        $courses = Graduate::distinct()->pluck('course_name');

        // Get paginated results
        $graduates = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('graduates.index', compact('graduates', 'batches', 'courses'));
    }

    public function create()
    {
        return view('graduates.create');
    }

    protected function validateGraduate(Request $request, Graduate $graduate = null)
    {
        $rules = [
            'batch_no' => 'required|string|max:255',
            'certificate_no' => 'required|string|unique:graduates,certificate_no' . ($graduate ? ',' . $graduate->id : ''),
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|size:10',
            'id_proof_type' => 'required|in:Aadhar,Voter ID,Driving License,PAN',
            'id_proof_number' => 'required|string|unique:graduates,id_proof_number' . ($graduate ? ',' . $graduate->id : ''),
            'course_name' => 'required|string|max:255',
            'course_duration' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'total_days_attended' => 'required|integer|min:0',
            'certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ];

        return $request->validate($rules);
    }

    public function store(Request $request)
    {
        $validatedData = $this->validateGraduate($request);

        // Handle certificate upload
        if ($request->hasFile('certificate')) {
            $validatedData['certificate_path'] = $request->file('certificate')->store('graduates/certificates', 'public');
        }

        Graduate::create($validatedData);

        return redirect()->route('graduates.index')
            ->with('success', 'Graduate added successfully.');
    }

    public function show(Graduate $graduate)
    {
        return view('graduates.view', compact('graduate'));
    }

    public function edit($id)
    {
        $graduate = Graduate::findOrFail($id);
        return view('graduates.edit', compact('graduate'));
    }

    public function update(Request $request, $id)
    {
        $graduate = Graduate::findOrFail($id);
        
        $validated = $request->validate([
            'batch_no' => 'required',
            'certificate_no' => 'required',
            'name' => 'required',
            'phone_number' => 'required',
            'course_name' => 'required',
            'course_duration' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'total_days_attended' => 'required|numeric|min:1',
            'aadhar_number' => 'required|digits:12',
            'certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048'
        ]);

        // Remove certificate from validated data if no new file is uploaded
        if (!$request->hasFile('certificate')) {
            unset($validated['certificate']);
        } else {
            // Only handle certificate if a new one is uploaded
            if ($graduate->certificate_path) {
                Storage::disk('public')->delete($graduate->certificate_path);
            }
            $validated['certificate_path'] = $request->file('certificate')->store('graduates/certificates', 'public');
        }

        $graduate->update($validated);

        return redirect()->route('graduates.index')
            ->with('success', 'Graduate updated successfully');
    }

    public function destroy(Graduate $graduate)
    {
        if ($graduate->certificate_path) {
            Storage::disk('public')->delete($graduate->certificate_path);
        }
        
        $graduate->delete();

        return redirect()->route('graduates.index')
            ->with('success', 'Graduate deleted successfully.');
    }
}
