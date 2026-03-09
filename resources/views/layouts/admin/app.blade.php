<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>@yield('title')</title>
  <link rel="stylesheet" href="{{ asset('assets/admin/css/base.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/admin/css/layout.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/admin/css/dashboard.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/admin/css/pages.css') }}">

  @stack('styles')
</head>
<body>

<div class="app-shell">

  <!-- =============================================
       SIDEBAR
       ============================================= -->
  
  @include('admin.partials.sidebar')

  <!-- =============================================
       TOPBAR
       ============================================= -->

  @include('admin.partials.topbar')



  <!-- =============================================
       MAIN CONTENT
       ============================================= -->
  <main class="main-content">
    <span class="current">
        @yield('breadcrumb','Dashboard')
    </span>
    <div class="content">
        @yield('content')
    </div>


  </main><!-- /.main-content -->
</div><!-- /.app-shell -->

<!-- =============================================
     MOBILE SIDEBAR OVERLAY
     ============================================= -->
<div class="sidebar-overlay" id="sidebar-overlay"></div>
<button class="sidebar-toggle-btn" id="sidebar-toggle">☰</button>

<!-- =============================================
     MODALS
     ============================================= -->

<!-- USER MODAL -->
<div class="modal-overlay" id="user-modal">
  <div class="modal">
    <div class="modal-header">
      <span class="modal-title" id="user-modal-title">Tambah Pengguna</span>
      <button class="modal-close">✕</button>
    </div>
    <form id="user-form" onsubmit="return false">
      <div class="form-grid-2">
        <div class="form-group">
          <label class="form-label">Nama Lengkap *</label>
          <input class="form-control" id="u-name" type="text" placeholder="Contoh: Ahmad Fauzi" />
        </div>
        <div class="form-group">
          <label class="form-label">Username *</label>
          <input class="form-control" id="u-username" type="text" placeholder="kasir.fauzi" />
        </div>
      </div>
      <div class="form-grid-2">
        <div class="form-group">
          <label class="form-label">Email</label>
          <input class="form-control" id="u-email" type="email" placeholder="email@kafe.com" />
        </div>
        <div class="form-group">
          <label class="form-label">No. Telepon</label>
          <input class="form-control" id="u-phone" type="text" placeholder="08xxxxxxxxxx" />
        </div>
      </div>
      <div id="user-pass-row" class="form-group">
        <label class="form-label">Password</label>
        <input class="form-control" id="u-password" type="password" placeholder="Min. 8 karakter" />
      </div>
      <div class="form-grid-2">
        <div class="form-group">
          <label class="form-label">Role *</label>
          <select class="form-control" id="u-role">
            <option value="kasir">Kasir</option>
            <option value="manajer">Manajer</option>
            <option value="admin">Admin</option>
          </select>
        </div>
        <div class="form-group">
          <label class="form-label">Status</label>
          <select class="form-control" id="u-active">
            <option value="true">Aktif</option>
            <option value="false">Nonaktif</option>
          </select>
        </div>
      </div>
    </form>
    <div class="modal-footer">
      <button class="btn btn-secondary modal-close">Batal</button>
      <button class="btn btn-primary" id="btn-save-user">Simpan</button>
    </div>
  </div>
</div>

<!-- CATEGORY MODAL -->
<div class="modal-overlay" id="cat-modal">
  <div class="modal">
    <div class="modal-header">
      <span class="modal-title" id="cat-modal-title">Tambah Kategori</span>
      <button class="modal-close">✕</button>
    </div>
    <form id="cat-form" onsubmit="return false">
      <div class="form-grid-2">
        <div class="form-group">
          <label class="form-label">Nama Kategori *</label>
          <input class="form-control" id="c-name" type="text" placeholder="Contoh: Minuman Panas" />
        </div>
        <div class="form-group">
          <label class="form-label">Emoji / Ikon</label>
          <input class="form-control" id="c-emoji" type="text" placeholder="☕" maxlength="4" />
        </div>
      </div>
      <div class="form-group">
        <label class="form-label">Deskripsi</label>
        <textarea class="form-control" id="c-desc" placeholder="Deskripsi singkat kategori ini..."></textarea>
      </div>
      <div class="form-group">
        <label class="form-label">Status</label>
        <select class="form-control" id="c-active">
          <option value="true">Aktif</option>
          <option value="false">Nonaktif</option>
        </select>
      </div>
    </form>
    <div class="modal-footer">
      <button class="btn btn-secondary modal-close">Batal</button>
      <button class="btn btn-primary" id="btn-save-cat">Simpan</button>
    </div>
  </div>
</div>

<!-- PRODUCT MODAL -->
<div class="modal-overlay" id="prod-modal">
  <div class="modal">
    <div class="modal-header">
      <span class="modal-title" id="prod-modal-title">Tambah Produk</span>
      <button class="modal-close">✕</button>
    </div>
    <form id="prod-form" onsubmit="return false">
      <div class="form-grid-2">
        <div class="form-group">
          <label class="form-label">Nama Produk *</label>
          <input class="form-control" id="p-name" type="text" placeholder="Contoh: Cappuccino" />
        </div>
        <div class="form-group">
          <label class="form-label">Emoji / Ikon</label>
          <input class="form-control" id="p-emoji" type="text" placeholder="☕" maxlength="4" />
        </div>
      </div>
      <div class="form-group">
        <label class="form-label">Kategori *</label>
        <select class="form-control" id="p-catid"></select>
      </div>
      <div class="form-grid-2">
        <div class="form-group">
          <label class="form-label">Harga Jual (Rp) *</label>
          <input class="form-control" id="p-price" type="number" placeholder="32000" min="0" />
        </div>
        <div class="form-group">
          <label class="form-label">HPP / Modal (Rp)</label>
          <input class="form-control" id="p-cost" type="number" placeholder="11000" min="0" />
        </div>
      </div>
      <div class="form-group">
        <label class="form-label">Ketersediaan Stok</label>
        <select class="form-control" id="p-stock">
          <option value="true">Tersedia</option>
          <option value="false">Habis</option>
        </select>
      </div>
    </form>
    <div class="modal-footer">
      <button class="btn btn-secondary modal-close">Batal</button>
      <button class="btn btn-primary" id="btn-save-product">Simpan</button>
    </div>
  </div>
</div>

<!-- INGREDIENT MODAL -->
<div class="modal-overlay" id="ing-modal">
  <div class="modal">
    <div class="modal-header">
      <span class="modal-title" id="ing-modal-title">Tambah Bahan Baku</span>
      <button class="modal-close">✕</button>
    </div>
    <form id="ing-form" onsubmit="return false">
      <div class="form-grid-2">
        <div class="form-group">
          <label class="form-label">Nama Bahan *</label>
          <input class="form-control" id="i-name" type="text" placeholder="Contoh: Biji Kopi" />
        </div>
        <div class="form-group">
          <label class="form-label">Emoji</label>
          <input class="form-control" id="i-emoji" type="text" placeholder="☕" maxlength="4" />
        </div>
      </div>
      <div class="form-group">
        <label class="form-label">Satuan *</label>
        <input class="form-control" id="i-unit" type="text" placeholder="gram / ml / butir / buah / kg / liter" />
      </div>
      <div class="form-grid-2">
        <div class="form-group">
          <label class="form-label">Stok Awal</label>
          <input class="form-control" id="i-stock" type="number" placeholder="0" min="0" />
        </div>
        <div class="form-group">
          <label class="form-label">Stok Minimum (Alert)</label>
          <input class="form-control" id="i-minstock" type="number" placeholder="0" min="0" />
        </div>
      </div>
      <div class="form-group">
        <label class="form-label">Harga per Satuan (Rp)</label>
        <input class="form-control" id="i-price" type="number" placeholder="0" min="0" />
      </div>
    </form>
    <div class="modal-footer">
      <button class="btn btn-secondary modal-close">Batal</button>
      <button class="btn btn-primary" id="btn-save-ing">Simpan</button>
    </div>
  </div>
</div>

<!-- RECIPE MODAL -->
<div class="modal-overlay" id="recipe-modal">
  <div class="modal">
    <div class="modal-header">
      <span class="modal-title" id="recipe-modal-title">Resep</span>
      <button class="modal-close">✕</button>
    </div>
    <div class="form-group">
      <div class="form-section-title">Produk</div>
      <div id="recipe-product-name" style="font-size:1rem;font-weight:700;padding:10px 0"></div>
    </div>
    <div class="form-group">
      <div class="form-section-title">Komposisi Bahan</div>
      <div class="recipe-composition" id="recipe-comps"></div>
    </div>
    <div class="form-group">
      <div class="form-section-title">Tambah Bahan</div>
      <div class="inline-add-row">
        <select id="comp-ing-select"><option value="">-- Pilih Bahan --</option></select>
        <input id="comp-qty" type="number" placeholder="Jumlah" min="0.1" step="0.1" style="max-width:100px"/>
        <button class="btn btn-secondary btn-sm" id="btn-add-comp">+ Tambah</button>
      </div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-secondary modal-close">Batal</button>
      <button class="btn btn-primary" id="btn-save-recipe">💾 Simpan Resep</button>
    </div>
  </div>
</div>

<!-- RESTOCK MODAL -->
<div class="modal-overlay" id="restock-modal">
  <div class="modal">
    <div class="modal-header">
      <span class="modal-title">Tambah Stok Bahan Baku</span>
      <button class="modal-close">✕</button>
    </div>
    <form id="restock-form" onsubmit="return false">
      <div class="form-group">
        <label class="form-label">Bahan Baku *</label>
        <select class="form-control" id="restock-ing-select"></select>
      </div>
      <div class="form-grid-2">
        <div class="form-group">
          <label class="form-label">Jumlah Ditambahkan *</label>
          <input class="form-control" id="restock-qty" type="number" placeholder="0" min="0.1" step="0.1" />
        </div>
        <div class="form-group">
          <label class="form-label">Satuan</label>
          <div class="form-control" style="background:var(--bg-surface);color:var(--text-muted)" id="restock-unit-display">-</div>
        </div>
      </div>
      <div class="form-group">
        <label class="form-label">Keterangan / Sumber</label>
        <input class="form-control" id="restock-note" type="text" placeholder="Contoh: Dari supplier Pak Joko" />
      </div>
    </form>
    <div class="modal-footer">
      <button class="btn btn-secondary modal-close">Batal</button>
      <button class="btn btn-primary" id="btn-save-restock">✅ Simpan Penambahan</button>
    </div>
  </div>
</div>

<!-- Toast -->
<div class="toast-wrap" id="toast-wrap"></div>

<!-- Scripts -->
<script src="{{ asset('assets/admin/js/app.js')}}"></script>
<script src="{{ asset('assets/admin/js/store.js')}}"></script>
<script src="{{ asset('assets/admin/js/dashboard.js')}}"></script>
<script src="{{ asset('assets/admin/js/pages.js')}}"></script>
    <script>
        function updateTopbarClock() {
            const clock = document.getElementById('topbar-clock');
            if (!clock) return;

            const now = new Date();

            const time = now.toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });

            const date = now.toLocaleDateString('id-ID', {
                weekday: 'short',
                day: '2-digit',
                month: 'short'
            });

            clock.textContent = `${time}`;
            // clock.textContent = `${date} • ${time}`;
        }

        setInterval(updateTopbarClock, 1000);
        updateTopbarClock();
    </script>
</body>
</html>
