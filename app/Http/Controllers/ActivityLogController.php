<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ActivityLogController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index(Request $request)
    {
        $query = ActivityLog::with('user')->latest();

        // Filter by action type
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        // Filter by model type
        if ($request->filled('model_type')) {
            $query->where('model_type', $request->model_type);
        }

        // Filter by date range
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // Filter by user
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Search in details
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->whereJsonContains('details', $searchTerm)
                  ->orWhereHas('user', function($uq) use ($searchTerm) {
                      $uq->where('name', 'like', "%{$searchTerm}%");
                  })
                  ->orWhere('model_type', 'like', "%{$searchTerm}%")
                  ->orWhere('action', 'like', "%{$searchTerm}%");
            });
        }

        $logs = $query->paginate(20);

        // Get unique values for filters
        $actions = ActivityLog::distinct()->pluck('action');
        $modelTypes = ActivityLog::distinct()->pluck('model_type');

        // Get users for the dropdown
        $users = \App\Models\User::orderBy('name')->get();

        return view('activity-logs.index', compact('logs', 'actions', 'modelTypes', 'users'));
    }

    public function show(ActivityLog $log)
    {
        $log->load('model', 'user');
        return view('admin.activity-logs.show', compact('log'));
    }

    public function export(Request $request)
    {
        $query = ActivityLog::with('user')->latest();

        // Apply filters
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }
        if ($request->filled('model_type')) {
            $query->where('model_type', $request->model_type);
        }
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }
        
        // Search in details
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->whereJsonContains('details', $searchTerm)
                  ->orWhereHas('user', function($uq) use ($searchTerm) {
                      $uq->where('name', 'like', "%{$searchTerm}%");
                  })
                  ->orWhere('model_type', 'like', "%{$searchTerm}%")
                  ->orWhere('action', 'like', "%{$searchTerm}%");
            });
        }

        $logs = $query->get();

        // Generate CSV
        $filename = 'activity_logs_' . Carbon::now()->format('Y-m-d_His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $handle = fopen('php://temp', 'w+');
        fputcsv($handle, [
            'Sl No', 'Date & Time', 'User', 'Action', 'Model Type', 'Model ID', 'IP Address', 'Details'
        ]);

        foreach ($logs as $index => $log) {
            $details = '';
            if ($log->details) {
                if ($log->action === 'delete' && isset($log->details['deleted_model'])) {
                    $details = "Deleted Model Details:\n";
                    foreach ($log->details['deleted_model']['attributes'] as $key => $value) {
                        $details .= ucfirst(str_replace('_', ' ', $key)) . ": " . 
                                  (is_array($value) ? json_encode($value) : $value) . "\n";
                    }
                } elseif ($log->action === 'update' && isset($log->details['changed'])) {
                    $details = "Changed Fields:\n";
                    foreach ($log->details['changed'] as $key => $value) {
                        $original = $log->details['original'][$key] ?? 'null';
                        $details .= ucfirst(str_replace('_', ' ', $key)) . ": " . 
                                  "From: {$original} To: {$value}\n";
                    }
                } elseif ($log->action === 'create' && isset($log->details['attributes'])) {
                    $details = "Created With:\n";
                    foreach ($log->details['attributes'] as $key => $value) {
                        $details .= ucfirst(str_replace('_', ' ', $key)) . ": " . 
                                  (is_array($value) ? json_encode($value) : $value) . "\n";
                    }
                }
            }

            fputcsv($handle, [
                $index + 1,
                $log->created_at->format('d-m-Y H:i:s'),
                $log->user ? $log->user->name : 'Unknown',
                ucfirst($log->action),
                class_basename($log->model_type),
                $log->model_id,
                $log->ip_address,
                $details
            ]);
        }

        rewind($handle);
        $content = stream_get_contents($handle);
        fclose($handle);

        return response($content, 200, $headers);
    }
}
