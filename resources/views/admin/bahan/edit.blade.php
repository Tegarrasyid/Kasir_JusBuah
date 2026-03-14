@extends('layouts.admin.app')

@section('title','Edit Bahan Baku')
@section('breadcrumb','Bahan Baku')
@section('content')

<div class="card card-body">
    <form action="{{ route('bahan-baku.update',$bahan->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label>Nama Bahan</label>
            <input type="text" name="nama_bahan" class="form-control" value="{{ $bahan->nama_bahan }}">
        </div>

        <div class="form-group mb-3">
            <label>Satuan</label>
            <input type="text" name="satuan" class="form-control" value="{{ $bahan->satuan }}">
        </div>

        <div class="form-group mb-3">
            <label>Harga Beli</label>
            <input type="number" name="harga_beli" class="form-control" value="{{ $bahan->harga_beli }}">
        </div>

        <div class="form-group mb-3">
            <label>Stok Tersedia</label>
            <input type="number" step="0.01" name="stok_tersedia" class="form-control" value="{{ $bahan->stok_tersedia }}">
        </div>

        <div class="form-group mb-3">
            <label>Stok Minimum</label>
            <input type="number" step="0.01" name="stok_minimum" class="form-control" value="{{ $bahan->stok_minimum }}">
        </div>

        <button class="btn btn-primary">Update</button>
        <a href="{{ route('bahan-baku.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>

@endsection