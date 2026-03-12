<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
            'phone' => 'nullable',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $foto = null;

        if($request->hasFile('foto')){
            $foto = $request->file('foto')->store('users','public');
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'foto' => $foto,
            'is_admin' => $request->is_admin,
            'is_active' => $request->is_active
        ]);

        return redirect()->route('users.index')
            ->with('success','Pengguna berhasil ditambahkan');
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
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'is_admin' => $request->is_admin,
            'is_active' => $request->is_active,
        ];

        // jika password diisi
        if($request->password){
            $data['password'] = bcrypt($request->password);
        }

        // upload foto
        if($request->hasFile('foto')){
            $foto = $request->file('foto')->store('users','public');
            $data['foto'] = $foto;
        }

        $user->update($data);

        return redirect()->route('users.index')
        ->with('success','Data pengguna berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'Admin berhasil dihapus.');
    }

    public function dashboardData(Request $request)
    {
        $period = $request->period ?? 'week';

        if ($period == 'day') {
            $start = Carbon::today();
        } elseif ($period == 'week') {
            $start = Carbon::now()->subDays(7);
        } else {
            $start = Carbon::now()->subDays(30);
        }

        $sales = Transaksi::with(['detailTransaksi.produk.kategori','user'])
            ->where('created_at','>=',$start)
            ->get();

        $data = $sales->map(function($trx){

            return [
                "id" => $trx->kode_transaksi,
                "timestamp" => $trx->created_at,
                "kasir" => $trx->user->name ?? 'Kasir',
                "total" => (int) $trx->total_harga,

                "items" => $trx->detailTransaksi->map(function($d){

                    return [
                        "id" => $d->produk_id,
                        "name" => $d->nama_produk,
                        "price" => (int) $d->harga_satuan,
                        "qty" => (int) $d->jumlah,
                        "emoji" => "🍽️",
                        "category" => $d->produk->kategori->nama ?? "Lainnya"
                    ];

                })->values()
            ];

        });

        return response()->json($data);
    }
}
