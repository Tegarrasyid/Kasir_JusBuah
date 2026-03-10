  <header class="topbar">
    <div class="topbar-left">
      <div class="topbar-breadcrumb">
        <span>AMERTA</span>
        <span class="sep">›</span>
        <span class="current" id="breadcrumb-current">
            @yield('breadcrumb', 'Dashboard')
        </span>
      </div>
    </div>
    <div class="topbar-right">
      <div class="topbar-clock" id="topbar-clock"></div>
      <button class="topbar-icon-btn" title="Notifikasi">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 01-3.46 0"/>
        </svg>
        <span class="notif-pip"></span>
      </button>
      <div class="topbar-user">
        <div class="s-avatar"><img src="{{ asset('storage/'.Auth::user()->foto) }}" alt="Foto Profil"></div>
        <div class="s-name">{{ Auth::user()->name }}</div>
      </div>
    </div>
  </header>