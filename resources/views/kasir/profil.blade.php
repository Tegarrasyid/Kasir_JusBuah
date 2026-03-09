@extends('layouts.kasir.app')

@section('title','Profil')
@section('content')

  <!-- ============================
       PROFIL PAGE
       ============================ -->
  <div class="profil-page">
    <div class="page-heading">
      <div>
        <h2>Profil Saya</h2>
        <p>Informasi akun dan statistik personal</p>
      </div>
    </div>

    <div class="profile-grid">
      <!-- Profile Card -->
      <div class="profile-card">
        <div class="profile-avatar-lg">{{ strtoupper(substr(Auth::user()->name,0,2)) }}</div>
        <div class="profile-name">{{ Auth::user()->name }}</div>
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
          <span class="detail-value">{{ Auth::user()->name }}</span>
          
        </div>
        <div class="detail-row">
          <span class="detail-label">Email</span>
          <span class="detail-value">{{ Auth::user()->email }}</span>
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
          <span class="detail-value">{{ Auth::user()->created_at->format('d F Y') }}</span>
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


@endsection