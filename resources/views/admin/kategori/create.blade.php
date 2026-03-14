@extends('layouts.admin.app')

@section('title','Tambah Kategori')
@section('breadcrumb','Kategori')
@section('content')

<div class="card card-body">
    <form action="{{ route('kategori.store') }}" method="POST">
    @csrf

    <div class="form-group mb-3">
    <label>Nama Kategori</label>
    <input type="text" name="nama_kategori" class="form-control" placeholder="Masukan Nama Kategori">
    </div>

    <div class="form-group mb-3">
    <label>Deskripsi</label>
    <textarea name="deskripsi" class="form-control"></textarea>
    </div>

    <button class="btn btn-primary">Simpan</button>
    <a href="{{ route('kategori.index') }}" class="btn btn-secondary">Batal</a>

    </form>
</div>

@endsection