@extends('layouts.admin.app')

@section('title','Kategori')
@section('breadcrumb','Kategori')
@section('content')

    <!-- =================== CATEGORIES =================== -->
    <div class="kategori-page">
      <div class="page-heading">
        <div class="page-heading-left">
          <h1>Manajemen Kategori</h1>
          <p>Atur kategori produk yang dijual di kasir</p>
        </div>
      </div>
      <div class="crud-toolbar">
        <div class="input-group">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
          <input id="cats-search" type="text" placeholder="Cari kategori..."/>
        </div>
        <div class="crud-actions">
          <button class="btn btn-primary" id="btn-add-cat">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Tambah Kategori
          </button>
        </div>
      </div>
      <div class="card" style="padding:0;overflow:hidden">
        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                    <th>Ikon</th>
                    <th>Nama Kategori</th>
                    <th>Deskripsi</th>
                    <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($kategori as $k)
                    <tr>
                        <td>{{ $k->icon ?? '-' }}</td>
                        <td>{{ $k->nama_kategori }}</td>
                        <td>{{ $k->deskripsi ?? '-' }}</td>
                        <td>
                            <a href="{{ route('kategori.edit',$k->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center">
                            Data masih kosong
                        </td>
                    </tr>
                    @endforelse
                    </tbody>
            </table>
        </div>
      </div>
    </div>


@endsection