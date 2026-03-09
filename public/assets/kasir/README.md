# ☕ Amerta — Aplikasi Kasir

Aplikasi kasir modern berbasis HTML/CSS/JS murni. Tidak perlu server, cukup buka `index.html`.

## 📁 Struktur Folder

```
kasir/
├── index.html              ← Halaman utama (semua page ada di sini)
├── css/
│   ├── main.css            ← Variabel, reset, animasi, toast, modal
│   ├── navbar.css          ← Navbar atas (brand, navigasi, jam, avatar)
│   ├── products.css        ← Grid produk & kategori tabs
│   ├── order.css           ← Sidebar pesanan kanan
│   └── transactions.css    ← Halaman riwayat & struk
├── js/
│   ├── products.js         ← Data produk (25 item) & rendering grid
│   ├── order.js            ← Logika keranjang, diskon, pajak, checkout
│   ├── transactions.js     ← Riwayat transaksi & modal struk
│   └── app.js              ← Navigasi, navbar, toast, profil
└── assets/                 ← Folder aset tambahan
```

## ✨ Fitur

### 🏪 Halaman Kasir
- Grid produk 25 item dengan 4 kategori (Minuman, Makanan, Dessert, Paket)
- Filter kategori dengan tab yang elegan
- Pencarian produk real-time
- Badge produk: 🔥 Hot, ✨ New, 🏷 Promo
- Indikator stok habis

### 🛒 Sidebar Pesanan (Kanan)
- Tambah/kurangi/hapus item
- Catatan per item
- Pilih nama pelanggan & nomor meja
- Diskon persentase
- Otomatis hitung subtotal + diskon + pajak 10%
- 6 metode pembayaran: Tunai, QRIS, Debit, Kredit, GoPay, OVO
- Tombol checkout

### 🧾 Struk & Riwayat
- Modal struk otomatis setelah checkout
- Bisa dicetak (Ctrl+P)
- Halaman riwayat semua transaksi
- Filter hari ini / semua
- Statistik: transaksi hari ini, pendapatan, rata-rata nilai

### 👤 Profil
- Info kasir
- Statistik personal dari localStorage
- Pengaturan cepat

## 💾 Data Persistence
Semua transaksi tersimpan di `localStorage` browser. Data tidak hilang saat refresh.

## 🚀 Cara Pakai
Buka `index.html` di browser modern (Chrome, Firefox, Edge). Tidak perlu instalasi apapun.
