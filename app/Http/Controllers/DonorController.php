<?php

namespace App\Http\Controllers;

use App\Models\Donor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class DonorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // Only admin can access create, store, edit, update, and destroy methods
        $this->middleware('admin')->only(['create', 'store', 'edit', 'update', 'destroy']);
    }

    public function index()
    {
        $donors = Donor::latest()->paginate(9);
        return view('donors.index', compact('donors'));
    }

    public function create()
    {
        return view('donors.create');
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'contributions' => 'required|string',
                'impact' => 'required|string',
                'contact_email' => 'nullable|email|max:255',
                'contact_phone' => 'nullable|string|max:20',
                'website' => 'nullable|string|max:255',
                'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            // Log the incoming request data
            \Log::info('Donor creation - Request data:', [
                'request_data' => $request->all()
            ]);

            if ($request->hasFile('logo')) {
                $logo = $request->file('logo');
                $filename = time() . '_' . $logo->getClientOriginalName();
                $path = $logo->storeAs('donors', $filename, 'public');
                $validatedData['logo'] = $filename;
            }

            // Create the donor
            $donor = Donor::create($validatedData);

            // Log the created donor
            \Log::info('Donor created successfully:', [
                'donor_id' => $donor->id,
                'donor_data' => $donor->toArray()
            ]);

            return redirect()->route('donors.index')
                ->with('success', 'Donor added successfully.');

        } catch (\Exception $e) {
            \Log::error('Error creating donor:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);

            return back()->withInput()
                ->withErrors(['error' => 'Failed to create donor. ' . $e->getMessage()]);
        }

        return redirect()->route('donors.index')
            ->with('success', 'Donor added successfully.');
    }

    public function show(Donor $donor)
    {
        return view('donors.show', compact('donor'));
    }

    public function edit(Donor $donor)
    {
        return view('donors.edit', compact('donor'));
    }

    public function update(Request $request, Donor $donor)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'contributions' => 'required|string',
            'impact' => 'required|string',
            'contact_email' => 'nullable|email|max:255',
            'contact_phone' => 'nullable|string|max:20',
            'website' => 'nullable|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('logo')) {
            // Delete old logo
            if ($donor->logo) {
                Storage::disk('public')->delete('donors/' . $donor->logo);
            }
            
            // Store new logo
            $logo = $request->file('logo');
            $filename = time() . '_' . $logo->getClientOriginalName();
            $path = $logo->storeAs('donors', $filename, 'public');
            $validatedData['logo'] = $filename;
        }

        $donor->update($validatedData);

        return redirect()->route('donors.show', $donor)
            ->with('success', 'Donor updated successfully.');
    }

    public function destroy(Donor $donor)
    {
        if ($donor->logo) {
            Storage::disk('public')->delete('donors/' . $donor->logo);
        }
        
        $donor->delete();

        return redirect()->route('donors.index')
            ->with('success', 'Donor deleted successfully.');
    }
}
