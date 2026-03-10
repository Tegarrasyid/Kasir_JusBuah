@extends('layouts.admin.app')

@section('title','Resep Produk')
@section('breadcrumb','Resep')
@section('content')

    <!-- =================== RESEP =================== -->
    <div class="resep-page">
      <div class="page-heading">
        <div class="page-heading-left">
          <h1>Manajemen Resep</h1>
          <p>Komposisi bahan baku untuk setiap produk</p>
        </div>
      </div>
      <div class="crud-toolbar">
        <div class="input-group">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
          <input id="recipe-search" type="text" placeholder="Cari resep produk..."/>
        </div>
        <div class="crud-actions">
          <a href="{{ route('resep.create') }}" class="btn btn-primary">
            <svg width="14" height="14" viewBox="0 0 24 24"
            fill="none" stroke="currentColor" stroke-width="2.5">
            <line x1="12" y1="5" x2="12" y2="19"/>
            <line x1="5" y1="12" x2="19" y2="12"/>
            </svg>
            Tambah Resep
          </a>
        </div>
      </div>
      <div class="card" style="padding:0;overflow:hidden">
        <div class="table-wrap">
          <table class="data-table">
            <thead><tr>
              <th>Produk</th><th>Komposisi Bahan</th><th>Aksi</th>
            </tr></thead>
            <tbody>
              @foreach($resep as $produk_id => $items)
                <tr>
                  <td>{{ $items->first()->produk->nama_produk }}</td>
                  <td> @foreach($items as $r)
                    <div>
                      @if($r->bahan)
                          {{ $r->bahan->nama_bahan }}
                          -
                          {{ $r->jumlah_dibutuhkan }}
                          {{ $r->bahan->satuan }}
                      @else
                          <span style="color:red">Bahan tidak ditemukan</span>
                      @endif
                    </div>
                    @endforeach
                  </td>

                  <td>
                    <a href="{{ route('resep.edit',$items->first()->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('resep.destroy',$items->first()->id) }}" method="POST" style="display:inline">
                      @csrf
                      @method('DELETE')
                      <button class="btn btn-danger btn-sm" onclick="return confirm('Hapus resep?')">Hapus</button>
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