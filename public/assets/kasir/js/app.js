/**
 * app.js — Main app: navigation, navbar, toast, profile
 */

/* ============================================
   Toast Notification System
   ============================================ */
const Toast = (() => {
  function show(message, type = 'default', duration = 2800) {
    const container = document.getElementById('toast-container');
    if (!container) return;

    const toast = document.createElement('div');
    toast.className = `toast ${type}`;
    const icons = { success: '✅', error: '❌', warning: '⚠️', default: 'ℹ️' };
    toast.innerHTML = `<span class="toast-icon">${icons[type] || icons.default}</span><span>${message}</span>`;
    container.appendChild(toast);

    setTimeout(() => {
      toast.classList.add('removing');
      setTimeout(() => toast.remove(), 300);
    }, duration);
  }
  return { show };
})();

/* ============================================
   Navigation
   ============================================ */
const Navigation = (() => {
  const pages = ['kasir', 'transaksi', 'profil'];

  function init() {
    document.querySelectorAll('.nav-link').forEach(link => {
      link.addEventListener('click', () => {
        const page = link.dataset.page;
        if (page) navigateTo(page);
      });
    });

    // Default page
    navigateTo('kasir');
  }

  function navigateTo(page) {
    // Update nav links
    // document.querySelectorAll('.nav-link').forEach(l => {
    //   l.classList.toggle('active', l.dataset.page === page);
    // });

    // Show/hide panels
    document.querySelectorAll('.page-panel').forEach(p => {
      p.classList.toggle('active', p.dataset.panel === page);
    });

    // Show/hide order sidebar & product area
    const kasirLayout = document.getElementById('kasir-layout');
    if (kasirLayout) {
      kasirLayout.style.display = page === 'kasir' ? 'flex' : 'none';
    }

    // Refresh transaction page
    if (page === 'transaksi' && typeof TransactionPage !== 'undefined') {
      TransactionPage.refresh();
    }
  }

  return { init, navigateTo };
})();

/* ============================================
   Profile Page
   ============================================ */
const ProfilePage = (() => {
  function init() {
    // Update profile stats from localStorage
    const history = JSON.parse(localStorage.getItem('kasir_txn') || '[]');
    const totalRev = history.reduce((s, t) => s + t.total, 0);

    setValue('profile-txn-count', history.length);
    setValue('profile-revenue',   formatRp(totalRev));
    setValue('profile-items-sold', history.reduce((s,t) => s + t.items.reduce((ss,i)=>ss+i.qty,0), 0));
  }

  function setValue(id, val) {
    const el = document.getElementById(id);
    if (el) el.textContent = val;
  }

  return { init };
})();

/* ============================================
   Navbar Clock & Greeting
   ============================================ */
const NavClock = (() => {
  function init() {
    const el = document.getElementById('navbar-clock');
    if (!el) return;
    const tick = () => {
      const now = new Date();
      el.textContent = now.toLocaleTimeString('id-ID', {
        hour: '2-digit', minute: '2-digit', second: '2-digit'
      });
    };
    tick();
    setInterval(tick, 1000);
  }
  return { init };
})();

/* ============================================
   Table Number Selector
   ============================================ */
const TableSelector = (() => {
  const tables = ['T1','T2','T3','T4','T5','T6','Bar','Teras','Takeaway'];
  let selected = 'T1';

  function init() {
    const btn = document.getElementById('table-select-btn');
    if (!btn) return;
    btn.textContent = '🪑 ' + selected;
    btn.addEventListener('click', () => {
      const idx = (tables.indexOf(selected) + 1) % tables.length;
      selected = tables[idx];
      btn.textContent = '🪑 ' + selected;
      const el = document.getElementById('table-no');
      if (el) el.textContent = selected;
    });
  }

  return { init };
})();

/* ============================================
   DOMContentLoaded — Boot all modules
   ============================================ */
document.addEventListener('DOMContentLoaded', () => {
  Navigation.init();
  NavClock.init();
  TableSelector.init();
  ProductCatalog.init();
  OrderPanel.init();
  TransactionPage.init();
  ReceiptModal.init();
  ProfilePage.init();

  console.log('%c  Amerta Loaded ', 'background:#1c1408;color:#f59e0b;padding:5px 14px;border-radius:6px;font-weight:900;font-size:13px');
});
