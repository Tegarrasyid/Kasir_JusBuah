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
          <button class="btn btn-primary" id="btn-add-restock">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Tambah Stok
          </button>
        </div>
      </div>
      <div id="low-stock-warn"></div>
      <div class="card">
        <div class="card-header">
          <div class="card-title">📦 Riwayat Penambahan Stok</div>
        </div>
        <div id="restock-log"></div>
      </div>
    </div>

@endsection