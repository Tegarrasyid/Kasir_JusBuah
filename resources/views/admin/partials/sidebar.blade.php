<aside class="sidebar" id="sidebar">

    <div class="sidebar-brand">
      <div style="width: 150px"><img src="{{ asset('assets/img/AMERTA.png')}}" alt="logo amerta"></div>
    </div>

    <nav class="sidebar-nav">
      <div class="nav-section-label">Utama</div>

      <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('dashboard.*') ? 'active' : '' }}">
        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/>
          <rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/>
        </svg>
        Dashboard
      </a>

      <div class="nav-section-label">Manajemen</div>

      <a href="{{ route('users.index') }}" class="nav-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/>
          <circle cx="9" cy="7" r="4"/>
          <path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/>
        </svg>
        Manajemen Pengguna
      </a>

      <a href="{{ route('kategori.index') }}" class="nav-item {{ request()->routeIs('kategori.*') ? 'active' : '' }}">
        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M4 6h16M4 12h8m-8 6h16"/>
        </svg>
        Manajemen Kategori
      </a>

      <a href="{{ route('produk.index') }}" class="nav-item {{ request()->routeIs('produk.*') ? 'active' : '' }}">
        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z"/>
        </svg>
        Manajemen Produk
      </a>

      <div class="nav-section-label">Inventaris</div>

      <a href="{{ route('bahan-baku.index') }}" class="nav-item {{ request()->routeIs('bahan-baku.*') ? 'active' : '' }}">
        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M3 3h18M3 9h18M3 15h18M3 21h18"/>
        </svg>
        Manajemen Bahan Baku
      </a>

      <a href="{{ route('resep.index') }}" class="nav-item {{ request()->routeIs('resep.*') ? 'active' : '' }}">
        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
        </svg>
        Manajemen Resep
      </a>

      <a href="{{ route('pembelian-stok.index') }}" class="nav-item {{ request()->routeIs('pembelian-stok.*') ? 'active' : '' }}">
        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <polyline points="23 4 23 10 17 10"/>
          <path d="M20.49 15a9 9 0 11-2.12-9.36L23 10"/>
        </svg>
        Manajemen Tambah Stok
      </a>

      <div class="nav-section-label">Laporan</div>

      <div class="nav-item" data-page="reports">
        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
        </svg>
        Laporan Penjualan
      </div>
    </nav>

    <div class="sidebar-footer">
    <div class="sidebar-user">
        <div class="s-avatar"><img src="{{asset('assets/img/profil.png')}}" alt=""></div>
        <div>
        <div class="s-name">{{ Auth::user()->name }}</div>
        <div class="s-role">Administrator</div>
        </div>
    </div>

    <form action="{{ route('logout') }}" method="POST" style="margin-top:10px;">
        @csrf
        <button type="submit" class="btn btn-secondary" style="width:100%;">
        Logout
        </button>
    </form>
    </div>
  </aside>