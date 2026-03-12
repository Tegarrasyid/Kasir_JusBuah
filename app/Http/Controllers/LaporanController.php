<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LaporanController extends Controller
{


    public function index(Request $request)
    {

        $period = $request->period;

        $query = Transaksi::with('user');

        if($period == 'day'){
            $query->whereDate('created_at', Carbon::today());
        }

        elseif($period == 'week'){
            $query->whereBetween('created_at', [
                Carbon::now()->subDays(7),
                Carbon::now()
            ]);
        }

        elseif($period == 'month'){
            $query->whereBetween('created_at', [
                Carbon::now()->subDays(30),
                Carbon::now()
            ]);
        }

        $transaksi = $query->latest()->get();

        return view('admin.laporan.index',compact('transaksi','period'));

    }


    public function show($id)
    {
        $transaksi = Transaksi::with('detailTransaksi.produk','user')->findOrFail($id);
        return view('admin.laporan.detail', compact('transaksi'));
    }

}