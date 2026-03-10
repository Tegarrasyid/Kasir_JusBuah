  <!-- ============================
       NAVBAR
       ============================ -->
  <nav class="navbar">
    <!-- Brand -->
    <div class="navbar-brand">
      <div style="width: 150px"><img src="{{ asset('assets/img/AMERTA.png')}}" alt="logo amerta"></div>
    </div>

    <!-- Nav Links -->
    <div class="navbar-nav">

        <a href="{{ route('kasir.dashboard') }}" class="nav-link {{ request()->routeIs('kasir.dashboard') ? 'active' : '' }}">
        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <rect x="2" y="3" width="20" height="14" rx="2"/>
            <path d="M8 21h8M12 17v4"/>
        </svg>
        Kasir
        </a>

        <a href="{{ route('transaksi.riwayat') }}" class="nav-link {{ request()->routeIs('transaksi.riwayat') ? 'active' : '' }}">
        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>
            <polyline points="14 2 14 8 20 8"/>
            <line x1="16" y1="13" x2="8" y2="13"/>
            <line x1="16" y1="17" x2="8" y2="17"/>
        </svg>
        Transaksi
        </a>

        <a href="{{ route('kasir.profil') }}" class="nav-link {{ request()->routeIs('kasir.profil') ? 'active' : '' }}">
        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/>
            <circle cx="12" cy="7" r="4"/>
        </svg>
        Profil
        </a>

        </div>

    <!-- Right side -->
    <div class="navbar-right">
      <div class="navbar-clock" id="navbar-clock">00:00:00</div>

      <!-- Mobile cart button -->
      <button id="cart-toggle" style="display:none;align-items:center;gap:6px;padding:8px 14px;background:var(--text-dark);color:var(--amber);border-radius:var(--radius-sm);font-size:0.82rem;font-weight:700;">
        🛒 <span id="cart-badge" style="display:none;background:var(--amber);color:var(--text-dark);border-radius:50%;width:18px;height:18px;font-size:0.68rem;display:flex;align-items:center;justify-content:center;"></span>
      </button>

      <div class="navbar-avatar">
        <div class="avatar-img"><img src="{{ asset('storage/'.Auth::user()->foto) }}" alt="Foto Profil"></div>
        <div>
        <div class="avatar-name">{{ Auth::user()->name }}</div>
          <div class="avatar-role">Kasir</div>
        </div>
      </div>
    </div>
  </nav>