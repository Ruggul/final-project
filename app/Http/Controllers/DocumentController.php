<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    /**
     * Display a listing of the documents.
     */
    public function index()
    {
        $documents = Document::latest()->get();
        return view('user.userAccount.document', compact('documents'));
    }

    /**
     * Show the form for creating a new document.
     */
    public function create()
    {
        return view('user.userAccount.document-create');
    }

    /**
     * Store a newly created document in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'document_type' => 'required|string|max:255',
            'document_name' => 'required|string|max:255',
            'document_file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'expiry_date' => 'nullable|date|after:today',
        ]);

        try {
            // Handle file upload
            $filePath = $request->file('document_file')->store('documents', 'public');

            // Create document record
            Document::create([
                'document_type' => $request->document_type,
                'document_name' => $request->document_name,
                'file_path' => $filePath,
                'expiry_date' => $request->expiry_date,
            ]);

            return redirect()->route('documents.index')
                           ->with('success', 'Document uploaded successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to upload document. Please try again.');
        }
    }

    /**
     * Display the specified document.
     */
    public function show(Document $document)
    {
        return view('user.userAccount.document-show', compact('document'));
    }

    /**
     * Show the form for editing the specified document.
     */
    public function edit(Document $document)
    {
        return view('user.userAccount.document-edit', compact('document'));
    }

    /**
     * Update the specified document in storage.
     */
    public function update(Request $request, Document $document)
    {
        $request->validate([
            'document_type' => 'required|string|max:255',
            'document_name' => 'required|string|max:255',
            'document_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'expiry_date' => 'nullable|date|after:today',
        ]);

        try {
            // Handle file upload if new file is provided
            if ($request->hasFile('document_file')) {
                // Delete old file
                Storage::disk('public')->delete($document->file_path);
                
                // Store new file
                $filePath = $request->file('document_file')->store('documents', 'public');
                $document->file_path = $filePath;
            }

            // Update document record
            $document->update([
                'document_type' => $request->document_type,
                'document_name' => $request->document_name,
                'expiry_date' => $request->expiry_date,
            ]);

            return redirect()->route('documents.index')
                           ->with('success', 'Document updated successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update document. Please try again.');
        }
    }

    /**
     * Remove the specified document from storage.
     */
    public function destroy(Document $document)
    {
        try {
            // Delete file from storage
            Storage::disk('public')->delete($document->file_path);
            
            // Delete document record
            $document->delete();

            return redirect()->route('documents.index')
                           ->with('success', 'Document deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete document. Please try again.');
        }
    }
}