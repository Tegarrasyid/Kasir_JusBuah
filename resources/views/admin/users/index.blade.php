@extends('layouts.admin.app')

@section('title','All User')
@section('breadcrumb','Users')
@section('content')



    <!-- =================== USERS =================== -->
    <div>
      <div class="page-heading">
        <div class="page-heading-left">
          <h1>Manajemen Pengguna</h1>
          <p>Kelola akun admin, kasir, dan manajer</p>
        </div>
      </div>
      <div class="crud-toolbar">
        <div class="input-group">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
          <input id="users-search" type="text" placeholder="Cari pengguna..."/>
        </div>
        <div class="crud-actions">
          <button class="btn btn-primary" id="btn-add-user">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Tambah Pengguna
          </button>
        </div>
      </div>
      <div class="card" style="padding:0;overflow:hidden">
        <div class="table-wrap">
          <table class="data-table">
            <thead><tr>
              <th>Pengguna</th><th>Email</th><th>Telepon</th><th>Status</th><th>Aksi</th>
            </tr></thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone ?? '-' }}</td>
                    <td>
                        <span class="badge">
                            {{ $user->is_admin ? 'Admin' : 'Kasir' }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('users.edit',$user->id) }}" class="btn btn-sm btn-warning">Edit</a>

                        <form action="{{ route('users.destroy',$user->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
                </tbody>
          </table>
        </div>
      </div>
    </div>

@endsection