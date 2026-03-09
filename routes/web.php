<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KategoriProdukController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\BahanBakuController;
use App\Http\Controllers\ResepProdukController;
use App\Http\Controllers\PembelianStokController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\DetailTransaksiController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {

        if(Auth::user()->is_admin){
            return redirect()->route('admin.dashboard');
        }else{
            return redirect()->route('kasir.dashboard');
        }

    })->name('dashboard');

});

//route untuk admin
Route::middleware(['auth','admin'])->prefix('admin')->group(function () {

    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
    
    Route::resource('users', AdminController::class);
    Route::resource('kategori', KategoriProdukController::class);
    Route::resource('produk', ProdukController::class);
    Route::resource('bahan-baku', BahanBakuController::class);
    Route::resource('resep', ResepProdukController::class);
    Route::resource('pembelian-stok', PembelianStokController::class);

});

//route untuk kasir
Route::middleware(['auth'])->prefix('kasir')->group(function () {

    Route::get('/dashboard', function () {
        return view('kasir.dashboard');
    })->name('kasir.dashboard');

    Route::resource('transaksi', TransaksiController::class)
        ->only(['index','store']);

    Route::get('/riwayat-transaksi', [TransaksiController::class, 'riwayat'])
        ->name('transaksi.riwayat');
    
    Route::get('/profil', function () {return view('kasir.profil');})
        ->name('kasir.profil');

});