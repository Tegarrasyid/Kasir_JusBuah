<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'produk';

    protected $fillable = [
        'nama_produk',
        'kategori_id',
        'deskripsi',
        'harga_jual',
        'harga_beli',
        'diskon_persen',
        'foto',
        'is_available'
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriProduk::class, 'kategori_id');
    }

    public function resep()
    {
        return $this->hasMany(ResepProduk::class, 'produk_id');
    }

    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class, 'produk_id');
    }
}