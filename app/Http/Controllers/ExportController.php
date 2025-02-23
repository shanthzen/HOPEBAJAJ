<?php

namespace App\Http\Controllers;

use App\Models\EnrolledStudent;
use App\Models\Graduate;
use App\Models\PlacedStudent;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;
use ZipArchive;
use File;

class ExportController extends Controller
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

    private function ensureDirectoryExists($path)
    {
        if (!File::exists($path)) {
            File::makeDirectory($path, 0755, true);
        }
    }

    private function formatDate($date)
    {
        if (!$date) return '';
        return $date instanceof Carbon ? $date->format('Y-m-d') : Carbon::parse($date)->format('Y-m-d');
    }

    public function index()
    {
        // Get recent exports from storage
        $exportPath = storage_path('app/public/exports');
        $this->ensureDirectoryExists($exportPath);

        $exports = collect(File::files($exportPath))
            ->map(function($file) {
                return [
                    'name' => $file->getFilename(),
                    'type' => $this->getExportType($file->getFilename()),
                    'created_at' => Carbon::createFromTimestamp($file->getMTime()),
                    'size' => $this->formatSize($file->getSize()),
                    'download_url' => Storage::url('exports/' . $file->getFilename())
                ];
            })
            ->sortByDesc('created_at')
            ->take(10)
            ->values();

        return view('export.index', compact('exports'));
    }

    public function export($type)
    {
        try {
            // Create CSV file
            $timestamp = Carbon::now()->format('Y-m-d_H-i-s');
            $filename = $type . '_export_' . $timestamp . '.csv';
            
            // Ensure export directory exists
            $exportPath = storage_path('app/public/exports');
            $this->ensureDirectoryExists($exportPath);
            
            $filepath = $exportPath . '/' . $filename;

            // Get headers and data based on type
            switch($type) {
                case 'students':
                    $headers = [
                        'Sl No', 'ID', 'Student User ID', 'User Credential', 'Batch No', 'Batch Timings', 
                        'Faculty Name', 'Full Name', 'Email', 'Contact Number', 'WhatsApp Number',
                        'Date of Birth', 'ID Proof Type', 'ID Proof Number', 'Gender',
                        'Qualification', 'College Name', 'College Address',
                        'Currently Pursuing', 'Looking for Job', 'Course Enrolled',
                        'Status', 'Enrollment Date'
                    ];
                    $records = EnrolledStudent::all();
                    break;
                    
                case 'graduates':
                    $headers = [
                        'Sl No', 'ID', 'Batch No', 'Certificate No', 'Name', 'Phone Number',
                        'ID Proof Type', 'ID Proof Number', 'Course Name',
                        'Course Duration', 'Start Date', 'End Date',
                        'Total Days Attended', 'Certificate Path'
                    ];
                    $records = Graduate::all();
                    break;
                    
                case 'placements':
                    $headers = [
                        'Sl No', 'Batch No', 'Name', 'Phone Number',
                        'Company Name', 'Designation', 'Salary', 'Joining Date',
                        'Supporting Documents'
                    ];
                    $records = PlacedStudent::all();
                    break;
                    
                default:
                    return back()->with('error', 'Invalid export type');
            }

            // Create and open CSV file
            $file = fopen($filepath, 'w');
            if ($file === false) {
                throw new \Exception("Unable to create file: " . $filepath);
            }
            
            // Add UTF-8 BOM for Excel compatibility
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Write headers
            fputcsv($file, $headers);
            
            // Write data
            $slNo = 1;
            foreach ($records as $record) {
                $data = $this->getRecordData($record, $type, $slNo++);
                fputcsv($file, $data);
            }
            
            fclose($file);

            // Return download response
            return response()->download($filepath)->deleteFileAfterSend();

        } catch (\Exception $e) {
            return back()->with('error', 'Error exporting data: ' . $e->getMessage());
        }
    }

    private function getRecordData($record, $type, $slNo = null)
    {
        switch($type) {
            case 'students':
                return [
                    $slNo,
                    $record->id,
                    $record->student_user_id,
                    $record->user_credential,
                    $record->batch_no,
                    $record->batch_timings,
                    $record->faculty_name,
                    $record->full_name,
                    $record->email,
                    $record->contact_number,
                    $record->whatsapp_number,
                    $this->formatDate($record->date_of_birth),
                    $record->id_proof_type,
                    $record->id_proof_number,
                    $record->gender,
                    $record->qualification,
                    $record->college_name,
                    $record->college_address,
                    $record->is_pursuing ? 'Yes' : 'No',
                    $record->looking_for_job ? 'Yes' : 'No',
                    $record->course_enrolled,
                    $record->status,
                    $this->formatDate($record->enrollment_date)
                ];
                
            case 'graduates':
                return [
                    $slNo,
                    $record->id,
                    $record->batch_no,
                    $record->certificate_no,
                    $record->name,
                    $record->phone_number,
                    $record->id_proof_type,
                    $record->id_proof_number,
                    $record->course_name,
                    $record->course_duration,
                    $this->formatDate($record->start_date),
                    $this->formatDate($record->end_date),
                    $record->total_days_attended,
                    $record->certificate_path
                ];
                
            case 'placements':
                // Get the raw supporting_documents value without the URL transformation
                $supportingDocs = $record->getRawOriginal('supporting_documents') ?? '';
                
                return [
                    $slNo,
                    $record->batch_no ?? '',
                    $record->name,
                    $record->phone_number,
                    $record->company_name,
                    $record->designation,
                    (float)$record->getRawOriginal('salary'),
                    $this->formatDate($record->joining_date),
                    $supportingDocs
                ];
                
            default:
                return [];
        }
    }

    private function getExportType($filename)
    {
        if (strpos($filename, 'students_') === 0) return 'Students';
        if (strpos($filename, 'graduates_') === 0) return 'Graduates';
        if (strpos($filename, 'placements_') === 0) return 'Placements';
        return 'Unknown';
    }

    private function formatSize($size)
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $power = $size > 0 ? floor(log($size, 1024)) : 0;
        return number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
    }
}
