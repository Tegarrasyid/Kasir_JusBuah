@extends('layouts.admin.app')

@section('title','Tambah Resep')
@section('breadcrumb','Resep Produk')
@section('content')

    <div class="card card-body">
        <form action="{{ route('resep.store') }}" method="POST">
        @csrf

        <div class="form-group mb-3">
            <label>Produk</label>
            <select name="produk_id" class="form-control">
            <option value="">-- Pilih Produk --</option>
            @foreach($produk as $p)
                <option value="{{ $p->id }}">{{ $p->nama_produk }}</option>
            @endforeach
            </select>
        </div>

        <div class="form-group mb-3">
            <label>Bahan Baku</label>
            <select name="bahan_baku_id" class="form-control">
            <option value="">-- Pilih Bahan --</option>
                @foreach($bahan as $b)
                <option value="{{ $b->id }}">{{ $b->nama_bahan }} ({{ $b->satuan }})</option>
                @endforeach
            </select>
        </div>

        <div class="form-group mb-3">
            <label>Jumlah Dibutuhkan</label>
            <input type="number" step="0.01" name="jumlah_dibutuhkan" class="form-control">
        </div>

        <button class="btn btn-primary">Simpan</button>
        <a href="{{ route('resep.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>

@endsection