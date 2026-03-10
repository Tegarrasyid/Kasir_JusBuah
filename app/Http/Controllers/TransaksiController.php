<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use App\Models\DetailTransaksi;
use App\Models\Produk;
use App\Models\ResepProduk;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $produk = Produk::where('is_available',1)->get();

        return view('kasir.transaksi.index',compact('produk'));
    }

    public function riwayat()
    {
        $transaksi = Transaksi::latest()->get();
        return view('kasir.transaksi.riwayat', compact('transaksi'));
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
        DB::beginTransaction();

        try{

            $total = 0;

            foreach($request->produk_id as $i => $produkId){
                $produk = Produk::find($produkId);
                $jumlah = $request->jumlah[$i];
                $subtotal = $produk->harga_jual * $jumlah;
                $total += $subtotal;
            }

            $kode = $this->generateKode();

            $transaksi = Transaksi::create([
                'kode_transaksi'=>$kode,
                'user_id'=>Auth::id(),
                'metode_pembayaran'=>$request->metode,
                'total_harga'=>$total,
                'nilai_diskon'=>0,
                'total_bayar'=>$total,
                'nominal_bayar'=>$request->bayar,
                'kembalian'=>$request->bayar - $total,
                'status'=>'selesai'
            ]);

            foreach($request->produk_id as $i => $produkId){

                $produk = Produk::find($produkId);
                $jumlah = $request->jumlah[$i];
                $subtotal = $produk->harga_jual * $jumlah;

                DetailTransaksi::create([
                    'transaksi_id'=>$transaksi->id,
                    'produk_id'=>$produk->id,
                    'nama_produk'=>$produk->nama_produk,
                    'harga_satuan'=>$produk->harga_jual,
                    'jumlah'=>$jumlah,
                    'subtotal'=>$subtotal
                ]);

                $reseps = ResepProduk::where('produk_id',$produk->id)->get();

                foreach($reseps as $resep){
                    $pakai = $resep->jumlah_dibutuhkan * $jumlah;
                    $bahan = BahanBaku::find($resep->bahan_baku_id);
                    $bahan->stok_tersedia -= $pakai;
                    $bahan->save();

                    if($bahan->stok_tersedia <= $bahan->stok_minimum){

                        session()->flash('warning','Stok '.$bahan->nama_bahan.' hampir habis!');
                    }

                }
            }

            DB::commit();
            return redirect()->back()->with('success','Transaksi berhasil');

        }catch(\Exception $e){
            DB::rollBack();
            return back()->with('error','Transaksi gagal');
        }
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

    private function generateKode()
    {
        $last = Transaksi::latest()->first();

        if(!$last){
            return 'TRX'.date('Ymd').'001';
        }

        $lastNumber = substr($last->kode_transaksi,-3);
        $newNumber = str_pad($lastNumber+1,3,'0',STR_PAD_LEFT);

        return 'TRX'.date('Ymd').$newNumber;
    }
}
