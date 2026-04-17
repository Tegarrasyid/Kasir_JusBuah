<!-- ============================
      ORDER SIDEBAR (Right)
      ============================ -->
<aside class="order-sidebar" id="order-sidebar">

  {{-- QR Code --}}
  <div id="qr-modal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.6); justify-content:center; align-items:center;">
    <div style="background:#fff; padding:20px; border-radius:10px; text-align:center; display:flex; flex-direction:column; gap:12px;">
      <h3 >Scan QR untuk Pembayaran</h3>
      <div id="qr-container"></div>
      <button onclick="confirmQRPayment()">✅ Sudah Dibayar</button>
      <button onclick="closeQR()">Tutup</button>
    </div>
  </div>
  <!-- Order Header -->
  <div class="order-header">
    <div class="order-header-top">
      <span class="order-title">🛒 Pesanan</span>
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

  <!-- Order Items -->
  <div class="order-items" id="order-items-list"></div>

  <!-- Summary & Checkout -->
  <div class="order-summary">

    <!-- Summary Lines -->
    <div class="summary-row">
      <span>Subtotal</span>
      <span id="summary-subtotal">Rp 0</span>
    </div>
    <div class="summary-row">
      <span>Diskon</span>
      <span id="summary-discount" style="color:var(--green)">Rp 0</span>
    </div>

    <div class="summary-divider"></div>

    <div class="summary-total" style="margin-bottom:10px">
      <span class="total-label">Total</span>
      <span class="total-amount" id="total-amount">Rp 0</span>
    </div>

    <div class="payment-input">
    <label for="bayar-input" class="payment-label">Nominal Bayar</label>
    <input type="text" id="bayar-input" class="payment-field" placeholder="Masukkan uang pelanggan" required>
    </div>

    <div class="payment-input" id="debit-input-group" style="display:none;">
      <label for="debit-id" class="payment-label">ID Debit</label>
      <input type="text" id="debit-id" class="payment-field" placeholder="Masukkan ID / No Referensi">
    </div>

    <div class="summary-row">
      <span>Kembalian</span>
      <span id="summary-change">Rp 0</span>
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