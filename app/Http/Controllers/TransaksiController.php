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
        
        $produk = DB::table('produk')
            ->join('kategori', 'produk.kategori_id', '=', 'kategori.id')
            ->where('produk.is_available',1)
            ->select('produk.*','kategori.nama_kategori')
            ->get();

        foreach($produk as $p){

            $reseps = ResepProduk::where('produk_id',$p->id)->get();
            $stokCukup = true;

            foreach($reseps as $resep){

                $bahan = BahanBaku::find($resep->bahan_baku_id);

                if($bahan->stok_tersedia < $resep->jumlah_dibutuhkan){
                    $stokCukup = false;
                    break;
                }
            }

            $p->stok_produk = $stokCukup;
        }

        return view('kasir.dashboard', compact('produk'));
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
            $detailItems = [];

            foreach($request->produk_id as $i => $produkId){

                $produk = Produk::find($produkId);
                $jumlah = $request->jumlah[$i];

                $reseps = ResepProduk::where('produk_id',$produk->id)->get();

                $stokCukup = true;

                foreach($reseps as $resep){

                    $pakai = $resep->jumlah_dibutuhkan * $jumlah;
                    $bahan = BahanBaku::find($resep->bahan_baku_id);

                    if($bahan->stok_tersedia < $pakai){
                        $stokCukup = false;
                        break;
                    }
                }

                if(!$stokCukup){
                    continue;
                }

                $subtotal = $produk->harga_jual * $jumlah;

                $detailItems[] = [
                    'produk'=>$produk,
                    'jumlah'=>$jumlah,
                    'subtotal'=>$subtotal,
                    'reseps'=>$reseps
                ];

                $total += $subtotal;
            }

            $kode = $this->generateKode();

            $transaksi = Transaksi::create([
                'kode_transaksi'=>$kode,
                'user_id'=>Auth::id(),
                'metode_pembayaran'=>$request->metode,
                'total_harga'=>$total,
                'total_bayar'=>$total,
                'nominal_bayar'=>$request->bayar,
                'kembalian'=>$request->bayar - $total,
                'status'=>'selesai'
            ]);

            foreach($request->produk_id as $i => $produkId){

                $produk = Produk::find($produkId);
                $jumlah = $request->jumlah[$i];
                $subtotal = $produk->harga_jual * $jumlah;

                $reseps = ResepProduk::where('produk_id',$produk->id)->get();

                $stokCukup = true;

                foreach($reseps as $resep){

                    $pakai = $resep->jumlah_dibutuhkan * $jumlah;
                    $bahan = BahanBaku::find($resep->bahan_baku_id);

                    if($bahan->stok_tersedia < $pakai){
                        $stokCukup = false;
                        break;
                    }
                }

                if(!$stokCukup){
                    continue;
                }

                DetailTransaksi::create([
                    'transaksi_id'=>$transaksi->id,
                    'produk_id'=>$produk->id,
                    'nama_produk'=>$produk->nama_produk,
                    'harga_satuan'=>$produk->harga_jual,
                    'jumlah'=>$jumlah,
                    'subtotal'=>$subtotal
                ]);

                foreach($reseps as $resep){

                    $pakai = $resep->jumlah_dibutuhkan * $jumlah;
                    $bahan = BahanBaku::find($resep->bahan_baku_id);

                    $bahan->stok_tersedia -= $pakai;
                    $bahan->save();
                }
            }

            DB::commit();
            $transaksi->load('detailTransaksi');

            return response()->json([
                'success' => true,
                'transaksi' => [
                    'id' => $transaksi->kode_transaksi,
                    'timestamp' => now(),
                    'items' => $transaksi->detailTransaksi->map(function($d){
                        return [
                            'name' => $d->nama_produk,
                            'qty' => $d->jumlah,
                            'price' => $d->harga_satuan,
                            'emoji' => '🥤'
                        ];
                    }),
                    'subtotal' => $transaksi->total_harga,
                    'total' => $transaksi->total_harga,
                    'bayar' => $transaksi->nominal_bayar,
                    'change' => $transaksi->kembalian,
                    'payment' => $transaksi->metode_pembayaran
                ]
            ]);

        }catch(\Exception $e){
        DB::rollBack();
        return response()->json(['success' => false,'message' => $e->getMessage()],500);}
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
        $last = Transaksi::orderBy('kode_transaksi','desc')->first();

        if(!$last){
            return 'TRX'.date('Ymd').'001';
        }

        $lastNumber = substr($last->kode_transaksi,-3);
        $newNumber = str_pad($lastNumber + 1,3,'0',STR_PAD_LEFT);

        return 'TRX'.date('Ymd').$newNumber;
    }

}
