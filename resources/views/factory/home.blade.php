@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Manajemen Inventaris</h2>
    
    <div class="card mb-4">
        <div class="card-header">
            <h5>Daftar Barang</h5>
        </div>
        <div class="card-body">
            {{-- Debug: Uncomment baris di bawah untuk mengecek data --}}
            {{-- @if(isset($barang)) {{ print_r($barang) }} @endif --}}

            <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambahBarang">
                Tambah Barang Baru
            </button>

            <table class="table">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama Barang</th>
                        <th>Stok</th>
                        <th>Satuan</th>
                        <th>Harga</th>
                        <th>Lokasi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($barang) && count($barang) > 0)
                        @foreach($barang as $item)
                            <tr>
                                <td>{{ $item->kode_barang }}</td>
                                <td>{{ $item->nama_barang }}</td>
                                <td>{{ $item->stok }}</td>
                                <td>{{ $item->satuan }}</td>
                                <td>Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                                <td>{{ $item->lokasi_penyimpanan }}</td>
                                <td>
                                    <button class="btn btn-sm btn-success" onclick="barangMasuk({{ $item->id }})">
                                        Masuk
                                    </button>
                                    <button class="btn btn-sm btn-warning" onclick="barangKeluar({{ $item->id }})">
                                        Keluar
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada data barang</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection