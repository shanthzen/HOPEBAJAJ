<?php

namespace App\Http\Controllers;

use App\Models\PlacedStudent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class PlacementController extends Controller
{
    public function index(Request $request)
    {
        $query = PlacedStudent::query();

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('company_name', 'like', "%{$search}%")
                  ->orWhere('designation', 'like', "%{$search}%");
            });
        }

        // Get paginated results
        $placements = $query->orderBy('created_at', 'desc')->paginate(10);

        // Get unique companies for filter
        $companies = PlacedStudent::distinct()
            ->pluck('company_name')
            ->filter()
            ->values();

        return view('placements.index', compact('placements', 'companies'));
    }

    public function create()
    {
        return view('placements.create');
    }

    protected function validatePlacement(Request $request, PlacedStudent $placement = null)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|size:10',
            'company_name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'salary' => 'required|numeric|min:0',
            'joining_date' => 'required|date',
            'sl_no' => 'required|string|max:255',
            'batch_no' => 'required|string|max:255',
            'supporting_documents' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ];

        $messages = [
            'sl_no.required' => 'The Serial Number field is required.',
            'batch_no.required' => 'The Batch Number field is required.',
            'phone_number.size' => 'The Phone Number must be exactly 10 digits.',
            'salary.numeric' => 'The Salary must be a valid number.',
            'joining_date.date' => 'The Joining Date must be a valid date.',
        ];

        return $request->validate($rules, $messages);
    }

    public function store(Request $request)
    {
        $validatedData = $this->validatePlacement($request);

        // Handle document upload
        if ($request->hasFile('supporting_documents')) {
            $validatedData['supporting_documents'] = $request->file('supporting_documents')
                ->store('placements/documents', 'public');
        }

        PlacedStudent::create($validatedData);

        return redirect()->route('placements.index')
            ->with('success', 'Placement record added successfully.');
    }

    public function show(PlacedStudent $placement)
    {
        return view('placements.show', compact('placement'));
    }

    public function edit(PlacedStudent $placement)
    {
        return view('placements.edit', compact('placement'));
    }

    public function update(Request $request, PlacedStudent $placement)
    {
        try {
            // Log the request data
            \Log::info('Placement Update - Request Data:', [
                'id' => $placement->id,
                'all_data' => $request->all(),
                'batch_no_input' => $request->input('batch_no'),
                'current_batch_no' => $placement->batch_no
            ]);

            // Validate the data
            $validatedData = $this->validatePlacement($request, $placement);
            
            // Log validated data
            \Log::info('Placement Update - Validated Data:', [
                'batch_no' => $validatedData['batch_no'] ?? null
            ]);

            // Format salary (remove any currency symbols and commas)
            if (isset($validatedData['salary'])) {
                $validatedData['salary'] = str_replace(['₹', ','], '', $validatedData['salary']);
                $validatedData['salary'] = floatval($validatedData['salary']);
            }

            // Format joining date
            if (isset($validatedData['joining_date'])) {
                $validatedData['joining_date'] = date('Y-m-d', strtotime($validatedData['joining_date']));
            }

            // Handle document upload
            if ($request->hasFile('supporting_documents')) {
                // Delete old file if exists
                if ($placement->supporting_documents) {
                    Storage::disk('public')->delete($placement->getRawOriginal('supporting_documents'));
                }
                $validatedData['supporting_documents'] = $request->file('supporting_documents')
                    ->store('placements/documents', 'public');
            } else {
                // Keep existing document
                unset($validatedData['supporting_documents']);
            }

            // Log the data before update
            \Log::info('Placement Update - Data to Update:', [
                'all_data' => $validatedData,
                'batch_no' => $validatedData['batch_no'] ?? null
            ]);

            // Update the placement
            $updated = $placement->forceFill($validatedData)->save();

            // Log the result
            \Log::info('Placement Update - Result:', [
                'success' => $updated,
                'updated_data' => $placement->fresh()->toArray(),
                'final_batch_no' => $placement->fresh()->batch_no
            ]);

            if (!$updated) {
                throw new \Exception('Failed to update placement record');
            }

            return redirect()->route('placements.index')
                ->with('success', 'Placement updated successfully.');

        } catch (\Exception $e) {
            \Log::error('Placement Update Error:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()->withInput()
                ->with('error', 'Failed to update placement: ' . $e->getMessage());
        }
    }

    public function destroy(PlacedStudent $placement)
    {
        if ($placement->supporting_documents) {
            Storage::disk('public')->delete($placement->supporting_documents);
        }
        
        $placement->delete();

        return redirect()->route('placements.index')
            ->with('success', 'Placement record deleted successfully.');
    }
}
