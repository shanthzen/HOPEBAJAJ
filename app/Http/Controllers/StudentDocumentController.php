<?php

namespace App\Http\Controllers;

use App\Models\StudentDocument;
use App\Models\EnrolledStudent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class StudentDocumentController extends Controller
{
    public function index(EnrolledStudent $student)
    {
        $documents = $student->documents()->latest()->get();
        $documentTypes = StudentDocument::DOCUMENT_TYPES;
        
        return view('documents.index', compact('student', 'documents', 'documentTypes'));
    }

    public function store(Request $request, EnrolledStudent $student)
    {
        $request->validate([
            'document_type' => 'required|string|in:' . implode(',', array_keys(StudentDocument::DOCUMENT_TYPES)),
            'document' => 'required|file|max:10240', // Max 10MB
            'document_name' => 'required|string|max:255',
        ]);

        try {
            $file = $request->file('document');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs(
                'student_documents/' . $student->id,
                $fileName,
                'public'
            );

            $document = $student->documents()->create([
                'document_type' => $request->document_type,
                'document_name' => $request->document_name,
                'file_path' => $filePath,
                'file_type' => $file->getClientMimeType(),
                'file_size' => $file->getSize(),
                'verification_status' => 'pending'
            ]);

            return redirect()
                ->route('students.documents.index', $student)
                ->with('success', 'Document uploaded successfully.');
        } catch (\Exception $e) {
            return redirect()
                ->route('students.documents.index', $student)
                ->with('error', 'Failed to upload document: ' . $e->getMessage());
        }
    }

    public function download(StudentDocument $document)
    {
        if (!Storage::disk('public')->exists($document->file_path)) {
            return redirect()->back()->with('error', 'Document file not found.');
        }

        return Storage::disk('public')->download(
            $document->file_path,
            $document->document_name . '.' . pathinfo($document->file_path, PATHINFO_EXTENSION)
        );
    }

    public function verify(Request $request, StudentDocument $document)
    {
        $request->validate([
            'verification_notes' => 'nullable|string|max:1000'
        ]);

        try {
            $document->verify(Auth::user(), $request->verification_notes);
            return redirect()->back()->with('success', 'Document verified successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to verify document: ' . $e->getMessage());
        }
    }

    public function reject(Request $request, StudentDocument $document)
    {
        $request->validate([
            'verification_notes' => 'required|string|max:1000'
        ]);

        try {
            $document->reject(Auth::user(), $request->verification_notes);
            return redirect()->back()->with('success', 'Document rejected successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to reject document: ' . $e->getMessage());
        }
    }

    public function destroy(StudentDocument $document)
    {
        try {
            // Delete file from storage
            if (Storage::disk('public')->exists($document->file_path)) {
                Storage::disk('public')->delete($document->file_path);
            }

            // Delete database record
            $document->delete();

            return redirect()->back()->with('success', 'Document deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete document: ' . $e->getMessage());
        }
    }
}
