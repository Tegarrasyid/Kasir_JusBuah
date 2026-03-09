/**
 * app.js — Navigation, topbar, toast, layout control
 */

/* ================================================
   Toast
   ================================================ */
const Toast = (() => {
  function show(msg, type = 'info', dur = 3000) {
    const wrap = document.getElementById('toast-wrap');
    if (!wrap) return;
    const t = document.createElement('div');
    const icons = { info:'ℹ️', success:'✅', error:'❌', warning:'⚠️' };
    t.className = `toast ${type}`;
    t.innerHTML = `<span>${icons[type]||'ℹ️'}</span><span>${msg}</span>`;
    wrap.appendChild(t);
    setTimeout(() => {
      t.classList.add('out');
      setTimeout(() => t.remove(), 300);
    }, dur);
  }
  return { show };
})();

/* ================================================
   Navigation
   ================================================ */
const Nav = (() => {
  const pageMap = {
    dashboard:  { title:'Dashboard',            sub:'Ringkasan performa & statistik penjualan' },
    users:      { title:'Manajemen Pengguna',    sub:'Kelola akun admin, kasir, dan manajer' },
    categories: { title:'Manajemen Kategori',   sub:'Atur kategori produk yang tersedia' },
    products:   { title:'Manajemen Produk',     sub:'Daftar produk yang dijual di kasir' },
    ingredients:{ title:'Manajemen Bahan Baku', sub:'Stok bahan baku dan inventaris' },
    recipes:    { title:'Manajemen Resep',      sub:'Komposisi bahan baku setiap produk' },
    restock:    { title:'Tambah Stok',          sub:'Catat penambahan stok bahan baku' },
    reports:    { title:'Laporan Penjualan',    sub:'Analisa dan rekap transaksi kasir' },
  };

  let current = 'dashboard';

  function goto(page) {
    current = page;

    // Update nav items
    document.querySelectorAll('.nav-item').forEach(el => {
      el.classList.toggle('active', el.dataset.page === page);
    });

    // Update pages
    document.querySelectorAll('.page').forEach(el => {
      el.classList.toggle('active', el.id === `page-${page}`);
    });

    // Breadcrumb
    const info = pageMap[page] || { title: page, sub: '' };
    const bc = document.getElementById('breadcrumb-current');
    const h1 = document.getElementById('page-h1');
    const sub = document.getElementById('page-sub');
    if (bc)  bc.textContent = info.title;
    if (h1)  h1.textContent = info.title;
    if (sub) sub.textContent = info.sub;

    // Trigger render
    PageRenderers[page]?.();

    // Close mobile sidebar
    document.getElementById('sidebar')?.classList.remove('open');
    document.getElementById('sidebar-overlay')?.classList.remove('visible');
  }

  // function init() {
  //   document.querySelectorAll('.nav-item').forEach(el => {
  //     el.addEventListener('click', () => goto(el.dataset.page));
  //   });
  //   goto('dashboard');
  // }

  return { init, goto, current: () => current };
})();

/* ================================================
   Topbar Clock
   ================================================ */
function initClock() {
  const el = document.getElementById('topbar-clock');
  if (!el) return;
  const tick = () => {
    const now = new Date();
    el.textContent = now.toLocaleTimeString('id-ID', {
      weekday:'short', day:'2-digit', month:'short',
      hour:'2-digit', minute:'2-digit'
    });
  };
  tick(); setInterval(tick, 1000);
}

/* ================================================
   Sidebar Mobile
   ================================================ */
function initSidebar() {
  const toggle  = document.getElementById('sidebar-toggle');
  const sidebar = document.getElementById('sidebar');
  const overlay = document.getElementById('sidebar-overlay');

  toggle?.addEventListener('click', () => {
    sidebar?.classList.toggle('open');
    overlay?.classList.toggle('visible');
  });
  overlay?.addEventListener('click', () => {
    sidebar?.classList.remove('open');
    overlay?.classList.remove('visible');
  });
}

/* ================================================
   Generic CRUD Modal helpers
   ================================================ */
const Modal = (() => {
  function open(id) { document.getElementById(id)?.classList.add('open'); }
  function close(id) { document.getElementById(id)?.classList.remove('open'); }
  function closeAll() {
    document.querySelectorAll('.modal-overlay').forEach(m => m.classList.remove('open'));
  }
  return { open, close, closeAll };
})();

/* ================================================
   Boot
   ================================================ */
document.addEventListener('DOMContentLoaded', () => {
  initClock();
  initSidebar();
  // Nav.init();

  // Close modals on overlay click
  document.querySelectorAll('.modal-overlay').forEach(el => {
    el.addEventListener('click', e => { if (e.target === el) Modal.closeAll(); });
  });

  // Modal close buttons
  document.querySelectorAll('.modal-close').forEach(btn => {
    btn.addEventListener('click', () => Modal.closeAll());
  });

  console.log('%c 🌿 Amerta Admin Panel ', 'background:#10b981;color:#fff;padding:5px 14px;border-radius:6px;font-weight:700;');
});
