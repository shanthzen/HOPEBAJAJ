<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\EnrolledStudent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index()
    {
        $documents = Document::with('student')->latest()->paginate(10);
        return view('documents.index', compact('documents'));
    }

    public function create()
    {
        $students = EnrolledStudent::all();
        return view('documents.create', compact('students'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:enrolled_students,id',
            'type' => 'required|string',
            'document' => 'required|file|mimes:pdf,doc,docx|max:2048',
            'issued_at' => 'required|date',
        ]);

        $file = $request->file('document');
        $path = $file->store('documents');

        Document::create([
            'student_id' => $request->student_id,
            'type' => $request->type,
            'file_path' => $path,
            'original_name' => $file->getClientOriginalName(),
            'issued_at' => $request->issued_at,
        ]);

        return redirect()->route('documents.index')
            ->with('success', 'Document uploaded successfully');
    }

    public function destroy(Document $document)
    {
        Storage::delete($document->file_path);
        $document->delete();

        return redirect()->route('documents.index')
            ->with('success', 'Document deleted successfully');
    }
}
