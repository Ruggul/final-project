<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    /**
     * Menampilkan daftar dokumen
     */
    public function index()
    {
        $documents = Document::latest()->paginate(10);
        return view('documents.index', compact('documents'));
    }

    /**
     * Menampilkan form untuk membuat dokumen baru
     */
    public function create()
    {
        return view('Documents.create');
    }

    /**
     * Menyimpan dokumen baru ke database
     */
    public function store(Request $request)
    {
        $request->validate([
            'document_type' => 'required|string|max:255',
            'document_name' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
            'expiry_date' => 'nullable|date'
        ]);

        $file = $request->file('file');
        $path = $file->store('documents', 'public');

        Document::create([
            'document_type' => $request->document_type,
            'document_name' => $request->document_name,
            'file_path' => $path,
            'expiry_date' => $request->expiry_date
        ]);

        return redirect()->route('documents.index')
            ->with('success', 'Dokumen berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail dokumen
     */
    public function show(Document $document)
    {
        return view('documents.show', compact('document'));
    }

    /**
     * Menampilkan form untuk mengedit dokumen
     */
    public function edit(Document $document)
    {
        return view('documents.edit', compact('document'));
    }

    /**
     * Mengupdate dokumen di database
     */
    public function update(Request $request, Document $document)
    {
        $request->validate([
            'document_type' => 'required|string|max:255',
            'document_name' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
            'expiry_date' => 'nullable|date'
        ]);

        $data = [
            'document_type' => $request->document_type,
            'document_name' => $request->document_name,
            'expiry_date' => $request->expiry_date
        ];

        if ($request->hasFile('file')) {
            // Hapus file lama
            Storage::disk('public')->delete($document->file_path);
            
            // Upload file baru
            $file = $request->file('file');
            $data['file_path'] = $file->store('documents', 'public');
        }

        $document->update($data);

        return redirect()->route('documents.index')
            ->with('success', 'Dokumen berhasil diperbarui.');
    }

    /**
     * Menghapus dokumen dari database
     */
    public function destroy(Document $document)
    {
        // Hapus file fisik
        Storage::disk('public')->delete($document->file_path);
        
        // Hapus record dari database
        $document->delete();

        return redirect()->route('documents.index')
            ->with('success', 'Dokumen berhasil dihapus.');
    }
}