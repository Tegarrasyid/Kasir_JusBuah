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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        BahanBaku::create([
            'nama_bahan'=>$request->nama_bahan,
            'satuan'=>$request->satuan,
            'stok_tersedia'=>$request->stok,
            'stok_minimum'=>$request->stok_minimum,
            'harga_beli'=>$request->harga_beli
        ]);

        return back()->with('success','Bahan berhasil ditambah');
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
        $bahan = BahanBaku::findOrFail($id);

        $bahan->update([
            'nama_bahan'=>$request->nama_bahan,
            'satuan'=>$request->satuan,
            'stok_tersedia'=>$request->stok,
            'stok_minimum'=>$request->stok_minimum,
            'harga_beli'=>$request->harga_beli
        ]);

        return back()->with('success','Bahan berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        BahanBaku::destroy($id);

        return back()->with('success','Bahan berhasil dihapus');
    }
}
