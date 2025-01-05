@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <!-- Header Section -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-primary"><i class="fas fa-folder-plus me-2"></i>Manajemen Dokumen</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                        <li class="breadcrumb-item">Dokumen</li>
                        <li class="breadcrumb-item active">Buat Baru</li>
                    </ol>
                </nav>
            </div>

            <div class="card shadow-lg border-0">
                <div class="card-header bg-gradient-primary text-white py-3">
                    <div class="d-flex align-items-center">
                        <span class="rounded-circle bg-white p-2 me-3">
                            <i class="fas fa-file-alt text-primary"></i>
                        </span>
                        <h4 class="mb-0">Buat Dokumen Baru</h4>
                    </div>
                </div>

                <div class="card-body p-4">
                    <form method="POST" action="#" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Progress Bar -->
                        <div class="progress mb-4" style="height: 3px;">
                            <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                        </div>

                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="judul" class="form-label fw-bold">
                                        <i class="fas fa-heading me-2 text-primary"></i>Judul Dokumen
                                    </label>
                                    <input type="text" class="form-control form-control-lg shadow-sm" 
                                           id="judul" name="judul" required 
                                           placeholder="Masukkan judul dokumen">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="jenis" class="form-label fw-bold">
                                        <i class="fas fa-tags me-2 text-primary"></i>Jenis Dokumen
                                    </label>
                                    <select class="form-select form-select-lg shadow-sm" id="jenis" name="jenis" required>
                                        <option value="">Pilih Jenis Dokumen</option>
                                        <option value="surat_jalan">📝 Surat Jalan</option>
                                        <option value="invoice">💰 Invoice</option>
                                        <option value="laporan">📊 Laporan</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="keterangan" class="form-label fw-bold">
                                        <i class="fas fa-info-circle me-2 text-primary"></i>Keterangan
                                    </label>
                                    <textarea class="form-control shadow-sm" 
                                            id="keterangan" name="keterangan" 
                                            rows="4" 
                                            placeholder="Tambahkan keterangan detail tentang dokumen"></textarea>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="published_at" class="form-label fw-bold">
                                        <i class="fas fa-calendar-alt me-2 text-primary"></i>Tanggal Publikasi
                                    </label>
                                    <input type="date" class="form-control shadow-sm" id="published_at" name="published_at">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="expiry_date" class="form-label fw-bold">
                                        <i class="fas fa-calendar-times me-2 text-primary"></i>Tanggal Kadaluarsa
                                    </label>
                                    <input type="date" class="form-control shadow-sm" id="expiry_date" name="expiry_date">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group upload-area p-4 bg-light rounded-3 text-center">
                                    <label for="file" class="form-label">
                                        <i class="fas fa-cloud-upload-alt fa-3x mb-3 text-primary"></i>
                                        <h5 class="fw-bold">Upload File Dokumen</h5>
                                        <p class="text-muted">Drag & drop file atau klik untuk memilih</p>
                                    </label>
                                    <input type="file" class="form-control d-none" id="file" name="file">
                                    <small class="d-block text-muted mt-2">
                                        <i class="fas fa-info-circle"></i>
                                        Format yang didukung: PDF, DOC, DOCX, XLS, XLSX (Max. 5MB)
                                    </small>
                                </div>
                            </div>
                        </div>

                        <div class="form-group d-flex gap-2 justify-content-between mt-5">
                            <a href="#" class="btn btn-light btn-lg px-4 shadow-sm">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                            <div>
                                <button type="reset" class="btn btn-secondary btn-lg px-4 me-2">
                                    <i class="fas fa-redo me-2"></i>Reset
                                </button>
                                <button type="submit" class="btn btn-primary btn-lg px-4 shadow-sm">
                                    <i class="fas fa-save me-2"></i>Simpan Dokumen
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-gradient-primary {
        background: linear-gradient(45deg, #4e73df, #224abe);
    }

    .card {
        border-radius: 15px;
        overflow: hidden;
    }

    .form-control, .form-select {
        border-radius: 10px;
        padding: 0.8rem;
        border: 1px solid #e0e0e0;
        transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: #4e73df;
        box-shadow: 0 0 0 0.25rem rgba(78, 115, 223, 0.1);
    }

    .btn {
        border-radius: 10px;
        padding: 0.8rem 1.5rem;
        transition: all 0.3s ease;
    }

    .btn-primary {
        background: #4e73df;
        border: none;
    }

    .btn-primary:hover {
        background: #224abe;
        transform: translateY(-2px);
    }

    .upload-area {
        border: 2px dashed #4e73df;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .upload-area:hover {
        border-color: #224abe;
        background: #f8f9fc;
    }

    .progress-bar {
        background: linear-gradient(45deg, #4e73df, #224abe);
        height: 3px;
    }

    .shadow-hover {
        transition: all 0.3s ease;
    }

    .shadow-hover:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }
</style>

<script>
document.querySelector('.upload-area').addEventListener('click', function() {
    document.getElementById('file').click();
});

document.getElementById('file').addEventListener('change', function() {
    // Update progress bar when file is selected
    let progress = document.querySelector('.progress-bar');
    progress.style.width = '100%';
});
</script>

@endsection