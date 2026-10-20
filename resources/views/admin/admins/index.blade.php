@extends('admin.layout')

@section('title', 'Kelola Akun Admin')

@section('content')
    <div class="page-head">
        <h1>Akun Admin</h1>
        <a class="btn btn-primary" href="{{ route('admin.admins.create') }}">+ Tambah akun admin</a>
    </div>

    <div class="table-scroll">
        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Microsite</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($admins as $admin)
                    <tr>
                        <td>{{ $admin->name }}</td>
                        <td>{{ $admin->username }}</td>
                        <td>
                            <span class="badge {{ $admin->isSuperAdmin() ? 'badge-info' : 'badge-off' }}">
                                {{ $admin->isSuperAdmin() ? 'Super admin' : 'Admin' }}
                            </span>
                        </td>
                        <td>{{ $admin->isSuperAdmin() ? 'Semua' : $admin->microsites->pluck('name')->join(', ') }}</td>
                        <td>
                            <div class="actions">
                                <a class="btn btn-secondary btn-sm" href="{{ route('admin.admins.edit', $admin) }}">Ubah</a>
                                <form class="inline" method="POST" action="{{ route('admin.admins.destroy', $admin) }}"
                                    onsubmit="return confirm('Hapus akun ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" type="submit">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="empty">Belum ada akun admin.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
