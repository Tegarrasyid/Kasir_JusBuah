@extends('layouts.admin.app')

@section('title', 'Tambah Pengguna')

@section('breadcrumb','Pengguna')
@section('content')

    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
        <div>
            <h3 class="fw-bold">Tambah Pengguna</h3>
        </div>
    </div>

    <div class="card card-body">

        <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
            <!-- Nama -->
            <div class="form-group mb-3">
                <label class="form-label">Nama Pengguna</label>
                <input type="text" class="form-control" name="name" placeholder="Masukan Nama Pengguna" value="{{ old('name') }}">
            </div>

            <!-- Email -->
            <div class="form-group mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" name="email" placeholder="Masukan Email Pengguna" value="{{ old('email') }}">
            </div>

            <!-- Password -->
            <div class="form-group mb-3">
                <label class="form-label">Password</label>
                <input type="password" class="form-control" name="password" placeholder="Masukan Password">
            </div>

            <!-- Konfirmasi Password -->
            <div class="form-group mb-3">
                <label class="form-label">Konfirmasi Password</label>
                <input type="password" class="form-control" name="password_confirmation" placeholder="Konfirmasi Password">
            </div>

            <!-- Nomor HP -->
            <div class="form-group mb-3">
                <label class="form-label">No HP</label>
                <input type="text" class="form-control" name="phone" placeholder="Masukan Nomor HP" value="{{ old('phone') }}">
            </div>

            <!-- Role -->
            <div class="form-group mb-3">
                <label class="form-label">Role Pengguna</label>
                <select name="is_admin" class="form-control">
                    <option value="0">Kasir</option>
                    <option value="1">Admin</option>
                </select>
            </div>

            <!-- Status -->
            <div class="form-group mb-3">
                <label class="form-label">Status</label>
                <select name="is_active" class="form-control">
                    <option value="1">Aktif</option>
                    <option value="0">Non Aktif</option>
                </select>
            </div>

            <!-- Foto -->
            <div class="form-group mb-3">
                <label class="form-label">Foto Profil</label>
                <input type="file" class="form-control" name="foto">
            </div>

            <!-- Tombol -->
            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    Simpan
                </button>
                <a href="{{ route('users.index') }}" class="btn btn-secondary">
                    Batal
                </a>
            </div>
        </form>
    </div>

@endsection
