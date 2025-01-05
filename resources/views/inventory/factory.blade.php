@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Tambah Dokumen Baru</h5>
                <a href="{{ route('documents.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>

            <div class="card-body">
                <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Tipe Dokumen -->
                    <div class="mb-3">
                        <label for="document_type" class="form-label">Tipe Dokumen</label>
                        <input type="text" 
                               class="form-control @error('document_type') is-invalid @enderror" 
                               id="document_type" 
                               name="document_type" 
                               value="{{ old('document_type') }}" 
                               required>
                        @error('document_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Nama Dokumen -->
                    <div class="mb-3">
                        <label for="document_name" class="form-label">Nama Dokumen</label>
                        <input type="text" 
                               class="form-control @error('document_name') is-invalid @enderror" 
                               id="document_name" 
                               name="document_name" 
                               value="{{ old('document_name') }}" 
                               required>
                        @error('document_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- File Upload -->
                    <div class="mb-3">
                        <label for="file" class="form-label">File Dokumen</label>
                        <input type="file" 
                               class="form-control @error('file') is-invalid @enderror" 
                               id="file" 
                               name="file" 
                               required>
                        <div class="form-text">Format yang diperbolehkan: PDF, DOC, DOCX, JPG, JPEG, PNG (maksimal 2MB)</div>
                        @error('file')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Tanggal Kadaluarsa -->
                    <div class="mb-3">
                        <label for="expiry_date" class="form-label">Tanggal Kadaluarsa (Opsional)</label>
                        <input type="date" 
                               class="form-control @error('expiry_date') is-invalid @enderror" 
                               id="expiry_date" 
                               name="expiry_date" 
                               value="{{ old('expiry_date') }}">
                        @error('expiry_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Tombol Submit -->
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('documents.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Dokumen
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection