@extends('layouts.admin.app')

@section('title','Edit Resep')
@section('breadcrumb','Resep Produk')
@section('content')

    <div class="card card-body">
        <form action="{{ route('resep.update',$resep->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group mb-3">
                <label>Produk</label>
                <select name="produk_id" class="form-control">
                    @foreach($produk as $p)
                    <option value="{{ $p->id }}" {{ $resep->produk_id == $p->id ? 'selected' : '' }}>{{ $p->nama_produk }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mb-3">
                <label>Bahan Baku</label>
                <select name="bahan_baku_id" class="form-control">
                    @foreach($bahan as $b)
                    <option value="{{ $b->id }}" {{ $resep->bahan_baku_id == $b->id ? 'selected' : '' }}> {{ $b->nama_bahan }} ({{ $b->satuan }})</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mb-3">
                <label>Jumlah Dibutuhkan</label>
                <input type="number" step="0.01" name="jumlah_dibutuhkan" value="{{ $resep->jumlah_dibutuhkan }}" class="form-control">
            </div>

            <button class="btn btn-primary">Update</button>
            <a href="{{ route('resep.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>

@endsection