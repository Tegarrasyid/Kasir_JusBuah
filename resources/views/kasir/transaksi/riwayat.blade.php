@extends('layouts.kasir.app')

@section('title','Riwayat Transaksi')
@section('content')


  <!-- ============================
       TRANSAKSI PAGE
       ============================ -->
  <div class="transaksi-page" >
    <div class="page-heading">
      <div>
        <h2>Riwayat Transaksi</h2>
        <p>Semua transaksi yang telah diproses</p>
      </div>
    </div>

    <!-- Stats -->
    <div class="txn-stats">
      <div class="txn-stat-card" style="animation-delay:0.05s">
        <div class="txn-stat-label">Transaksi Hari Ini</div>
        <div class="txn-stat-value" id="stat-today-count">0</div>
        <div class="txn-stat-sub">pesanan</div>
      </div>
      <div class="txn-stat-card" style="animation-delay:0.10s">
        <div class="txn-stat-label">Pendapatan Hari Ini</div>
        <div class="txn-stat-value" id="stat-today-revenue">Rp 0</div>
        <div class="txn-stat-sub">total terkumpul</div>
      </div>
      <div class="txn-stat-card" style="animation-delay:0.15s">
        <div class="txn-stat-label">Total Transaksi</div>
        <div class="txn-stat-value" id="stat-total-txn">0</div>
        <div class="txn-stat-sub">semua waktu</div>
      </div>
      <div class="txn-stat-card" style="animation-delay:0.2s">
        <div class="txn-stat-label">Rata-rata Nilai</div>
        <div class="txn-stat-value" id="stat-avg-value">Rp 0</div>
        <div class="txn-stat-sub">per transaksi</div>
      </div>
    </div>

    <!-- Table -->
    <div class="txn-table-wrap">
      <div class="txn-table-header">
        <span class="txn-table-title">📋 Daftar Transaksi</span>
        <div class="txn-filter-row">
          <button class="txn-filter-btn active" data-filter="semua">Semua</button>
          <button class="txn-filter-btn" data-filter="hari_ini">Hari Ini</button>
        </div>
      </div>
      <table class="txn-table">
        <thead>
          <tr>
            <th>No. Order</th>
            <th>Waktu</th>
            <th>Item</th>
            <th>Pembayaran</th>
            <th>Total</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody id="txn-tbody">
          <tr><td colspan="7" style="text-align:center;padding:40px;color:var(--text-light)">Belum ada transaksi</td></tr>
        </tbody>
      </table>
    </div>
  </div>

  <script src="{{ asset('js/transactions.js') }}"></script>

  <script>
  document.addEventListener("DOMContentLoaded", function(){
      TransactionPage.init();
  });
  </script>

@endsection