@extends('layouts.admin.app')

@section('title','Tambah Bahan Baku')
@section('breadcrumb','Bahan Baku')
@section('content')

<div class="card card-body">
    <form action="{{ route('bahan-baku.store') }}" method="POST">
        @csrf

        <div class="form-group mb-3">
            <label>Nama Bahan</label>
            <input type="text" name="nama_bahan" class="form-control">
        </div>

        <div class="form-group mb-3">
            <label>Satuan</label>
            <input type="text" name="satuan" class="form-control">
        </div>

        <div class="form-group mb-3">
            <label>Harga Beli</label>
            <input type="number" name="harga_beli" class="form-control">
        </div>

        <div class="form-group mb-3">
            <label>Stok Tersedia</label>
            <input type="number" step="0.01" name="stok_tersedia" class="form-control">
        </div>

        <div class="form-group mb-3">
            <label>Stok Minimum</label>
            <input type="number" step="0.01" name="stok_minimum" class="form-control">
        </div>

        <button class="btn btn-primary">Simpan</button>
        <a href="{{ route('bahan-baku.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>

@endsection