<?php

namespace App\Http\Controllers;

use App\Models\KategoriProduk;
use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $produk = Produk::with('kategori')->get();
        $kategori = KategoriProduk::all();

        return view('admin.produk.index', compact('produk','kategori'));
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
        Produk::create([
            'kategori_id'=>$request->kategori_id,
            'nama_produk'=>$request->nama_produk,
            'deskripsi'=>$request->deskripsi,
            'harga_jual'=>$request->harga_jual,
            'foto'=>$request->foto,
            'is_available'=>1
        ]);

        return back()->with('success','Produk berhasil ditambahkan');
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
        $produk = Produk::findOrFail($id);

        $produk->update([
            'kategori_id'=>$request->kategori_id,
            'nama_produk'=>$request->nama_produk,
            'deskripsi'=>$request->deskripsi,
            'harga_jual'=>$request->harga_jual
        ]);

        return back()->with('success','Produk berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Produk::destroy($id);

        return back()->with('success','Produk berhasil dihapus');
    }
}
