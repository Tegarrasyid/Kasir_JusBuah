@extends('layouts.admin.app')

@section('title','Cetak Laporan')
@section('breadcrumb','Laporan')
@section('content')

<!DOCTYPE html>
<html>
<head>
    <title>Cetak Laporan</title>
    <style>
        body { font-family: Arial; }
        table { width:100%; border-collapse: collapse; }
        th, td { border:1px solid #000; padding:8px; text-align:left; }
    </style>
</head>
<body onload="window.print()">

<div class="laporan-page">
    <div class="page-heading">
        <div class="page-heading-left">
            <h1>Cetak Laporan Penjualan</h1>
        </div>
    </div>

    <a href="{{ route('laporan.index') }}" class="btn btn-secondary">
        Kembali
    </a><br><br>

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
                    </tr>
                </thead>
                <tbody>
                    @foreach($transaksi as $trx)
                    <tr>
                        <td>#TRX{{ $trx->id }}</td>
                        <td>{{ $trx->created_at }}</td>
                        <td>{{ $trx->user->name ?? '-' }}</td>
                        <td>Rp {{ number_format($trx->total_bayar,0,',','.') }}</td>
                        <td>{{ $trx->metode_pembayaran }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    

</div>

</body>
</html>

@endsection