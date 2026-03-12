<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;

class LaporanController extends Controller
{

    public function index()
    {
        $transaksi = Transaksi::with('user')->latest()->get();  
        return view('admin.laporan.index', compact('transaksi'));
    }


    public function show($id)
    {
        $transaksi = Transaksi::with('detailTransaksi.produk','user')->findOrFail($id);
        return view('admin.laporan.detail', compact('transaksi'));
    }

}