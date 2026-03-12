@extends('layouts.admin.app')

@section('title','Laporan Penjualan')
@section('breadcrumb','Laporan')
@section('content')

<div class="laporan-page">
    <div class="page-heading">
        <div class="page-heading-left">
            <h1>Laporan Penjualan</h1>
            <p>Semua transaksi yang dilakukan kasir</p>
        </div>
    </div>

    <div class="card" style="padding:0;overflow:hidden">
        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>No Order</th>
                        <th>Tanggal</th>
                        <th>Kasir</th>
                        <th>Total</th>
                        <th>Pembayaran</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($transaksi as $trx)
                    <tr>
                        <td>#TRX{{ $trx->id }}</td>
                        <td>{{ $trx->created_at->format('d M Y H:i') }}</td>
                        <td>{{ $trx->user->name ?? '-' }}</td>
                        <td>Rp {{ number_format($trx->total_bayar,0,',','.') }}</td>
                        <td>{{ $trx->metode_pembayaran }}</td>
                        <td><a href="{{ route('laporan.show',$trx->id) }}" class="btn btn-primary btn-sm">Detail</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection