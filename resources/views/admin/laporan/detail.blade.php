@extends('layouts.admin.app')

@section('title','Detail Transaksi')
@section('breadcrumb','Detail Laporan')
@section('content')

<div class="detail-page">
    <div class="page-heading">
        <h2>Detail Transaksi</h2>
        <p>Informasi transaksi pelanggan</p>
    </div>

    <div class="card">
        <p><b>No Order :</b> #TRX{{ $transaksi->id }}</p>
        <p><b>Kasir :</b> {{ $transaksi->user->name }}</p>
        <p><b>Tanggal :</b> {{ $transaksi->created_at }}</p>
    </div>

    <div class="card" style="margin-top:20px">
        <table class="data-table">
            <thead>
                <tr>
                <th>Produk</th>
                <th>Harga</th>
                <th>Qty</th>
                <th>Subtotal</th>
                <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaksi->detailTransaksi as $item)
                <tr>
                    <td>{{ $item->produk->nama_produk }}</td>
                    <td>Rp {{ number_format($item->harga_satuan,0,',','.') }}</td>
                    <td>{{ $item->jumlah }}</td>
                    <td>Rp {{ number_format($item->subtotal,0,',','.') }}</td>
                    <td><a href="{{ route('laporan.index') }}" class="btn btn-primary btn-sm">Kembali</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection