<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KategoriProdukController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\BahanBakuController;
use App\Http\Controllers\ResepProdukController;
use App\Http\Controllers\PembelianStokController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DetailTransaksiController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\Auth;


Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes(
    [
        'register' => false, // Disable registration routes
        'reset' => false,    // Disable password reset routes
        'verify' => false,   // Disable email verification routes
        'confirm' => false,  // Disable password confirmation routes
    ]
);

Route::get('/home', function () {

    if(Auth::user()->is_admin){
        return redirect()->route('admin.dashboard');
    }else{
        return redirect()->route('kasir.dashboard');
    }

})->middleware('auth')->name('home');

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
    Route::get('/laporan', [LaporanController::class,'index'])->name('laporan.index');
    Route::get('/laporan/{id}', [LaporanController::class,'show'])->name('laporan.show');

});

//route untuk kasir
Route::middleware(['auth'])->prefix('kasir')->group(function () {

    Route::get('/dashboard', [TransaksiController::class,'index'])->name('kasir.dashboard');

    Route::post('/transaksi', [TransaksiController::class,'store'])->name('transaksi.store');

    Route::get('/profil', function () {$user = Auth::user(); return view('kasir.profil', compact('user'));})->name('kasir.profil');

    Route::get('/riwayat-transaksi', [TransaksiController::class, 'riwayat'])->name('transaksi.riwayat');

    Route::get('/transaksi/data', [TransaksiController::class, 'data']);

    Route::post('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('kasir.profile.update-password');
    
});