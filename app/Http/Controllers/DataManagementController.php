<?php

namespace App\Http\Controllers;

use App\Models\EnrolledStudent;
use App\Models\Graduate;
use App\Models\PlacedStudent;
use App\Models\ExportHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Response;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DataExport;
use App\Models\User;

class DataManagementController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!auth()->check() || (!auth()->user()->isDonor() && !auth()->user()->isTrainer() && !auth()->user()->isAdmin())) {
                abort(403, 'Unauthorized. This section requires donor, trainer, or admin access.');
            }
            return $next($request);
        });
    }

    public function index()
    {
        $studentsCount = EnrolledStudent::count();
        $graduatesCount = Graduate::count();
        $placementsCount = PlacedStudent::count();
        $exportHistory = ExportHistory::latest()->take(10)->get();

        return view('data-management.index', compact(
            'studentsCount',
            'graduatesCount',
            'placementsCount',
            'exportHistory'
        ));
    }

    public function exportStudents(Request $request)
    {
        $exportHistory = null;
        try {
            $format = $request->input('format', 'csv');
            $timestamp = now()->format('Y-m-d_His');
            $filename = "students_export_{$timestamp}";
            $filePath = "exports/{$filename}.{$format}";

            $exportHistory = ExportHistory::create([
                'type' => 'students',
                'format' => $format,
                'status' => 'processing',
                'file_path' => $filePath
            ]);

            // Get students with user information
            $students = EnrolledStudent::with('user')->get();

            if ($format === 'pdf') {
                $pdf = PDF::loadView('exports.students', compact('students'));
                Storage::disk('public')->put($filePath, $pdf->output());
            } else {
                // Generate CSV content with all student information
                $headers = [
                    'Sl No',
                    // Batch Information
                    'Batch No', 'Batch Timings', 'Faculty Name',
                    // Login Information
                    'User ID', 'User Credential',
                    // Personal Information
                    'Full Name (As per Certificate)', 'Email',
                    'Unique ID Proof Type', 'Unique ID Number',
                    'Date of Birth', 'Contact Number', 'WhatsApp Number',
                    'Gender',
                    // Educational Information
                    'Qualification', 'Course Enrolled', 'College Name', 'College Address',
                    // Status Information
                    'Pursuing', 'Looking for Job',
                    // Documents
                    'Student Photo', 'Student Signature'
                ];

                $data = $students->map(function ($student, $index) {
                    // Get user email if available
                    $userEmail = '';
                    if ($student->user_credential) {
                        $user = User::find($student->user_credential);
                        $userEmail = $user ? $user->email : '';
                    }

                    return [
                        $index + 1, // Sl No
                        // Batch Information
                        $student->batch_no,
                        $student->batch_timings,
                        $student->faculty_name,
                        // Login Information 
                        $student->student_user_id, // User ID
                        $student->user_credential,
                        // Personal Information
                        $student->full_name,
                        $student->email,
                        $student->id_proof_type,
                        $student->id_proof_number,
                        $student->date_of_birth ? Carbon::parse($student->date_of_birth)->format('d-m-Y') : '',
                        $student->contact_number,
                        $student->whatsapp_number,
                        $student->gender,
                        // Educational Information
                        $student->qualification,
                        $student->course_enrolled,
                        $student->college_name,
                        $student->college_address,
                        // Status Information
                        $student->is_pursuing ? 'Yes' : 'No',
                        $student->looking_for_job ? 'Yes' : 'No',
                        // Documents
                        $student->student_photo ? url(Storage::url($student->student_photo)) : '',
                        $student->student_signature ? url(Storage::url($student->student_signature)) : ''
                    ];
                })->toArray();

                // Create CSV content
                $csvContent = fopen('php://temp', 'r+');
                fputcsv($csvContent, $headers);
                foreach ($data as $row) {
                    fputcsv($csvContent, $row);
                }
                rewind($csvContent);
                $content = stream_get_contents($csvContent);
                fclose($csvContent);

                // Save CSV file
                Storage::disk('public')->put($filePath, $content);
            }

            $exportHistory->update([
                'status' => 'completed'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Export completed successfully',
                'export_id' => $exportHistory->id
            ]);
        } catch (\Exception $e) {
            \Log::error('Student export failed: ' . $e->getMessage(), [
                'format' => $format ?? null,
                'file_path' => $filePath ?? null,
                'exception' => $e
            ]);

            if ($exportHistory) {
                $exportHistory->update(['status' => 'failed']);
            }
            return response()->json([
                'success' => false,
                'message' => 'Export failed: ' . $e->getMessage()
            ], 500);
        }
    }

    public function exportGraduates(Request $request)
    {
        $exportHistory = null;
        try {
            $format = $request->input('format', 'csv');
            $timestamp = now()->format('Y-m-d_His');
            $filename = "graduates_export_{$timestamp}";
            $filePath = "exports/{$filename}.{$format}";

            $exportHistory = ExportHistory::create([
                'type' => 'graduates',
                'format' => $format,
                'status' => 'processing',
                'file_path' => $filePath
            ]);

            $graduates = Graduate::all();

            if ($format === 'pdf') {
                $pdf = PDF::loadView('exports.graduates', compact('graduates'));
                Storage::disk('public')->put($filePath, $pdf->output());
            } else {
                // Generate CSV content
                $headers = [
                    'Sl No', 'Batch No', 'Certificate No', 'Full Name', 'Phone Number',
                    'Course Name', 'Course Duration', 'Start Date', 'End Date',
                    'Total Days Attended', 'ID Type', 'ID Number'
                ];

                $data = $graduates->map(function ($graduate, $index) {
                    return [
                        $index + 1, // Sl No
                        $graduate->batch_no,
                        $graduate->certificate_no,
                        $graduate->name,
                        $graduate->phone_number,
                        $graduate->course_name,
                        $graduate->course_duration,
                        $graduate->start_date ? $graduate->start_date->format('d/m/Y') : 'N/A',
                        $graduate->end_date ? $graduate->end_date->format('d/m/Y') : 'N/A',
                        $graduate->total_days_attended . ' days',
                        $graduate->id_proof_type,
                        $graduate->id_proof_number
                    ];
                })->toArray();

                // Create CSV content
                $csvContent = fopen('php://temp', 'r+');
                fputcsv($csvContent, $headers);
                foreach ($data as $row) {
                    fputcsv($csvContent, $row);
                }
                rewind($csvContent);
                $content = stream_get_contents($csvContent);
                fclose($csvContent);

                // Save CSV file
                Storage::disk('public')->put($filePath, $content);
            }

            $exportHistory->update([
                'status' => 'completed'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Export completed successfully',
                'export_id' => $exportHistory->id
            ]);
        } catch (\Exception $e) {
            \Log::error('Graduate export failed: ' . $e->getMessage(), [
                'format' => $format ?? null,
                'file_path' => $filePath ?? null,
                'exception' => $e
            ]);

            if ($exportHistory) {
                $exportHistory->update(['status' => 'failed']);
            }
            return response()->json([
                'success' => false,
                'message' => 'Export failed: ' . $e->getMessage()
            ], 500);
        }
    }

    public function exportPlacements(Request $request)
    {
        $exportHistory = null;
        try {
            $format = $request->input('format', 'csv');
            $timestamp = now()->format('Y-m-d_His');
            $filename = "placements_export_{$timestamp}";
            $filePath = "exports/{$filename}.{$format}";

            $exportHistory = ExportHistory::create([
                'type' => 'placements',
                'format' => $format,
                'status' => 'processing',
                'file_path' => $filePath
            ]);

            $placements = PlacedStudent::all();

            if ($format === 'pdf') {
                $pdf = PDF::loadView('exports.placements', compact('placements'));
                Storage::disk('public')->put($filePath, $pdf->output());
            } else {
                // Generate CSV content
                $headers = [
                    'Sl No',
                    'Batch No',
                    'Name',
                    'Phone Number',
                    'Company Name',
                    'Designation',
                    'Salary',
                    'Joining Date',
                    'Supporting Documents'
                ];

                $data = $placements->map(function ($placement, $index) {
                    return [
                        $index + 1, // Sl No
                        $placement->batch_no,
                        $placement->name,
                        $placement->phone_number,
                        $placement->company_name,
                        $placement->designation,
                        (float)$placement->getRawOriginal('salary'),
                        $placement->joining_date ? Carbon::parse($placement->joining_date)->format('d-m-Y') : '',
                        $placement->supporting_documents ? url(Storage::url($placement->supporting_documents)) : ''
                    ];
                })->toArray();

                // Create CSV content
                $csvContent = fopen('php://temp', 'r+');
                fputcsv($csvContent, $headers);
                foreach ($data as $row) {
                    fputcsv($csvContent, $row);
                }
                rewind($csvContent);
                $content = stream_get_contents($csvContent);
                fclose($csvContent);

                // Save CSV file
                Storage::disk('public')->put($filePath, $content);
            }

            $exportHistory->update([
                'status' => 'completed'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Export completed successfully',
                'export_id' => $exportHistory->id
            ]);
        } catch (\Exception $e) {
            \Log::error('Placement export failed: ' . $e->getMessage(), [
                'format' => $format ?? null,
                'file_path' => $filePath ?? null,
                'exception' => $e
            ]);

            if ($exportHistory) {
                $exportHistory->update(['status' => 'failed']);
            }
            return response()->json([
                'success' => false,
                'message' => 'Export failed: ' . $e->getMessage()
            ], 500);
        }
    }

    public function backup()
    {
        try {
            $history = ExportHistory::create([
                'type' => 'backup',
                'format' => 'zip',
                'status' => 'processing'
            ]);

            // Get data from all tables
            $students = EnrolledStudent::all()->toArray();
            $graduates = Graduate::with('student')->get()->toArray();
            $placements = PlacedStudent::with('graduate.student')->get()->toArray();
            
            // Create JSON files for each dataset
            $data = [
                'students.json' => json_encode($students, JSON_PRETTY_PRINT),
                'graduates.json' => json_encode($graduates, JSON_PRETTY_PRINT),
                'placements.json' => json_encode($placements, JSON_PRETTY_PRINT)
            ];

            // Create a temporary directory for the files
            $tempDir = storage_path('app/temp/' . uniqid());
            if (!file_exists($tempDir)) {
                mkdir($tempDir, 0755, true);
            }

            // Write the JSON files
            foreach ($data as $filename => $content) {
                file_put_contents($tempDir . '/' . $filename, $content);
            }

            // Create a ZIP archive
            $zipFileName = 'backup_' . date('Y-m-d_His') . '.zip';
            $zip = new \ZipArchive();
            
            if ($zip->open(storage_path('app/temp/' . $zipFileName), \ZipArchive::CREATE) === TRUE) {
                $files = new \RecursiveIteratorIterator(
                    new \RecursiveDirectoryIterator($tempDir),
                    \RecursiveIteratorIterator::LEAVES_ONLY
                );

                foreach ($files as $file) {
                    if (!$file->isDir()) {
                        $filePath = $file->getRealPath();
                        $relativePath = basename($filePath);
                        $zip->addFile($filePath, $relativePath);
                    }
                }

                $zip->close();

                // Update history
                $history->update([
                    'status' => 'completed',
                    'file_path' => $zipFileName
                ]);

                // Clean up temporary files
                array_map('unlink', glob("$tempDir/*.*"));
                rmdir($tempDir);

                // Download the ZIP file
                $zipPath = storage_path('app/temp/' . $zipFileName);
                $headers = [
                    'Content-Type' => 'application/zip',
                    'Content-Disposition' => 'attachment; filename="' . $zipFileName . '"',
                ];

                return response()->download($zipPath, $zipFileName, $headers)->deleteFileAfterSend(true);
            } else {
                throw new \Exception("Could not create ZIP archive");
            }
        } catch (\Exception $e) {
            \Log::error('Backup Error: ' . $e->getMessage());
            if (isset($history)) {
                $history->update(['status' => 'failed']);
            }
            if (isset($tempDir) && file_exists($tempDir)) {
                array_map('unlink', glob("$tempDir/*.*"));
                rmdir($tempDir);
            }
            return redirect()->back()->with('error', 'Backup failed: ' . $e->getMessage());
        }
    }

    public function download($id)
    {
        try {
            $export = ExportHistory::findOrFail($id);
            $filePath = $export->file_path;
            
            // Ensure the file path starts with exports/
            if (!str_starts_with($filePath, 'exports/')) {
                $filePath = 'exports/' . basename($filePath);
            }
            
            if (!Storage::disk('public')->exists($filePath)) {
                if ($export->status === 'completed') {
                    // File was marked as completed but doesn't exist - mark as failed
                    $export->update(['status' => 'failed']);
                }
                
                return response()->json([
                    'success' => false,
                    'message' => 'Export file not found. Please try exporting again.'
                ], 404);
            }

            $filename = basename($filePath);
            $contentType = $this->getContentType(pathinfo($filename, PATHINFO_EXTENSION));
            
            // Update file path if it was corrected
            if ($filePath !== $export->file_path) {
                $export->update(['file_path' => $filePath]);
            }
            
            return Storage::disk('public')->download(
                $filePath,
                $filename,
                ['Content-Type' => $contentType]
            );
        } catch (\Exception $e) {
            \Log::error('Export download failed: ' . $e->getMessage(), [
                'export_id' => $id,
                'file_path' => $filePath ?? null,
                'exception' => $e
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Download failed: ' . $e->getMessage()
            ], 500);
        }
    }

    private function getContentType($format)
    {
        switch ($format) {
            case 'csv':
                return 'text/csv';
            case 'pdf':
                return 'application/pdf';
            case 'sql':
                return 'application/sql';
            case 'zip':
                return 'application/zip';
            default:
                return 'application/octet-stream';
        }
    }
}
