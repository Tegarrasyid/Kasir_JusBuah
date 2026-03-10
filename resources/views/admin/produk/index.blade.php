@extends('layouts.admin.app')

@section('title','Produk')
@section('breadcrumb','Produk')
@section('content')

    <!-- =================== PRODUCTS =================== -->
    <div class="produk-page">
      <div class="page-heading">
        <div class="page-heading-left">
          <h1>Manajemen Produk</h1>
          <p>Daftar produk yang dijual di kasir</p>
        </div>
      </div>
      <div class="crud-toolbar">
        <div class="input-group">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
          <input id="products-search" type="text" placeholder="Cari produk..."/>
        </div>
        <div class="crud-actions">
          <a href="{{ route('produk.create') }}" class="btn btn-primary" id="btn-add-product">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Tambah Produk
          </a>
        </div>
      </div>
      <div class="card" style="padding:0;overflow:hidden">
        <div class="table-wrap">
          <table class="data-table">
            <thead><tr>
              <th>Gambar Produk</th><th>Nama Produk</th><th>Kategori</th><th>Harga Jual</th><th>Stok</th><th>Aksi</th>
            </tr></thead>
            <tbody>
              @foreach($produk as $item)
              <tr>
                <td>
                @if($item->foto)
                <img src="{{ asset('storage/'.$item->foto) }}" width="40">
                @endif
                </td>
                <td>{{ $item->nama_produk }}</td>
                <td>{{ $item->kategori->nama_kategori ?? '-' }}</td>
                <td>Rp {{ number_format($item->harga_jual,0,',','.') }}</td>
                <td>
                  @if($item->is_available)
                  <span class="badge bg-success">Tersedia</span>
                  @else
                  <span class="badge bg-danger">Tidak tersedia</span>
                  @endif
                </td>
                <td>
                  <a href="{{ route('produk.edit',$item->id) }}" class="btn btn-warning btn-sm">
                    Edit
                  </a>
                  <form action="{{ route('produk.destroy',$item->id) }}" method="POST" style="display:inline">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm">
                      Hapus
                    </button>
                  </form>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>


@endsection