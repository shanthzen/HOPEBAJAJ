<?php

namespace App\Http\Controllers;

use App\Models\GraduatedStudent;
use Illuminate\Http\Request;

class GraduatedStudentController extends Controller
{
    public function index()
    {
        $graduates = GraduatedStudent::all();
        return view('graduates.index', compact('graduates'));
    }

    public function create()
    {
        return view('graduates.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'batch_no' => 'required',
            'certificate_no' => 'required|unique:graduated_students',
            'name' => 'required',
            'phone_number' => 'required',
            'aadhar_no' => 'required|unique:graduated_students',
            'course_name' => 'required',
            'course_duration' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'total_days_attended' => 'required|integer|min:1',
            'certificate' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048'
        ]);

        if ($request->hasFile('certificate')) {
            $certificatePath = $request->file('certificate')->store('certificates', 'public');
            $validated['certificate_path'] = $certificatePath;
        }

        GraduatedStudent::create($validated);

        return redirect()->route('graduates.index')
            ->with('success', 'Graduate record created successfully.');
    }

    public function edit(GraduatedStudent $graduate)
    {
        return view('graduates.edit', compact('graduate'));
    }

    public function update(Request $request, GraduatedStudent $graduate)
    {
        $validated = $request->validate([
            'batch_no' => 'required',
            'certificate_no' => 'required|unique:graduated_students,certificate_no,'.$graduate->id,
            'name' => 'required',
            'phone_number' => 'required',
            'aadhar_no' => 'required|unique:graduated_students,aadhar_no,'.$graduate->id,
            'course_name' => 'required',
            'course_duration' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'total_days_attended' => 'required|integer|min:1',
            'certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048'
        ]);

        if ($request->hasFile('certificate')) {
            $certificatePath = $request->file('certificate')->store('certificates', 'public');
            $validated['certificate_path'] = $certificatePath;
        }

        $graduate->update($validated);

        return redirect()->route('graduates.index')
            ->with('success', 'Graduate record updated successfully.');
    }

    public function destroy(GraduatedStudent $graduate)
    {
        $graduate->delete();

        return redirect()->route('graduates.index')
            ->with('success', 'Graduate record deleted successfully.');
    }
}
