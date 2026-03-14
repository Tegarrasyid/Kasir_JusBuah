<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use Illuminate\Http\Request;

class BahanBakuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bahan = BahanBaku::all();
        return view('admin.bahan.index', compact('bahan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.bahan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_bahan' => 'required',
            'satuan' => 'required',
            'harga_beli' => 'required|numeric',
            'stok_tersedia' => 'required|numeric',
            'stok_minimum' => 'required|numeric',
        ]);

        BahanBaku::create([
            'nama_bahan' => $request->nama_bahan,
            'satuan' => $request->satuan,
            'harga_beli' => $request->harga_beli,
            'stok_tersedia' => $request->stok_tersedia,
            'stok_minimum' => $request->stok_minimum,
        ]);

        return redirect()->route('bahan-baku.index')->with('success','Bahan baku berhasil ditambahkan');
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
        $bahan = BahanBaku::findOrFail($id);
        return view('admin.bahan.edit', compact('bahan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_bahan' => 'required',
            'satuan' => 'required',
            'harga_beli' => 'required|numeric',
            'stok_tersedia' => 'required|numeric',
            'stok_minimum' => 'required|numeric',
        ]);

        $bahan = BahanBaku::findOrFail($id);
        $bahan->update([
            'nama_bahan' => $request->nama_bahan,
            'satuan' => $request->satuan,
            'harga_beli' => $request->harga_beli,
            'stok_tersedia' => $request->stok_tersedia,
            'stok_minimum' => $request->stok_minimum,
        ]);

        return redirect()->route('bahan-baku.index')->with('success','Bahan baku berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy($id)
    {
        $bahan = BahanBaku::findOrFail($id);
        $bahan->delete();
        return redirect()->route('bahan-baku.index')->with('success','Bahan baku berhasil dihapus');
    }

}
