<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use App\Models\PembelianStok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PembelianStokController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pembelian = PembelianStok::with('bahanBaku')->get();
        $bahan = BahanBaku::all();

        return view('admin.pembelian.index',compact('pembelian','bahan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $total = $request->jumlah_beli * $request->harga_beli;

        PembelianStok::create([
            'bahan_baku_id'=>$request->bahan_baku_id,
            'jumlah_beli'=>$request->jumlah_beli,
            'harga_beli_satuan'=>$request->harga_beli,
            'total_harga'=>$total,
            'tanggal_beli'=>now(),
            'user_id'=>Auth::id()
        ]);

        $bahan = BahanBaku::find($request->bahan_baku_id);

        $bahan->stok_tersedia += $request->jumlah_beli;
        $bahan->save();

        return back()->with('success','Stok berhasil ditambah');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
