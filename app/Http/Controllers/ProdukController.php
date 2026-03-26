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
        $produk = Produk::with('kategori')->latest()->paginate(10);
        $kategori = KategoriProduk::all();
        return view('admin.produk.index', compact('produk','kategori'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategori = KategoriProduk::all();
        return view('admin.produk.create', compact('kategori'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required',
            'kategori_id' => 'required',
            'harga_jual' => 'required',
            'harga_beli' => 'required',
            'harga_diskon' => 'nullable|lte:harga_jual',
        ]);

        if($request->hasFile('foto')){
            $foto = $request->file('foto')->store('produk','public');
        }

        Produk::create([
            'nama_produk' => $request->nama_produk,
            'kategori_id' => $request->kategori_id,
            'deskripsi' => $request->deskripsi,
            'harga_jual' => $request->harga_jual,
            'harga_beli' => $request->harga_beli,
            'harga_diskon' => $request->harga_diskon,
            'foto' => $foto ?? null,
            'is_available' => $request->is_available
        ]);

        return redirect()->route('produk.index')->with('success','Produk berhasil ditambahkan');
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
        $produk = Produk::findOrFail($id);
        $kategori = KategoriProduk::all();
        return view('admin.produk.edit', compact('produk','kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_produk' => 'required',
            'kategori_id' => 'required',
            'harga_jual' => 'required',
            'harga_beli' => 'required',
            'harga_diskon' => 'nullable|lte:harga_jual',
        ]);

        $produk = Produk::findOrFail($id);
        if($request->hasFile('foto')){
            $foto = $request->file('foto')->store('produk','public');
        }else{
            $foto = $produk->foto;
        }

        $produk->update([
            'nama_produk' => $request->nama_produk,
            'kategori_id' => $request->kategori_id,
            'deskripsi' => $request->deskripsi,
            'harga_jual' => $request->harga_jual,
            'harga_beli' => $request->harga_beli, 
            'harga_diskon' => $request->harga_diskon,
            'foto' => $foto,
            'is_available' => $request->is_available
        ]);

        return redirect()->route('produk.index')->with('success','Produk berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $produk = Produk::findOrFail($id);
        $produk->delete();

        return redirect()->route('produk.index')->with('success','Produk berhasil dihapus');    
    }
}
