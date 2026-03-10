<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResepProduk extends Model
{
    protected $table = 'resep_produk';

    protected $fillable = [
        'produk_id',
        'bahan_baku_id',
        'jumlah_dibutuhkan'
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }

    public function bahan()
    {
        return $this->belongsTo(BahanBaku::class, 'bahan_baku_id');
    }
}