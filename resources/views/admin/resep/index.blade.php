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
      </div>
      <div class="card" style="padding:0;overflow:hidden">
        <div class="table-wrap">
          <table class="data-table">
            <thead><tr>
              <th>Ikon</th><th>Produk</th><th>Komposisi Bahan</th><th>Aksi</th>
            </tr></thead>
            <tbody id="recipes-tbody"></tbody>
          </table>
        </div>
      </div>
    </div>

@endsection