<?php

namespace App\Http\Controllers;

use App\Models\EnrolledStudent;
use App\Models\Graduate;
use App\Models\PlacedStudent;
use App\Models\Batch;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Basic Statistics
        $totalStudents = EnrolledStudent::count();
        $totalGraduates = Graduate::count();
        $totalPlacements = PlacedStudent::count();
        $averageSalary = PlacedStudent::avg('salary') ?? 0;

        // Monthly Statistics for the last 6 months
        $last6Months = collect(range(5, 0))->map(function ($i) {
            return now()->subMonths($i)->format('M Y');
        });

        // Get monthly data for students, graduates and placements
        $monthlyStats = [
            'labels' => $last6Months->toArray(),
            'students' => [],
            'graduates' => [],
            'placements' => []
        ];

        foreach ($last6Months as $month) {
            $date = Carbon::createFromFormat('M Y', $month);
            
            $monthlyStats['students'][] = EnrolledStudent::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();

            $monthlyStats['graduates'][] = Graduate::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();

            $monthlyStats['placements'][] = PlacedStudent::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
        }

        // Recent Placements
        $recentPlacements = PlacedStudent::latest()
            ->take(5)
            ->get();

        // Get recent students
        $recentStudents = EnrolledStudent::latest()
            ->take(5)
            ->get();

        // Get course statistics
        $courseStats = EnrolledStudent::select('course_enrolled', DB::raw('count(*) as total'))
            ->groupBy('course_enrolled')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        // Active Batches with students and graduates count
        $activeBatches = Batch::where('end_date', '>=', now())
            ->orderBy('start_date', 'desc')
            ->take(5)
            ->get()
            ->map(function ($batch) {
                $enrolledCount = EnrolledStudent::where('batch_id', $batch->id)->count();
                $graduatesCount = Graduate::whereHas('student', function($query) use ($batch) {
                    $query->where('batch_id', $batch->id);
                })->count();
                
                $totalDays = Carbon::parse($batch->start_date)->diffInDays($batch->end_date);
                $daysPassed = Carbon::parse($batch->start_date)->diffInDays(now());
                $progressPercentage = min(100, round(($daysPassed / $totalDays) * 100));
                
                return [
                    'name' => $batch->batch_name,
                    'progress' => $progressPercentage,
                    'students' => $enrolledCount,
                    'graduates' => $graduatesCount
                ];
            });

        return view('dashboard', compact(
            'totalStudents',
            'totalGraduates',
            'totalPlacements',
            'averageSalary',
            'monthlyStats',
            'recentStudents',
            'courseStats',
            'recentPlacements',
            'activeBatches'
        ));
    }

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if ($request->route()->getName() === 'dashboard.export' && 
                (!auth()->check() || (!auth()->user()->isDonor() && !auth()->user()->isTrainer() && !auth()->user()->isAdmin()))) {
                abort(403, 'Unauthorized. This section requires donor, trainer, or admin access.');
            }
            return $next($request);
        });
    }

    public function export(Request $request)
    {
        try {
            $type = $request->input('type', 'students');
            $search = $request->input('search');

            // Create Excel file
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            
            // Set headers and get data based on type
            switch($type) {
                case 'students':
                    $headers = [
                        'ID', 'Name', 'Email', 'Phone', 'Gender', 'Date of Birth',
                        'Father Name', 'Mother Name', 'Address', 'City', 'State',
                        'Qualification', 'Batch No', 'Status', 'Created At'
                    ];
                    $query = EnrolledStudent::query();
                    break;
                    
                case 'graduates':
                    $headers = [
                        'ID', 'Name', 'Email', 'Phone', 'Course Name', 'Batch No',
                        'Graduation Date', 'Grade', 'Certificate No', 'Status', 'Created At'
                    ];
                    $query = Graduate::query();
                    break;
                    
                case 'placements':
                    $headers = [
                        'ID', 'Name', 'Email', 'Phone', 'Company Name', 'Designation',
                        'Salary', 'Joining Date', 'Status', 'Created At'
                    ];
                    $query = PlacedStudent::query();
                    break;
                    
                default:
                    return back()->with('error', 'Invalid export type');
            }

            // Apply search filter if provided
            if ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('contact_number', 'like', "%{$search}%");
                });
            }

            // Get records
            $records = $query->get();
            
            // Set headers
            $sheet->fromArray([$headers], NULL, 'A1');
            
            // Add data
            $row = 2;
            foreach ($records as $record) {
                $data = [];
                switch($type) {
                    case 'students':
                        $data = [
                            $record->id,
                            $record->name,
                            $record->email,
                            $record->contact_number,
                            $record->gender,
                            $record->dob,
                            $record->father_name,
                            $record->mother_name,
                            $record->address,
                            $record->city,
                            $record->state,
                            $record->qualification,
                            $record->batch_no,
                            $record->status,
                            $record->created_at ? $record->created_at->format('Y-m-d H:i:s') : ''
                        ];
                        break;
                        
                    case 'graduates':
                        $data = [
                            $record->id,
                            $record->name,
                            $record->email,
                            $record->contact_number,
                            $record->course_completed,
                            $record->batch_no,
                            $record->graduation_date,
                            $record->grade,
                            $record->certificate_no,
                            $record->status,
                            $record->created_at ? $record->created_at->format('Y-m-d H:i:s') : ''
                        ];
                        break;
                        
                    case 'placements':
                        $data = [
                            $record->id,
                            $record->name,
                            $record->email,
                            $record->contact_number,
                            $record->company_name,
                            $record->designation,
                            $record->salary,
                            $record->created_at ? $record->created_at->format('Y-m-d H:i:s') : '',
                            $record->status,
                            $record->created_at ? $record->created_at->format('Y-m-d H:i:s') : ''
                        ];
                        break;
                }
                
                $sheet->fromArray([$data], NULL, 'A' . $row);
                $row++;
            }

            // Style the sheet
            $lastColumn = chr(65 + count($headers) - 1); // Convert number to letter (A, B, C, etc.)
            
            // Format headers
            $sheet->getStyle("A1:{$lastColumn}1")->applyFromArray([
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => '000000'],
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'E3E3E3']
                ]
            ]);

            // Auto-size columns
            foreach (range('A', $lastColumn) as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }

            // Create writer
            $writer = new Xlsx($spreadsheet);
            
            // Set filename
            $filename = $type . '_export_' . Carbon::now()->format('Y-m-d_H-i-s') . '.xlsx';
            
            // Create temporary file
            $tempFile = tempnam(sys_get_temp_dir(), 'export');
            $writer->save($tempFile);
            
            // Return download response
            return response()->download($tempFile, $filename, [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ])->deleteFileAfterSend(true);

        } catch (\Exception $e) {
            return back()->with('error', 'Error exporting data: ' . $e->getMessage());
        }
    }

    public function exportAll()
    {
        try {
            // Create backup directory
            $timestamp = Carbon::now()->format('Y-m-d_H-i-s');
            $backupDir = storage_path('app/public/backups/backup_' . $timestamp);
            
            if (!File::exists($backupDir)) {
                File::makeDirectory($backupDir, 0755, true);
                File::makeDirectory($backupDir . '/photos', 0755, true);
                File::makeDirectory($backupDir . '/documents', 0755, true);
            }

            // Create Excel file
            $spreadsheet = new Spreadsheet();
            
            // Export Students
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle('Enrolled Students');
            
            $headers = [
                'ID', 'Name', 'Email', 'Phone', 'Gender', 'Date of Birth',
                'Father Name', 'Mother Name', 'Address', 'City', 'State',
                'Qualification', 'Batch No', 'Status', 'Photo', 'Documents', 'Created At'
            ];
            
            $sheet->fromArray([$headers], NULL, 'A1');
            
            $row = 2;
            $students = EnrolledStudent::all();
            foreach ($students as $student) {
                // Copy photo if exists
                $photoPath = '';
                if ($student->photo && Storage::exists('public/' . $student->photo)) {
                    $newPath = 'photos/' . basename($student->photo);
                    Storage::copy('public/' . $student->photo, $backupDir . '/' . $newPath);
                    $photoPath = $newPath;
                }
                
                // Copy documents
                $documentPaths = [];
                if ($student->documents) {
                    $docs = json_decode($student->documents, true) ?? [];
                    foreach ($docs as $doc) {
                        if (Storage::exists('public/' . $doc)) {
                            $newPath = 'documents/' . basename($doc);
                            Storage::copy('public/' . $doc, $backupDir . '/' . $newPath);
                            $documentPaths[] = $newPath;
                        }
                    }
                }
                
                $data = [
                    $student->id,
                    $student->name,
                    $student->email,
                    $student->contact_number,
                    $student->gender,
                    $student->dob,
                    $student->father_name,
                    $student->mother_name,
                    $student->address,
                    $student->city,
                    $student->state,
                    $student->qualification,
                    $student->batch_no,
                    $student->status,
                    $photoPath,
                    implode(', ', $documentPaths),
                    $student->created_at ? $student->created_at->format('Y-m-d H:i:s') : ''
                ];
                
                $sheet->fromArray([$data], NULL, 'A' . $row);
                $row++;
            }

            // Style the sheet
            $lastColumn = 'Q'; // A to Q for 17 columns
            $sheet->getStyle("A1:{$lastColumn}1")->applyFromArray([
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'E3E3E3']
                ]
            ]);
            
            // Auto-size columns
            foreach (range('A', $lastColumn) as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }

            // Add Graduated Students sheet
            if (Schema::hasTable('graduates')) {
                $graduatesSheet = $spreadsheet->createSheet();
                $graduatesSheet->setTitle('Graduated Students');
                
                $headers = [
                    'ID', 'Name', 'Email', 'Phone', 'Course Name', 'Batch No',
                    'Graduation Date', 'Grade', 'Certificate No', 'Certificate', 'Status', 'Created At'
                ];
                
                $graduatesSheet->fromArray([$headers], NULL, 'A1');
                
                $row = 2;
                $graduates = Graduate::all();
                foreach ($graduates as $graduate) {
                    // Copy certificate if exists
                    $certificatePath = '';
                    if ($graduate->certificate && Storage::exists('public/' . $graduate->certificate)) {
                        $newPath = 'documents/certificates/' . basename($graduate->certificate);
                        Storage::copy('public/' . $graduate->certificate, $backupDir . '/' . $newPath);
                        $certificatePath = $newPath;
                    }
                    
                    $data = [
                        $graduate->id,
                        $graduate->name,
                        $graduate->email,
                        $graduate->contact_number,
                        $graduate->course_completed,
                        $graduate->batch_no,
                        $graduate->graduation_date,
                        $graduate->grade,
                        $graduate->certificate_no,
                        $certificatePath,
                        $graduate->status,
                        $graduate->created_at ? $graduate->created_at->format('Y-m-d H:i:s') : ''
                    ];
                    
                    $graduatesSheet->fromArray([$data], NULL, 'A' . $row);
                    $row++;
                }
                
                // Style the graduates sheet
                $lastColumn = 'L';
                $graduatesSheet->getStyle("A1:{$lastColumn}1")->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'E3E3E3']
                    ]
                ]);
                
                foreach (range('A', $lastColumn) as $col) {
                    $graduatesSheet->getColumnDimension($col)->setAutoSize(true);
                }
            }

            // Add Placed Students sheet
            if (Schema::hasTable('placed_students')) {
                $placementsSheet = $spreadsheet->createSheet();
                $placementsSheet->setTitle('Placed Students');
                
                $headers = [
                    'ID', 'Name', 'Email', 'Phone', 'Company Name', 'Designation',
                    'Salary', 'Joining Date', 'Offer Letter', 'Documents', 'Status', 'Created At'
                ];
                
                $placementsSheet->fromArray([$headers], NULL, 'A1');
                
                $row = 2;
                $placements = PlacedStudent::all();
                foreach ($placements as $placement) {
                    // Copy offer letter if exists
                    $offerLetterPath = '';
                    if ($placement->offer_letter && Storage::exists('public/' . $placement->offer_letter)) {
                        $newPath = 'documents/offer_letters/' . basename($placement->offer_letter);
                        Storage::copy('public/' . $placement->offer_letter, $backupDir . '/' . $newPath);
                        $offerLetterPath = $newPath;
                    }
                    
                    // Copy other documents
                    $documentPaths = [];
                    if ($placement->documents) {
                        $docs = json_decode($placement->documents, true) ?? [];
                        foreach ($docs as $doc) {
                            if (Storage::exists('public/' . $doc)) {
                                $newPath = 'documents/placements/' . basename($doc);
                                Storage::copy('public/' . $doc, $backupDir . '/' . $newPath);
                                $documentPaths[] = $newPath;
                            }
                        }
                    }
                    
                    $data = [
                        $placement->id,
                        $placement->name,
                        $placement->email,
                        $placement->contact_number,
                        $placement->company_name,
                        $placement->designation,
                        $placement->salary,
                        $placement->created_at ? $placement->created_at->format('Y-m-d H:i:s') : '',
                        $offerLetterPath,
                        implode(', ', $documentPaths),
                        $placement->status,
                        $placement->created_at ? $placement->created_at->format('Y-m-d H:i:s') : ''
                    ];
                    
                    $placementsSheet->fromArray([$data], NULL, 'A' . $row);
                    $row++;
                }
                
                // Style the placements sheet
                $lastColumn = 'L';
                $placementsSheet->getStyle("A1:{$lastColumn}1")->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'E3E3E3']
                    ]
                ]);
                
                foreach (range('A', $lastColumn) as $col) {
                    $placementsSheet->getColumnDimension($col)->setAutoSize(true);
                }
            }

            // Save Excel file
            $excelPath = $backupDir . '/data.xlsx';
            $writer = new Xlsx($spreadsheet);
            $writer->save($excelPath);

            // Create ZIP archive
            $zipPath = storage_path('app/public/backups/hope_foundation_backup_' . $timestamp . '.zip');
            $zip = new ZipArchive();
            
            if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
                // Add Excel file
                $zip->addFile($excelPath, 'data.xlsx');
                
                // Add all files from backup directory
                $this->addFilesToZip($backupDir, $zip);
                $zip->close();
                
                // Clean up temporary files
                File::deleteDirectory($backupDir);
                
                // Return download response
                return response()->download($zipPath)->deleteFileAfterSend();
            }
            
            throw new \Exception("Could not create zip file");
            
        } catch (\Exception $e) {
            return back()->with('error', 'Error creating backup: ' . $e->getMessage());
        }
    }

    private function addFilesToZip($dir, $zip)
    {
        $files = File::allFiles($dir);
        foreach ($files as $file) {
            $relativePath = substr($file->getRealPath(), strlen($dir) + 1);
            $zip->addFile($file->getRealPath(), $relativePath);
        }
    }
}
