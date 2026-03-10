@extends('layouts.admin.app')

@section('title','Edit Kategori')
@section('breadcrumb','Kategori')
@section('content')

    <div class="card card-body">
        <form action="{{ route('kategori.update',$kategori->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
        <label>Nama Kategori</label>
        <input type="text" name="nama_kategori" class="form-control"
        value="{{ $kategori->nama_kategori }}">
        </div>

        <div class="form-group mb-3">
        <label>Deskripsi</label>
        <textarea name="deskripsi" class="form-control">{{ $kategori->deskripsi }}</textarea>
        </div>

        <button class="btn btn-primary">Update</button>
        <a href="{{ route('kategori.index') }}" class="btn btn-secondary">Batal</a>

        </form>
    </div>

@endsection