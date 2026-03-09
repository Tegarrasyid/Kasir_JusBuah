<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Amerta — Aplikasi Kasir</title>

  <link rel="stylesheet" href="{{ asset('assets/kasir/css/main.css')}}" />
  <link rel="stylesheet" href="{{ asset('assets/kasir/css/navbar.css')}}" />
  <link rel="stylesheet" href="{{ asset('assets/kasir/css/products.css')}}" />
  <link rel="stylesheet" href="{{ asset('assets/kasir/css/order.css')}}" />
  <link rel="stylesheet" href="{{ asset('assets/kasir/css/transactions.css')}}" />

  <style>
    /* print receipt */
    @media print {
      body > *:not(#receipt-modal) { display: none !important; }
      #receipt-modal { position: static !important; background: white !important; }
      .modal { box-shadow: none; }
      .print-btn, .modal-close { display: none !important; }
    }
    .app-outer { display: flex; flex-direction: column; min-height: 100vh; }
  </style>
</head>

<body>
<div class="app-outer">

  <!-- ============================
       NAVBAR
       ============================ -->
  <nav class="navbar">
    <!-- Brand -->
    <div class="navbar-brand">
      <div class="brand-icon"><span>K</span></div>
      <span class="brand-name">Kasi<em>Rasa</em></span>
    </div>

    <!-- Nav Links -->
    <div class="navbar-nav">
      <button class="nav-link" data-page="kasir">
        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/>
        </svg>
        Kasir
      </button>

      <button class="nav-link" data-page="transaksi">
        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>
          <polyline points="14 2 14 8 20 8"/>
          <line x1="16" y1="13" x2="8" y2="13"/>
          <line x1="16" y1="17" x2="8" y2="17"/>
        </svg>
        Transaksi
      </button>

      <button class="nav-link" data-page="profil">
        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/>
          <circle cx="12" cy="7" r="4"/>
        </svg>
        Profil
      </button>
    </div>

    <!-- Right side -->
    <div class="navbar-right">
      <div class="navbar-clock" id="navbar-clock">00:00:00</div>

      <!-- Mobile cart button -->
      <button id="cart-toggle" style="display:none;align-items:center;gap:6px;padding:8px 14px;background:var(--text-dark);color:var(--amber);border-radius:var(--radius-sm);font-size:0.82rem;font-weight:700;">
        🛒 <span id="cart-badge" style="display:none;background:var(--amber);color:var(--text-dark);border-radius:50%;width:18px;height:18px;font-size:0.68rem;display:flex;align-items:center;justify-content:center;"></span>
      </button>

      <div class="navbar-avatar">
        <div class="avatar-img">AF</div>
        <div>
          <div class="avatar-name">Ahmad Fauzi</div>
          <div class="avatar-role">Kasir</div>
        </div>
      </div>
    </div>
  </nav>

  <!-- ============================
       KASIR PAGE (Product + Order)
       ============================ -->
  <div class="app-layout" id="kasir-layout">

    <!-- Product Area -->
    <div class="products-area">

      <!-- Toolbar -->
      <div class="product-toolbar">
        <div class="search-box">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
          </svg>
          <input id="product-search" type="text" placeholder="Cari produk..." />
        </div>
      </div>

      <!-- Category Tabs -->
      <div class="category-tabs" id="category-tabs"></div>

      <!-- Section Header -->
      <div class="section-header">
        <span class="section-title">Menu Tersedia</span>
        <span class="section-count" id="product-count">0 item</span>
      </div>

      <!-- Product Grid -->
      <div class="product-grid" id="product-grid"></div>

    </div>

    <!-- ============================
         ORDER SIDEBAR (Right)
         ============================ -->
    <aside class="order-sidebar" id="order-sidebar">

      <!-- Order Header -->
      <div class="order-header">
        <div class="order-header-top">
          <span class="order-title">🛒 Pesanan</span>
          <span class="order-no" id="order-no">ORD-0001</span>
        </div>
        <div class="order-meta">
          <span class="order-meta-item">
            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
            </svg>
            <span id="order-time-display">Sekarang</span>
          </span>
        </div>
      </div>

      <!-- Customer & Table -->
      <div class="customer-row">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="var(--text-light)" stroke-width="2">
          <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/>
        </svg>
        <input class="customer-input" id="customer-name" type="text" placeholder="Nama pelanggan..." />
        <button class="table-select" id="table-select-btn">🪑 T1</button>
        <span id="table-no" style="display:none">T1</span>
      </div>

      <!-- Order Items -->
      <div class="order-items" id="order-items-list"></div>

      <!-- Summary & Checkout -->
      <div class="order-summary">

        <!-- Discount Row -->
        <div class="order-discount-row">
          <div class="discount-input-wrap">
            <label>Diskon</label>
            <input id="discount-input" type="number" min="0" max="100" value="0" placeholder="0" />
            <span style="font-size:0.8rem;color:var(--text-light)">%</span>
          </div>
        </div>

        <!-- Summary Lines -->
        <div class="summary-row">
          <span>Subtotal</span>
          <span id="summary-subtotal">Rp 0</span>
        </div>
        <div class="summary-row">
          <span>Diskon</span>
          <span id="summary-discount" style="color:var(--green)">Rp 0</span>
        </div>
        <div class="summary-row">
          <span>Pajak (10%)</span>
          <span id="summary-tax">Rp 0</span>
        </div>

        <div class="summary-divider"></div>

        <div class="summary-total" style="margin-bottom:16px">
          <span class="total-label">Total</span>
          <span class="total-amount" id="total-amount">Rp 0</span>
        </div>

        <!-- Payment Methods -->
        <div class="payment-methods">
          <button class="pay-method selected" data-method="tunai">
            <span class="pay-icon">💵</span>Tunai
          </button>
          <button class="pay-method" data-method="qris">
            <span class="pay-icon">📱</span>QRIS
          </button>
          <button class="pay-method" data-method="debit">
            <span class="pay-icon">💳</span>Debit
          </button>
          <button class="pay-method" data-method="kredit">
            <span class="pay-icon">🏦</span>Kredit
          </button>
          <button class="pay-method" data-method="gopay">
            <span class="pay-icon">🟢</span>GoPay
          </button>
          <button class="pay-method" data-method="ovo">
            <span class="pay-icon">🟣</span>OVO
          </button>
        </div>

        <!-- Checkout Button -->
        <button class="checkout-btn" id="checkout-btn" disabled>
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <polyline points="20 6 9 17 4 12"/>
          </svg>
          Proses Pembayaran
        </button>
        <button class="clear-btn" id="clear-btn">🗑 Kosongkan Pesanan</button>
      </div>

    </aside>
  </div>

  <!-- ============================
       TRANSAKSI PAGE
       ============================ -->
  <div class="page-panel" data-panel="transaksi" >
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
            <th>Pelanggan</th>
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

  <!-- ============================
       PROFIL PAGE
       ============================ -->
  <div class="page-panel" data-panel="profil">
    <div class="page-heading">
      <div>
        <h2>Profil Saya</h2>
        <p>Informasi akun dan statistik personal</p>
      </div>
    </div>

    <div class="profile-grid">
      <!-- Profile Card -->
      <div class="profile-card">
        <div class="profile-avatar-lg">AF</div>
        <div class="profile-name">Ahmad Fauzi</div>
        <div class="profile-role">Kasir Senior</div>

        <div class="profile-stats">
          <div class="profile-stat">
            <div class="ps-value" id="profile-txn-count">0</div>
            <div class="ps-label">Transaksi</div>
          </div>
          <div class="profile-stat">
            <div class="ps-value" id="profile-items-sold">0</div>
            <div class="ps-label">Item Terjual</div>
          </div>
        </div>

        <div style="margin-top:16px;font-size:0.8rem;color:var(--text-light);font-weight:600">Total Pendapatan Diproses</div>
        <div style="font-family:var(--font-display);font-size:1.5rem;font-weight:900;color:var(--amber-dark);margin-top:4px" id="profile-revenue">Rp 0</div>
      </div>

      <!-- Detail Card -->
      <div class="profile-detail-card">
        <div style="font-family:var(--font-display);font-size:1.1rem;font-weight:900;margin-bottom:20px">Informasi Akun</div>
        <div class="detail-row">
          <span class="detail-label">Nama Lengkap</span>
          <span class="detail-value">Ahmad Fauzi</span>
        </div>
        <div class="detail-row">
          <span class="detail-label">Username</span>
          <span class="detail-value">@kasir.fauzi</span>
        </div>
        <div class="detail-row">
          <span class="detail-label">Jabatan</span>
          <span class="detail-value">Kasir Senior</span>
        </div>
        <div class="detail-row">
          <span class="detail-label">Shift</span>
          <span class="detail-value">08:00 – 16:00 WIB</span>
        </div>
        <div class="detail-row">
          <span class="detail-label">Outlet</span>
          <span class="detail-value">Amerta – Pusat</span>
        </div>
        <div class="detail-row">
          <span class="detail-label">Bergabung</span>
          <span class="detail-value">15 Januari 2023</span>
        </div>
        <div class="detail-row">
          <span class="detail-label">Status</span>
          <span class="detail-value" style="color:var(--green)">● Aktif</span>
        </div>

        <div style="margin-top:24px;padding-top:20px;border-top:1px solid var(--border);">
            <div style="font-family:var(--font-display);font-size:1rem;font-weight:900;margin-bottom:14px">
                Pengaturan Cepat
            </div>

            <div style="display:flex;flex-direction:column;gap:10px;">

                <button onclick="Toast.show('Fitur segera hadir!','warning')"
                style="text-align:left;padding:12px 16px;background:var(--cream);border-radius:var(--radius-sm);font-size:0.85rem;font-weight:600;color:var(--text-mid);border:1.5px solid var(--border);cursor:pointer;">
                🔒 Ganti Password
                </button>

                <button onclick="Toast.show('Fitur segera hadir!','warning')"
                style="text-align:left;padding:12px 16px;background:var(--cream);border-radius:var(--radius-sm);font-size:0.85rem;font-weight:600;color:var(--text-mid);border:1.5px solid var(--border);cursor:pointer;">
                🖨 Pengaturan Printer
                </button>

                <!-- LOGOUT BUTTON -->
                <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                style="width:100%;text-align:left;padding:12px 16px;background:#fee2e2;border-radius:var(--radius-sm);font-size:0.85rem;font-weight:700;color:#dc2626;border:1.5px solid rgba(239,68,68,0.3);cursor:pointer;">
                🚪 Logout
                </button>
                </form>

            </div>
        </div>
      </div>
    </div>
  </div>

</div><!-- /.app-outer -->

<!-- ============================
     RECEIPT MODAL
     ============================ -->
<div class="modal-overlay" id="receipt-modal">
  <div class="modal" style="max-width:420px">
    <div class="modal-header">
      <span class="modal-title">🧾 Struk Pembayaran</span>
      <button class="modal-close" id="receipt-close">✕</button>
    </div>
    <div id="receipt-content"></div>
  </div>
</div>

<!-- Toast Container -->
<div class="toast-container" id="toast-container"></div>

<!-- Scripts (order matters) -->
<script src="{{ asset('assets/kasir/js/products.js')}}"></script>
<script src="{{ asset('assets/kasir/js/order.js')}}"></script>
<script src="{{ asset('assets/kasir/js/transactions.js')}}"></script>
<script src="{{ asset('assets/kasir/js/app.js')}}"></script>

</body>
</html>
