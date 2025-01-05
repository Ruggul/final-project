<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DocumentController extends Controller
{
    /**
     * Display a listing of the documents.
     */
    public function index()
    {
        $documents = Document::latest()->paginate(10);
        return view('user.userAccount.document', compact('documents'));
    }

    /**
     * Show the form for creating a new document.
     */
    public function create()
    {
        $documentTypes = [
            'SOP' => 'Standard Operating Procedure',
            'Manual' => 'Manual Book',
            'Report' => 'Report Document',
            'Form' => 'Form Document',
            'Other' => 'Other Document'
        ];
        return view('user.userAccount.document-create', compact('documentTypes'));
    }

    /**
     * Store a newly created document in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'document_type' => 'required|string|max:255',
            'document_name' => 'required|string|max:255',
            'document_file' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
            'expiry_date' => 'nullable|date|after:today',
        ]);

        try {
            // Generate unique filename
            $fileName = time() . '_' . Str::slug($request->document_name) . '.' . 
                       $request->file('document_file')->getClientOriginalExtension();

            // Handle file upload
            $filePath = $request->file('document_file')->storeAs(
                'documents',
                $fileName,
                'public'
            );

            // Create document record
            Document::create([
                'document_type' => $request->document_type,
                'document_name' => $request->document_name,
                'file_path' => $filePath,
                'expiry_date' => $request->expiry_date,
            ]);

            return redirect()->route('documents.index')
                           ->with('success', 'Document berhasil diunggah.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengunggah dokumen.')
                        ->withInput();
        }
    }

    /**
     * Display the specified document.
     */
    public function show(Document $document)
    {
        if (!Storage::disk('public')->exists($document->file_path)) {
            return back()->with('error', 'File dokumen tidak ditemukan.');
        }

        return view('user.userAccount.document-show', compact('document'));
    }

    /**
     * Show the form for editing the specified document.
     */
    public function edit(Document $document)
    {
        $documentTypes = [
            'SOP' => 'Standard Operating Procedure',
            'Manual' => 'Manual Book',
            'Report' => 'Report Document',
            'Form' => 'Form Document',
            'Other' => 'Other Document'
        ];
        return view('user.userAccount.document-edit', compact('document', 'documentTypes'));
    }

    /**
     * Update the specified document in storage.
     */
    public function update(Request $request, Document $document)
    {
        $request->validate([
            'document_type' => 'required|string|max:255',
            'document_name' => 'required|string|max:255',
            'document_file' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
            'expiry_date' => 'nullable|date|after:today',
        ]);

        try {
            $updateData = [
                'document_type' => $request->document_type,
                'document_name' => $request->document_name,
                'expiry_date' => $request->expiry_date,
            ];

            // Handle file upload if new file is provided
            if ($request->hasFile('document_file')) {
                // Delete old file
                if (Storage::disk('public')->exists($document->file_path)) {
                    Storage::disk('public')->delete($document->file_path);
                }
                
                // Generate unique filename
                $fileName = time() . '_' . Str::slug($request->document_name) . '.' . 
                           $request->file('document_file')->getClientOriginalExtension();

                // Store new file
                $filePath = $request->file('document_file')->storeAs(
                    'documents',
                    $fileName,
                    'public'
                );

                $updateData['file_path'] = $filePath;
            }

            // Update document record
            $document->update($updateData);

            return redirect()->route('documents.index')
                           ->with('success', 'Document berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui dokumen.')
                        ->withInput();
        }
    }

    /**
     * Remove the specified document from storage.
     */
    public function destroy(Document $document)
    {
        try {
            // Delete file from storage
            if (Storage::disk('public')->exists($document->file_path)) {
                Storage::disk('public')->delete($document->file_path);
            }
            
            // Delete document record
            $document->delete();

            return redirect()->route('documents.index')
                           ->with('success', 'Document berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus dokumen.');
        }
    }
}