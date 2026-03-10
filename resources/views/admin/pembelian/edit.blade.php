@extends('layouts.admin.app')

@section('title','Edit Pembelian Stok')
@section('breadcrumb','Pembelian Stok')

@section('content')

<div class="card card-body">

<form action="{{ route('pembelian-stok.update',$data->id) }}" method="POST">
@csrf
@method('PUT')


<div class="form-group mb-3">

<label>Bahan Baku</label>

<select name="bahan_baku_id" class="form-control">

<option value="">-- Pilih Bahan --</option>

@foreach($bahan as $b)

<option value="{{ $b->id }}"
{{ $data->bahan_baku_id == $b->id ? 'selected' : '' }}>

{{ $b->nama_bahan }} ({{ $b->satuan }})

</option>

@endforeach

</select>

</div>


<div class="form-group mb-3">

<label>Jumlah Beli</label>

<input
type="number"
step="0.01"
name="jumlah_beli"
value="{{ $data->jumlah_beli }}"
class="form-control">

</div>


<div class="form-group mb-3">

<label>Harga Beli Satuan</label>

<input
type="number"
step="0.01"
name="harga_beli_satuan"
value="{{ $data->harga_beli_satuan }}"
class="form-control">

</div>


<div class="form-group mb-3">

<label>Tanggal Beli</label>

<input
type="date"
name="tanggal_beli"
value="{{ $data->tanggal_beli }}"
class="form-control">

</div>


<div class="form-group mb-3">

<label>Catatan</label>

<textarea
name="catatan"
class="form-control"
rows="3">{{ $data->catatan }}</textarea>

</div>


<button class="btn btn-primary">Update</button>

<a href="{{ route('pembelian-stok.index') }}"
class="btn btn-secondary">
Batal
</a>

</form>

</div>

@endsection