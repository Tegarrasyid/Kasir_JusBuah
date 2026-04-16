<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LaporanController extends Controller
{


    public function index(Request $request)
    {
        $query = Transaksi::with('user')->latest();

        // FILTER PERIOD (yang tombol atas)
        if ($request->period == 'day') {
            $query->whereDate('created_at', today());
        } elseif ($request->period == 'week') {
            $query->where('created_at', '>=', now()->subDays(7));
        } elseif ($request->period == 'month') {
            $query->where('created_at', '>=', now()->subDays(30));
        }

        // FILTER TANGGAL CUSTOM
        if ($request->start_date && $request->end_date) {
            $query->whereBetween('created_at', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);
        }

        $transaksi = $query->get();

        return view('admin.laporan.index', compact('transaksi'));
    }


    public function show($id)
    {
        $transaksi = Transaksi::with('detailTransaksi.produk','user')->findOrFail($id);
        return view('admin.laporan.detail', compact('transaksi'));
    }

    public function print(Request $request)
    {
        $query = Transaksi::with('user');

        // ✅ Jika ada filter tanggal
        if ($request->start_date && $request->end_date) {
            $query->whereBetween('created_at', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);
        }

        // ❗ Jika tidak ada filter → otomatis ambil semua data

        $transaksi = $query->get();

        return view('admin.laporan.print', compact('transaksi'));
    }

}