<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use App\Models\Produk;
use App\Models\ResepProduk;
use Illuminate\Http\Request;

class ResepProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $resep = ResepProduk::with('produk','bahanBaku')->get();
        $produk = Produk::all();
        $bahan = BahanBaku::all();

        return view('admin.resep.index',compact('resep','produk','bahan'));    
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
        ResepProduk::create([
            'produk_id'=>$request->produk_id,
            'bahan_baku_id'=>$request->bahan_baku_id,
            'jumlah_dibutuhkan'=>$request->jumlah
        ]);

        return back()->with('success','Resep ditambahkan');
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
        ResepProduk::destroy($id);

        return back()->with('success','Resep dihapus');
    }
}
