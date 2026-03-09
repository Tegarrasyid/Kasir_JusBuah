# 🌿 Amerta — Admin Panel

Panel administrasi lengkap untuk sistem kasir. Buka `index.html` langsung di browser.

## 📁 Struktur Folder

```
admin/
├── index.html          ← Halaman utama (semua halaman SPA)
├── css/
│   ├── base.css        ← Variabel, reset, komponen dasar (form, btn, table, modal, toast)
│   ├── layout.css      ← Sidebar kiri, topbar, main content area
│   ├── dashboard.css   ← Stat cards, bar chart, donut chart, widget
│   └── pages.css       ← Gaya spesifik tiap halaman CRUD
├── js/
│   ├── store.js        ← Data store (localStorage), sample data 30 hari, helpers
│   ├── app.js          ← Navigasi SPA, topbar clock, toast, modal manager
│   ├── dashboard.js    ← Chart, statistik, top produk, transaksi terbaru
│   └── pages.js        ← Semua 7 halaman CRUD + laporan
└── pages/              ← (reserved untuk pengembangan)
```

## ✨ Fitur Halaman

### 📊 Dashboard
- Statistik: Pendapatan, Transaksi, Item Terjual, Rata-rata/Order
- Perbandingan dengan periode sebelumnya (% naik/turun)
- Filter: Hari Ini / 7 Hari / 30 Hari
- Bar chart pendapatan
- Donut chart komposisi kategori
- Top 6 produk terlaris
- Transaksi terbaru

### 👥 Manajemen Pengguna
- CRUD pengguna: Admin, Kasir, Manajer
- Status aktif/nonaktif
- Pencarian realtime

### 🏷 Manajemen Kategori
- CRUD kategori produk dengan emoji & deskripsi
- Menampilkan jumlah produk per kategori

### 📦 Manajemen Produk
- CRUD produk dengan harga jual & HPP (modal)
- Pilih kategori, status stok tersedia/habis

### 🌾 Manajemen Bahan Baku
- CRUD bahan baku: nama, satuan, stok, stok minimum, harga/satuan
- Indikator visual: stok aman (hijau) / menipis (kuning) / habis (merah)

### 📋 Manajemen Resep
- Atur komposisi bahan baku per produk
- Tambah/hapus bahan dalam resep

### 🔄 Manajemen Tambah Stok
- Input penambahan stok bahan baku
- Riwayat log penambahan stok
- Peringatan otomatis stok menipis

### 📈 Laporan Penjualan
- Filter: Hari Ini / 7 Hari / 30 Hari
- 6 kartu ringkasan (pendapatan, transaksi, item, avg, pajak, diskon)
- Breakdown metode pembayaran
- Performa kasir per periode
- Tabel detail transaksi (50 terbaru)

## 💾 Data
Semua data tersimpan di `localStorage`. Data sample penjualan 30 hari digenerate otomatis.
