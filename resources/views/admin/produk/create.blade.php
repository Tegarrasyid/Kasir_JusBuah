@extends('layouts.admin.app')

@section('title','Tambah Produk')
@section('breadcrumb','Produk')
@section('content')

<div class="card card-body">
    <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="form-group mb-3">
            <label>Nama Produk</label>
            <input type="text" name="nama_produk" class="form-control">
        </div>

        <div class="form-group mb-3">
            <label>Kategori</label>
            <select name="kategori_id" class="form-control">
                <option value="">-- Pilih Kategori --</option>
                    @foreach($kategori as $k)
                    <option value="{{ $k->id }}">
                    {{ $k->nama_kategori }}
                </option>
                    @endforeach
            </select>
        </div>

        <div class="form-group mb-3">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control"></textarea>
        </div>

        <div class="form-group mb-3">
            <label>Harga Jual</label>
            <input type="number" name="harga_jual" class="form-control">
        </div>

        <div class="form-group">
            <label>Harga Beli</label>
            <input type="number" name="harga_beli" class="form-control">
        </div>

        <div class="form-group">
            <label>Harga Diskon</label>
            <input type="number" name="harga_diskon" class="form-control">
        </div>

        <div class="form-group mb-3">
            <label>Foto Produk</label>
            <input type="file" name="foto" class="form-control">
        </div>

        <div class="form-group mb-3">
            <label>Status</label>
            <select name="is_available" class="form-control">
                <option value="1">Tersedia</option>
                <option value="0">Tidak Tersedia</option>
            </select>
        </div>

        <button class="btn btn-primary">Simpan</button>
        <a href="{{ route('produk.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>

@endsection