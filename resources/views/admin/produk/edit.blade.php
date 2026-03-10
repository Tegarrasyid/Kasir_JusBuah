@extends('layouts.admin.app')

@section('title','Edit Produk')
@section('breadcrumb','Produk')
@section('content')

    <div class="card card-body">
        <form action="{{ route('produk.update',$produk->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label>Nama Produk</label>
            <input type="text" name="nama_produk" class="form-control" value="{{ $produk->nama_produk }}">
        </div>

        <div class="form-group mb-3">
            <label>Kategori</label>
            <select name="kategori_id" class="form-control">
                @foreach($kategori as $k)
                <option value="{{ $k->id }}"
                    {{ $produk->kategori_id == $k->id ? 'selected' : '' }}>{{ $k->nama_kategori }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="form-group mb-3">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control">{{ $produk->deskripsi }}</textarea>
        </div>

        <div class="form-group mb-3">
            <label>Harga</label>
            <input type="number" name="harga_jual" class="form-control" value="{{ $produk->harga_jual }}">
        </div>

        <div class="form-group mb-3">
            @if($produk->foto)
                <img src="{{ asset('storage/'.$produk->foto) }}" width="80">
            @endif
            <input type="file" name="foto" class="form-control">
        </div>

        <div class="form-group mb-3">
            <label>Status</label>
            <select name="is_available" class="form-control">
                <option value="1" {{ $produk->is_available ? 'selected':'' }}>
                Tersedia
                </option>
                <option value="0" {{ !$produk->is_available ? 'selected':'' }}>
                Tidak Tersedia
                </option>
            </select>
        </div>

        <button class="btn btn-primary">Update</button>
        <a href="{{ route('produk.index') }}" class="btn btn-secondary">Batal</a>

        </form>
    </div>

@endsection