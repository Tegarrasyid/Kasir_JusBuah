@extends('layouts.admin.app')

@section('title','Pembelian Stok')
@section('breadcrumb','Pembelian Stok')
@section('content')

    <!-- =================== PEMBELIAN STOK =================== -->
    <div class="pembelian-page">
      <div class="page-heading">
        <div class="page-heading-left">
          <h1>Tambah Stok Bahan Baku</h1>
          <p>Catat penambahan dan penerimaan stok bahan baku</p>
        </div>
        <div class="page-actions">
          <a href="{{ route('pembelian-stok.create') }}" class="btn btn-primary" id="btn-add-restock">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Tambah Stok
          </a>
        </div>
      </div>
      <div id="low-stock-warn"></div>
      <div class="card">
        <div class="card-header">
          <div class="card-title">📦 Riwayat Penambahan Stok</div>
        </div>
        <div class="card" style="padding:0;overflow:hidden">
          <div class="table-wrap">
            <table class="data-table">
            <thead>
              <tr>
              <th>No</th>
              <th>Bahan</th>
              <th>Jumlah</th>
              <th>Harga Satuan</th>
              <th>Total</th>
              <th>Tanggal</th>
              <th>Aksi</th>
              </tr>
              </thead>

              <tbody>
                @foreach($data as $d)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $d->bahan->nama_bahan }}</td>
                    <td>{{ $d->jumlah_beli }}</td>
                    <td>Rp {{ number_format($d->harga_beli_satuan) }}</td>
                    <td>Rp {{ number_format($d->total_harga) }}</td>
                    <td>{{ $d->tanggal_beli }}</td>
                    <td>
                      <a href="{{ route('pembelian-stok.edit',$d->id) }}"class="btn btn-warning btn-sm">Edit</a>
                      <form action="{{ route('pembelian-stok.destroy',$d->id) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">Hapus</button>
                      </form>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>      
      </div>
    </div>

@endsection