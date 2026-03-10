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
        $resep = ResepProduk::with(['produk','bahan'])->get()->groupBy('produk_id');

        return view('admin.resep.index',compact('resep'));  
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $produk = Produk::all();
        $bahan = BahanBaku::all();

        return view('admin.resep.create', compact('produk','bahan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'produk_id' => 'required',
            'bahan_baku_id' => 'required',
            'jumlah_dibutuhkan' => 'required|numeric'
        ]);

        ResepProduk::create([
            'produk_id'=>$request->produk_id,
            'bahan_baku_id'=>$request->bahan_baku_id,
            'jumlah_dibutuhkan'=>$request->jumlah_dibutuhkan
        ]);

        return redirect()->route('resep.index')->with('success','Resep berhasil ditambahkan');
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
    public function edit($id)
    {
        $resep = ResepProduk::findOrFail($id);
        $produk = Produk::all();
        $bahan = BahanBaku::all();

        return view('admin.resep.edit', compact('resep','produk','bahan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $resep = ResepProduk::findOrFail($id);

        $resep->update([
            'produk_id'=>$request->produk_id,
            'bahan_baku_id'=>$request->bahan_baku_id,
            'jumlah_dibutuhkan'=>$request->jumlah_dibutuhkan
        ]);

        return redirect()->route('resep.index')
            ->with('success','Resep berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    
    public function destroy($id)
    {
        ResepProduk::destroy($id);

        return redirect()->route('resep.index')
            ->with('success','Resep berhasil dihapus');
    }

}
