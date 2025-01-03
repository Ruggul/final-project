@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Manajemen Inventaris</h2>
    
    <div class="card mb-4">
        <div class="card-header">
            <h5>Daftar Barang</h5>
        </div>
        <div class="card-body">
            <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambahBarang">
                Tambah Barang Baru
            </button>

            <table class="table">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Stok</th>
                        <th>Satuan</th>
                        <th>Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($barang as $item)
                    <tr>
                        <td>{{ $item->kode_barang }}</td>
                        <td>{{ $item->nama_barang }}</td>
                        <td>{{ $item->category->name }}</td>
                        <td>{{ $item->stok }}</td>
                        <td>{{ $item->satuan }}</td>
                        <td>Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                        <td>
                            <button class="btn btn-sm btn-success" onclick="barangMasuk({{ $item->id }})">
                                Barang Masuk
                            </button>
                            <button class="btn btn-sm btn-warning" onclick="barangKeluar({{ $item->id }})">
                                Barang Keluar
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection