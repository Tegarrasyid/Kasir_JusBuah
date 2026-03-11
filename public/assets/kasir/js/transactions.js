/**
 * transactions.js — Transaction history page & receipt modal
 */

const TransactionPage = (() => {

  let filter = 'semua';

  function getHistory() {
    return JSON.parse(localStorage.getItem('kasir_txn') || '[]');
  }

  function formatDate(iso) {
    const d = new Date(iso);
    return d.toLocaleDateString('id-ID', { day:'2-digit', month:'short', year:'numeric' })
      + ' ' + d.toLocaleTimeString('id-ID', { hour:'2-digit', minute:'2-digit' });
  }

  function payLabel(method) {
    const map = { tunai: '💵 Tunai', qris: '📱 QRIS', debit: '💳 Debit', kredit: '🏦 Kredit', gopay: '🟢 GoPay' };
    return map[method] || method;
  }

  function renderStats(history) {
    const today = new Date().toDateString();
    const todayTxn = history.filter(t => new Date(t.timestamp).toDateString() === today);
    const totalToday = todayTxn.reduce((s, t) => s + t.total, 0);
    const totalAll   = history.reduce((s, t) => s + t.total, 0);
    const totalItems = history.reduce((s, t) => s + t.items.reduce((ss,i) => ss+i.qty, 0), 0);

    setValue('stat-today-count',   todayTxn.length);
    setValue('stat-today-revenue', formatRp(totalToday));
    setValue('stat-total-txn',     history.length);
    setValue('stat-total-revenue', formatRp(totalAll));
    setValue('stat-total-items',   totalItems);
    setValue('stat-avg-value',     history.length ? formatRp(Math.round(totalAll/history.length)) : 'Rp 0');
  }

  function renderTable(history) {
    const tbody = document.getElementById('txn-tbody');
    if (!tbody) return;

    let filtered = history;
    if (filter === 'hari_ini') {
      const today = new Date().toDateString();
      filtered = history.filter(t => new Date(t.timestamp).toDateString() === today);
    }

    if (!filtered.length) {
      tbody.innerHTML = `<tr><td colspan="7" style="text-align:center;padding:40px;color:var(--text-light)">Belum ada transaksi</td></tr>`;
      return;
    }

    tbody.innerHTML = filtered.map(txn => `
      <tr data-txn='${JSON.stringify(txn).replace(/'/g, "&apos;")}'>
        <td>${txn.id}</td>
        <td>${formatDate(txn.timestamp)}</td>
        <td>${txn.customer}</td>
        <td>${txn.items.map(i => i.name).join(', ').substring(0,40)}${txn.items.length > 2 ? '…' : ''}</td>
        <td><span class="txn-method">${payLabel(txn.payment)}</span></td>
        <td style="font-weight:800;color:var(--amber-dark)">${formatRp(txn.total)}</td>
        <td>
          <span class="txn-status paid">✓ Lunas</span>
          <button class="txn-action-btn" style="margin-left:6px" data-receipt='${JSON.stringify(txn).replace(/'/g,"&apos;")}'>🧾 Struk</button>
        </td>
      </tr>
    `).join('');

    // Receipt buttons
    tbody.querySelectorAll('.txn-action-btn').forEach(btn => {
      btn.addEventListener('click', (e) => {
        e.stopPropagation();
        try {
          const txn = JSON.parse(btn.dataset.receipt.replace(/&apos;/g,"'"));
          ReceiptModal.show(txn);
        } catch(err) { console.error(err); }
      });
    });
  }

  function setValue(id, val) {
    const el = document.getElementById(id);
    if (el) el.textContent = val;
  }

  function refresh() {
    const history = getHistory();
    renderStats(history);
    renderTable(history);
  }

  function init() {
    refresh();

    // Filter buttons
    document.querySelectorAll('.txn-filter-btn').forEach(btn => {
      btn.addEventListener('click', () => {
        document.querySelectorAll('.txn-filter-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        filter = btn.dataset.filter;
        renderTable(getHistory());
      });
    });
  }

  return { init, refresh };
})();

/* ============================================
   Receipt Modal
   ============================================ */

const ReceiptModal = (() => {

  function show(txn) {
    const overlay = document.getElementById('receipt-modal');
    if (!overlay) return;

    const d = new Date(txn.timestamp);
    const dateStr = d.toLocaleDateString('id-ID', {
      weekday:'long', day:'2-digit', month:'long', year:'numeric'
    });
    const timeStr = d.toLocaleTimeString('id-ID', { hour:'2-digit', minute:'2-digit' });

    document.getElementById('receipt-content').innerHTML = `
      <div class="receipt">
        <div class="receipt-header">
          <div class="receipt-brand">Amerta</div>
          <div class="receipt-address">Jl. Kopi Enak No. 7, Purbalingga Kota</div>
          <div class="receipt-address">Telp: 0876-8765-8654</div>
        </div>

        <hr class="receipt-divider" />

        <div class="receipt-meta">
          <div><span>No. Order</span><span>${txn.id}</span></div>
          <div><span>Tanggal</span><span>${dateStr}</span></div>
          <div><span>Pukul</span><span>${timeStr}</span></div>
          <div><span>Kasir</span><span>Ahmad Fauzi</span></div>
        </div>

        <hr class="receipt-divider" />

        <div class="receipt-items">
          ${txn.items.map(item => `
            <div class="receipt-item">
              <span class="receipt-item-name">${item.emoji} ${item.name}${item.note ? `<br><span style="font-size:0.68rem;color:var(--text-light)">&nbsp;&nbsp;${item.note}</span>` : ''}</span>
              <span class="receipt-item-qty">x${item.qty}</span>
              <span class="receipt-item-price">${formatRp(item.price * item.qty)}</span>
            </div>
          `).join('')}
        </div>

        <hr class="receipt-divider" />

        <div class="receipt-totals">
          <div><span>Subtotal</span><span>${formatRp(txn.subtotal)}</span></div>
          <hr class="receipt-divider" />
          <div class="receipt-grand-total">
            <span>TOTAL</span>
            <span>${formatRp(txn.total)}</span>
          </div>
          <div><span>Pembayaran</span><span style="text-transform:capitalize">${txn.payment}</span></div>
        </div>

        <hr class="receipt-divider" />
        <div class="receipt-footer">
          <p>✨ Terima kasih telah berkunjung!</p>
          <p>Sampai jumpa kembali 😊</p>
          <p style="margin-top:6px;font-size:0.65rem">Struk ini adalah bukti pembayaran yang sah</p>
        </div>
      </div>

      <button class="print-btn" onclick="window.print()">
        🖨 Cetak Struk
      </button>
    `;

    overlay.classList.add('open');
  }

  function init() {
    const overlay = document.getElementById('receipt-modal');
    const closeBtn = document.getElementById('receipt-close');
    if (!overlay) return;

    overlay.addEventListener('click', (e) => {
      if (e.target === overlay) overlay.classList.remove('open');
    });
    if (closeBtn) {
      closeBtn.addEventListener('click', () => overlay.classList.remove('open'));
    }
  }

  return { show, init };
})();
