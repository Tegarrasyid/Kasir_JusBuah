/**
 * order.js — Order sidebar: cart, totals, checkout
 */

const OrderPanel = (() => {

  let items     = [];
  let discount  = 0;
  let payMethod = 'tunai';
  let orderSeq  = parseInt(localStorage.getItem('kasir_seq') || '0') + 1;

  const TAX_RATE = 0.00;

  /* ---- Helpers ---- */
  function genOrderNo() {
    const d = new Date();
    const dd = String(d.getDate()).padStart(2,'0');
    const mm = String(d.getMonth()+1).padStart(2,'0');
    return `ORD-${dd}${mm}-${String(orderSeq).padStart(3,'0')}`;
  }

  function subtotal() {
    return items.reduce((s, i) => s + i.price * i.qty, 0);
  }
  function discountAmt() {
    return Math.round(subtotal() * (discount / 100));
  }
  function tax() {
    return Math.round((subtotal() - discountAmt()) * TAX_RATE);
  }
  function total() {
    return subtotal() - discountAmt() + tax();
  }
  function itemCount() {
    return items.reduce((s, i) => s + i.qty, 0);
  }

  /* ---- Add Item ---- */
  function addItem(product) {
    const existing = items.find(i => i.id === product.id);
    if (existing) {
      existing.qty++;
    } else {
      items.push({ ...product, qty: 1, note: '' });
    }
    render();
    Toast.show(`${product.emoji} ${product.name} ditambahkan`, 'success');
  }

  /* ---- Change Qty ---- */
  function changeQty(id, delta) {
    const idx = items.findIndex(i => i.id === id);
    if (idx === -1) return;
    items[idx].qty += delta;
    if (items[idx].qty <= 0) items.splice(idx, 1);
    render();
  }

  /* ---- Set Note ---- */
  function setNote(id, note) {
    const item = items.find(i => i.id === id);
    if (item) item.note = note;
  }

  /* ---- Clear All ---- */
  function clearAll() {
    if (!items.length) return;
    if (!confirm('Kosongkan semua pesanan?')) return;
    items = [];
    discount = 0;
    render();
    Toast.show('Pesanan dikosongkan', 'warning');
  }

  /* ---- Render Order Items ---- */
  function renderItems() {
    const container = document.getElementById('order-items-list');
    if (!container) return;

    if (!items.length) {
      container.innerHTML = `
        <div class="order-empty">
          <div class="empty-icon">🛒</div>
          <p>Belum ada pesanan.<br>Klik produk untuk menambahkan.</p>
        </div>`;
      return;
    }

    container.innerHTML = items.map(item => `
      <div class="order-item" data-id="${item.id}">
        <div class="item-emoji">${item.emoji}</div>
        <div class="item-details">
          <div class="item-name">${item.name}</div>
          <div class="item-note" data-note-toggle="${item.id}">
            ${item.note || '+ Tambah catatan...'}
          </div>
          <input class="item-note-input" id="note-${item.id}"
            placeholder="Catatan (misal: tanpa gula)" value="${item.note}"
            style="display:${item.note ? 'block' : 'none'}"
            data-note-id="${item.id}" />
        </div>
        <div style="display:flex;flex-direction:column;align-items:flex-end;gap:6px">
          <div class="item-price">${formatRp(item.price * item.qty)}</div>
          <div class="item-qty-ctrl">
            <button class="qty-btn remove" data-id="${item.id}" data-delta="-1">
              ${item.qty === 1 ? '🗑' : '−'}
            </button>
            <span class="qty-display">${item.qty}</span>
            <button class="qty-btn" data-id="${item.id}" data-delta="1">+</button>
          </div>
        </div>
      </div>
    `).join('');

    // Qty buttons
    container.querySelectorAll('.qty-btn').forEach(btn => {
      btn.addEventListener('click', (e) => {
        e.stopPropagation();
        const id    = parseInt(btn.dataset.id);
        const delta = parseInt(btn.dataset.delta);
        changeQty(id, delta);
      });
    });

    // Note toggles
    container.querySelectorAll('[data-note-toggle]').forEach(el => {
      el.addEventListener('click', () => {
        const id = parseInt(el.dataset.noteToggle);
        const input = document.getElementById(`note-${id}`);
        if (input) {
          const visible = input.style.display !== 'none';
          input.style.display = visible ? 'none' : 'block';
          if (!visible) input.focus();
        }
      });
    });

    // Note inputs
    container.querySelectorAll('.item-note-input').forEach(input => {
      input.addEventListener('input', () => {
        setNote(parseInt(input.dataset.noteId), input.value);
        const toggle = container.querySelector(`[data-note-toggle="${input.dataset.noteId}"]`);
        if (toggle) toggle.textContent = input.value || '+ Tambah catatan...';
      });
    });
  }

  /* ---- Render Summary ---- */
  function renderSummary() {
    const sub   = subtotal();
    const disc  = discountAmt();
    const tx    = tax();
    const tot   = total();
    const cnt   = itemCount();

    setText('summary-subtotal', formatRp(sub));
    setText('summary-discount', disc > 0 ? `− ${formatRp(disc)}` : formatRp(0));
    setText('summary-tax',      formatRp(tx));
    setText('total-amount',     formatRp(tot));

    // Cart badge
    const badge = document.getElementById('cart-badge');
    if (badge) {
      badge.textContent  = cnt;
      badge.style.display = cnt > 0 ? 'inline' : 'none';
    }

    // Checkout button
    const btn = document.getElementById('checkout-btn');
    if (btn) btn.disabled = items.length === 0;

    // Order no
    const noEl = document.getElementById('order-no');
    if (noEl) noEl.textContent = genOrderNo();
  }

  function setText(id, val) {
    const el = document.getElementById(id);
    if (el) el.textContent = val;
  }

  /* ---- Render All ---- */
  function render() {
    renderItems();
    renderSummary();
  }

  /* ---- Checkout ---- */
  async function checkout() {

  if (!items.length) return;

  const payload = {
    produk_id: items.map(i => i.id),
    jumlah: items.map(i => i.qty),
    metode: payMethod,
    bayar: parseInt(document.getElementById('bayar-input').value)
  };

  try {

    const response = await fetch('/kasir/transaksi', {
      method:'POST',
      headers:{
        'Content-Type':'application/json',
        'Accept':'application/json',
        'X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').content
      },
      body: JSON.stringify(payload)
    });

    const data = await response.json();

    if(!response.ok){
      console.error(data);
      Toast.show(data.message || 'Server error','error');
      return;
    }

    if(data.success){
      console.log("DATA TRANSAKSI:", data.transaksi);
      ReceiptModal.show(data.transaksi);
      items = [];
      discount = 0;
      render();
      Toast.show('Pembayaran berhasil','success');
    }

  } catch(err){
    console.error(err);
    Toast.show('Transaksi gagal','error');
  }

}

  /* ---- Init ---- */
  function init() {
    render();

    // Discount input
    const discInput = document.getElementById('discount-input');
    if (discInput) {
      discInput.addEventListener('input', () => {
        discount = Math.min(100, Math.max(0, parseFloat(discInput.value) || 0));
        renderSummary();
      });
    }

    // Payment methods
    document.querySelectorAll('.pay-method').forEach(btn => {
      btn.addEventListener('click', () => {
        document.querySelectorAll('.pay-method').forEach(b => b.classList.remove('selected'));
        btn.classList.add('selected');
        payMethod = btn.dataset.method;
      });
    });

    // Checkout
    const checkoutBtn = document.getElementById('checkout-btn');
    if (checkoutBtn) {
      checkoutBtn.addEventListener('click', checkout);
    }

    // Clear
    const clearBtn = document.getElementById('clear-btn');
    if (clearBtn) {
      clearBtn.addEventListener('click', clearAll);
    }

    // Mobile cart toggle
    const cartToggle = document.getElementById('cart-toggle');
    const orderSidebar = document.getElementById('order-sidebar');
    if (cartToggle && orderSidebar) {
      cartToggle.addEventListener('click', () => {
        orderSidebar.classList.toggle('open');
      });
    }
  }

  return { init, addItem, render };
})();
