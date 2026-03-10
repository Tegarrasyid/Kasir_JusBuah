@extends('layouts.admin.app')

@section('title', 'Edit Pengguna')
@section('breadcrumb','Pengguna')
@section('content')

    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
        <div>
            <h3 class="fw-bold">Edit Pengguna</h3>
        </div>
    </div>
    <div class="card card-body">
        <form action="{{ route('users.update',$user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

            <!-- Nama -->
            <div class="form-group mb-3">
                <label class="form-label">Nama Pengguna</label>
                <input type="text" class="form-control" name="name"
                value="{{ old('name',$user->name) }}">
            </div>

            <!-- Email -->
            <div class="form-group mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" name="email"
                value="{{ old('email',$user->email) }}">
            </div>

            <!-- Password -->
            <div class="form-group mb-3">
                <label class="form-label">Password (Kosongkan jika tidak diganti)</label>
                <input type="password" class="form-control" name="password">
            </div>

            <!-- Nomor HP -->
            <div class="form-group mb-3">
                <label class="form-label">No HP</label>
                <input type="text" class="form-control" name="phone"
                value="{{ old('phone',$user->phone) }}">
            </div>

            <!-- Role -->
            <div class="form-group mb-3">
                <label class="form-label">Role Pengguna</label>
                <select name="is_admin" class="form-control">

                    <option value="0" {{ $user->is_admin == 0 ? 'selected' : '' }}>
                        Kasir
                    </option>

                    <option value="1" {{ $user->is_admin == 1 ? 'selected' : '' }}>
                        Admin
                    </option>

                </select>
            </div>

            <!-- Status -->
            <div class="form-group mb-3">
                <label class="form-label">Status</label>
                <select name="is_active" class="form-control">

                    <option value="1" {{ $user->is_active == 1 ? 'selected' : '' }}>
                        Aktif
                    </option>

                    <option value="0" {{ $user->is_active == 0 ? 'selected' : '' }}>
                        Non Aktif
                    </option>

                </select>
            </div>

            <!-- Foto -->
            <div class="form-group mb-3">
                <label class="form-label">Foto Profil</label>

                @if($user->foto)
                <div class="mb-2">
                    <img src="{{ asset('storage/'.$user->foto) }}" width="80">
                </div>
                @endif

                <input type="file" class="form-control" name="foto">
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    Update
                </button>

                <a href="{{ route('users.index') }}" class="btn btn-secondary">
                    Batal
                </a>
            </div>
        </form>
    </div>

@endsection