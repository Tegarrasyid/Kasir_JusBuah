<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PembelianStok extends Model
{
    protected $table = 'pembelian_stok';

    protected $fillable = [
        'user_id',
        'bahan_baku_id',
        'jumlah_beli',
        'harga_beli_satuan',
        'total_harga',
        'tanggal_beli',
        'catatan'
    ];

    public function bahan()
    {
        return $this->belongsTo(BahanBaku::class,'bahan_baku_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}