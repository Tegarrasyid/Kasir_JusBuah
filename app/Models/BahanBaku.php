<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BahanBaku extends Model
{
    protected $table = 'bahan_baku';

    protected $fillable = [
        'nama_bahan',
        'satuan',
        'harga_beli',
        'stok_tersedia',
        'stok_minimum',
    ];

    public function resep()
    {
        return $this->hasMany(ResepProduk::class, 'bahan_baku_id');
    }

    public function pembelian()
    {
        return $this->hasMany(PembelianStok::class, 'bahan_baku_id');
    }
}