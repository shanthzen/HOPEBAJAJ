<?php

namespace App\Http\Controllers;

use App\Models\PlacedStudent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class PlacedStudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('trainer')->only(['create', 'store', 'edit', 'update', 'destroy']);
    }

    protected function validatePlacedStudent(Request $request)
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|size:10',
            'company_name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'salary' => 'required|numeric|min:0',
            'joining_date' => 'required|date',
            'batch_no' => 'required|string|max:255',
            'supporting_documents' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048'
        ]);
    }

    public function index(Request $request)
    {
        $query = PlacedStudent::query();
        
        // Handle search
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('company_name', 'like', "%{$searchTerm}%")
                  ->orWhere('designation', 'like', "%{$searchTerm}%")
                  ->orWhere('batch_no', 'like', "%{$searchTerm}%");
            });
        }

        // Handle company filter
        if ($request->has('company') && !empty($request->company)) {
            $query->where('company_name', $request->company);
        }
        
        $placements = $query->orderBy('created_at', 'desc')->paginate(10);
        
        // Get unique company names for the filter
        $companies = PlacedStudent::distinct()
            ->pluck('company_name')
            ->filter()
            ->values()
            ->toArray();

        // Preserve search parameters in pagination
        $placements->appends($request->only(['search', 'company']));

        return view('placements.index', compact('placements', 'companies'));
    }

    public function create()
    {
        return view('placements.create');
    }

    public function store(Request $request)
    {
        $validatedData = $this->validatePlacedStudent($request);

        try {
            DB::beginTransaction();

            $placedStudentData = [
                'name' => $validatedData['name'],
                'phone_number' => $validatedData['phone_number'],
                'company_name' => $validatedData['company_name'],
                'designation' => $validatedData['designation'],
                'salary' => $validatedData['salary'],
                'joining_date' => $validatedData['joining_date'],
                'batch_no' => $validatedData['batch_no']
            ];

            if ($request->hasFile('supporting_documents') && $request->file('supporting_documents')->isValid()) {
                $placedStudentData['supporting_documents'] = $request->file('supporting_documents');
            }

            $placedStudent = PlacedStudent::create($placedStudentData);

            DB::commit();

            return redirect()->route('placements.index')
                ->with('success', 'Placement record created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating placement record: ' . $e->getMessage());
            return back()->withInput()->withErrors(['error' => 'Failed to create placement record.']);
        }
    }

    public function show($id)
    {
        $placement = PlacedStudent::findOrFail($id);
        return view('placements.show', compact('placement'));
    }

    public function edit($id)
    {
        $placement = PlacedStudent::findOrFail($id);
        return view('placements.edit', compact('placement'));
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            // Find the placement
            $placement = PlacedStudent::findOrFail($id);

            // Log the incoming request data
            Log::info('Placement update - Request data:', [
                'id' => $id,
                'request_data' => $request->all()
            ]);

            // Validate the data
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'phone_number' => 'required|string|size:10',
                'company_name' => 'required|string|max:255',
                'designation' => 'required|string|max:255',
                'salary' => 'required|numeric|min:0',
                'joining_date' => 'required|date',
                'batch_no' => 'required|string|max:255',
                'supporting_documents' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048'
            ]);

            $placementData = [
                'name' => $validatedData['name'],
                'phone_number' => $validatedData['phone_number'],
                'company_name' => $validatedData['company_name'],
                'designation' => $validatedData['designation'],
                'salary' => $validatedData['salary'],
                'joining_date' => $validatedData['joining_date'],
                'batch_no' => $validatedData['batch_no']
            ];

            // Handle file upload
            if ($request->hasFile('supporting_documents') && $request->file('supporting_documents')->isValid()) {
                $placementData['supporting_documents'] = $request->file('supporting_documents');
            }

            // Log the data being updated
            Log::info('Placement update - Data being updated:', [
                'id' => $id,
                'data' => $placementData
            ]);

            $placement->update($placementData);

            DB::commit();

            return redirect()
                ->route('placements.show', $placement)
                ->with('success', 'Placement record updated successfully.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            Log::error('Validation error updating placement record:', [
                'id' => $id,
                'errors' => $e->errors(),
                'request_data' => $request->all()
            ]);
            
            return back()
                ->withErrors($e->errors())
                ->withInput();

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating placement record:', [
                'id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()
                ->withInput()
                ->withErrors(['error' => 'Failed to update placement record. ' . $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        // Delete associated document if it exists
        $placement = PlacedStudent::findOrFail($id);
        if ($placement->supporting_documents) {
            Storage::disk('public')->delete($placement->getRawOriginal('supporting_documents'));
        }

        $placement->delete();

        return redirect()->route('placements.index')
            ->with('success', 'Placement record deleted successfully.');
    }
}
