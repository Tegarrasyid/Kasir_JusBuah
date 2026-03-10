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
        $data = PembelianStok::with('bahan','user')->latest()->get();
        return view('admin.pembelian.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $bahan = BahanBaku::all();
        return view('admin.pembelian.create',compact('bahan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'bahan_baku_id' => 'required',
            'jumlah_beli' => 'required',
            'harga_beli_satuan' => 'required',
            'tanggal_beli' => 'required'
        ]);

        $total = $request->jumlah_beli * $request->harga_beli_satuan;

        PembelianStok::create([
            'user_id' => auth()->id(),
            'bahan_baku_id' => $request->bahan_baku_id,
            'jumlah_beli' => $request->jumlah_beli,
            'harga_beli_satuan' => $request->harga_beli_satuan,
            'total_harga' => $total,
            'tanggal_beli' => $request->tanggal_beli,
            'catatan' => $request->catatan
        ]);

        $bahan = BahanBaku::find($request->bahan_baku_id);

        $bahan->stok_tersedia += $request->jumlah_beli;
        $bahan->save();

        return redirect()->route('pembelian-stok.index')->with('success','Pembelian stok berhasil ditambahkan');
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
        $data = PembelianStok::findOrFail($id);
        $bahan = BahanBaku::all();

        return view('admin.pembelian.edit',compact('data','bahan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $data = PembelianStok::findOrFail($id);

        $total = $request->jumlah_beli * $request->harga_beli_satuan;

        $data->update([
            'bahan_baku_id' => $request->bahan_baku_id,
            'jumlah_beli' => $request->jumlah_beli,
            'harga_beli_satuan' => $request->harga_beli_satuan,
            'total_harga' => $total,
            'tanggal_beli' => $request->tanggal_beli,
            'catatan' => $request->catatan
        ]);

        return redirect()->route('pembelian-stok.index')->with('success','Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = PembelianStok::findOrFail($id);
        $data->delete();
        return redirect()->route('pembelian-stok.index')->with('success','Data berhasil dihapus');
    }
}
