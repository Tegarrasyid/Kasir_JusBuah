@extends('layouts.admin.app')

@section('title','Dashboard Admin')
@section('breadcrumb','Dashboard')
@section('content')


    <!-- =================== DASHBOARD =================== -->
    <div class="dashboard-page">
      <div class="page-heading">
        <div class="page-heading-left">
          <h1 id="page-h1">Dashboard</h1>
          <p id="page-sub">Ringkasan performa & statistik penjualan</p>
        </div>
        <div class="page-actions">
          <div class="period-selector">
            <button class="period-btn" data-period="day">Hari Ini</button>
            <button class="period-btn active" data-period="week">7 Hari</button>
            <button class="period-btn" data-period="month">30 Hari</button>
          </div>
        </div>
      </div>

      <!-- Stat Cards -->
      <div class="stat-grid">
        <div class="stat-card" id="stat-revenue" style="--card-accent:var(--emerald-dim);animation-delay:0.05s">
          <div class="stat-icon-wrap">
            <div class="stat-icon" style="background:var(--emerald-dim)">💰</div>
            <span class="stat-trend trend-up">▲ 0%</span>
          </div>
          <div class="stat-value">Rp 0</div>
          <div class="stat-label">Total Pendapatan</div>
          <div class="stat-sub">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            Dibanding periode sebelumnya
          </div>
        </div>
        <div class="stat-card" id="stat-orders" style="--card-accent:var(--blue-dim);animation-delay:0.10s">
          <div class="stat-icon-wrap">
            <div class="stat-icon" style="background:var(--blue-dim)">🧾</div>
            <span class="stat-trend trend-up">▲ 0%</span>
          </div>
          <div class="stat-value">0</div>
          <div class="stat-label">Jumlah Transaksi</div>
          <div class="stat-sub">Seluruh transaksi kasir</div>
        </div>
        <div class="stat-card" id="stat-items" style="--card-accent:var(--purple-dim);animation-delay:0.15s">
          <div class="stat-icon-wrap">
            <div class="stat-icon" style="background:var(--purple-dim)">📦</div>
            <span class="stat-trend trend-up">▲ 0%</span>
          </div>
          <div class="stat-value">0</div>
          <div class="stat-label">Item Terjual</div>
          <div class="stat-sub">Total porsi/pcs terjual</div>
        </div>
        <div class="stat-card" id="stat-avg" style="--card-accent:var(--amber-dim);animation-delay:0.20s">
          <div class="stat-icon-wrap">
            <div class="stat-icon" style="background:var(--amber-dim)">📈</div>
            <span class="stat-trend trend-up">▲ 0%</span>
          </div>
          <div class="stat-value">Rp 0</div>
          <div class="stat-label">Rata-rata / Order</div>
          <div class="stat-sub">Nilai rata-rata transaksi</div>
        </div>
      </div>

      <!-- Chart Row -->
      <div class="chart-row">
        <div class="card" style="animation-delay:0.25s">
          <div class="card-header">
            <div>
              <div class="card-title">Grafik Pendapatan</div>
              <div class="card-subtitle">Berdasarkan periode yang dipilih</div>
            </div>
          </div>
          <div class="chart-area" id="bar-chart"></div>
          <div class="chart-legend">
            <div class="legend-item"><span class="legend-dot" style="background:var(--emerald)"></span>Pendapatan</div>
          </div>
        </div>
        <div class="card" style="animation-delay:0.3s">
          <div class="card-header">
            <div>
              <div class="card-title">Komposisi Kategori</div>
              <div class="card-subtitle">Berdasarkan pendapatan</div>
            </div>
          </div>
          <div class="donut-wrap">
            <svg id="donut-svg" class="donut-svg" width="120" height="120"></svg>
          </div>
          <div class="donut-legend" id="donut-legend"></div>
        </div>
      </div>

      <!-- Bottom Row -->
      <div class="bottom-row">
        <div class="card" style="animation-delay:0.35s">
          <div class="card-header">
            <div class="card-title">🏆 Produk Terlaris</div>
            <span style="font-size:0.78rem;color:var(--text-muted)">Top 6</span>
          </div>
          <div class="product-rank-list" id="top-products-list"></div>
        </div>
        <div class="card" style="animation-delay:0.4s">
          <div class="card-header">
            <div class="card-title">🧾 Transaksi Terakhir</div>
          </div>
          <div class="recent-txn-list" id="recent-txn-list"></div>
        </div>
      </div>
    </div>

    <!-- =================== REPORTS =================== -->
    <div class="page" id="page-reports">
      <div class="page-heading">
        <div class="page-heading-left">
          <h1>Laporan Penjualan</h1>
          <p>Analisa transaksi dan performa kasir</p>
        </div>
        <div class="page-actions">
          <div class="period-selector">
            <button class="report-period-btn" data-period="day">Hari Ini</button>
            <button class="report-period-btn active" data-period="week">7 Hari</button>
            <button class="report-period-btn" data-period="month">30 Hari</button>
          </div>
        </div>
      </div>

      <!-- Summary cards -->
      <div class="report-summary-grid">
        <div class="report-card" style="animation-delay:0.05s">
          <div class="report-card-label">Total Pendapatan</div>
          <div class="report-card-value" id="report-revenue">Rp 0</div>
          <div class="report-card-sub">Setelah pajak & diskon</div>
        </div>
        <div class="report-card" style="animation-delay:0.10s">
          <div class="report-card-label">Total Transaksi</div>
          <div class="report-card-value" id="report-orders">0</div>
          <div class="report-card-sub">Seluruh kasir</div>
        </div>
        <div class="report-card" style="animation-delay:0.15s">
          <div class="report-card-label">Item Terjual</div>
          <div class="report-card-value" id="report-items">0</div>
          <div class="report-card-sub">Total porsi/pcs</div>
        </div>
        <div class="report-card" style="animation-delay:0.20s">
          <div class="report-card-label">Rata-rata Transaksi</div>
          <div class="report-card-value" id="report-avg">Rp 0</div>
          <div class="report-card-sub">Per order</div>
        </div>
        <div class="report-card" style="animation-delay:0.25s">
          <div class="report-card-label">Total Pajak (10%)</div>
          <div class="report-card-value" id="report-tax">Rp 0</div>
          <div class="report-card-sub">PPN terkumpul</div>
        </div>
        <div class="report-card" style="animation-delay:0.30s">
          <div class="report-card-label">Total Diskon</div>
          <div class="report-card-value" id="report-disc">Rp 0</div>
          <div class="report-card-sub">Diskon diberikan</div>
        </div>
      </div>

      <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:20px">
        <!-- Payment breakdown -->
        <div class="card">
          <div class="card-header"><div class="card-title">💳 Breakdown Pembayaran</div></div>
          <div class="table-wrap">
            <table class="data-table">
              <thead><tr><th>Metode</th><th>Transaksi</th><th>Total</th><th>%</th></tr></thead>
              <tbody id="report-payment-table"></tbody>
            </table>
          </div>
        </div>

        <!-- Kasir performance -->
        <div class="card">
          <div class="card-header"><div class="card-title">👤 Performa Kasir</div></div>
          <div id="report-kasir-list"></div>
        </div>
      </div>

      <!-- Full sales table -->
      <div class="card" style="padding:0;overflow:hidden">
        <div style="padding:16px 20px;border-bottom:1px solid var(--border)">
          <span style="font-weight:700;font-size:0.95rem">📋 Detail Transaksi</span>
          <span style="font-size:0.78rem;color:var(--text-muted);margin-left:8px">(50 transaksi terbaru)</span>
        </div>
        <div class="table-wrap">
          <table class="data-table">
            <thead><tr>
              <th>No. Order</th><th>Waktu</th><th>Kasir</th><th>Item</th><th>Pembayaran</th><th>Total</th><th>Status</th>
            </tr></thead>
            <tbody id="report-sales-tbody"></tbody>
          </table>
        </div>
      </div>
    </div>


@endsection