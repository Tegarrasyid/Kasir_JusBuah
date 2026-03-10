@extends('layouts.admin.app')

@section('title','Bahan Baku')
@section('breadcrumb','Bahan Baku')
@section('content')

    <!-- =================== BAHAN BAKU =================== -->
    <div class="bahan-page">
      <div class="page-heading">
        <div class="page-heading-left">
          <h1>Manajemen Bahan Baku</h1>
          <p>Stok dan inventaris bahan baku</p>
        </div>
      </div>
      <div class="crud-toolbar">
        <div class="input-group">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
          <input id="ing-search" type="text" placeholder="Cari bahan baku..."/>
        </div>
        <div class="crud-actions">
          <a href="{{ route('bahan-baku.create') }}" class="btn btn-primary" id="btn-add-ing">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Tambah Bahan
          </a>
        </div>
      </div>
      <div class="card" style="padding:0;overflow:hidden">
        <div class="table-wrap">
          <table class="data-table">
            <thead><tr>
              <th>Nama Bahan</th><th>Satuan</th><th>Stok Saat Ini</th><th>Stok Min.</th><th>Harga/Satuan</th><th>Aksi</th>
            </tr></thead>
              <tbody >
                @foreach($bahan as $b)
                <tr>
                  <td>{{ $b->nama_bahan }}</td>
                  <td>{{ $b->satuan }}</td>
                  <td>
                    @if($b->stok_tersedia <= $b->stok_minimum)
                    <span class="badge bg-danger">{{ $b->stok_tersedia }}</span>
                    @else
                    <span class="badge bg-success">{{ $b->stok_tersedia }}</span>
                    @endif
                  </td>
                  <td>{{ $b->stok_minimum }}</td>
                  <td>Rp {{ number_format($b->harga_beli,0,',','.') }}</td>
                  <td>
                    <a href="{{ route('bahan-baku.edit',$b->id) }}" class="btn btn-warning btn-sm">Edit</a>

                    <form action="{{ route('bahan-baku.destroy',$b->id) }}" method="POST" style="display:inline;">
                      @csrf
                      @method('DELETE')
                      <button class="btn btn-danger btn-sm" onclick="return confirm('Hapus bahan ini?')">Hapus</button>
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