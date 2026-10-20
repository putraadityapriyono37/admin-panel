@extends('admin.layout')

@section('title', 'Kelola Akun Admin')

@section('content')
    <h1>Akun Admin</h1>
    <p><a href="{{ route('admin.admins.create') }}">+ Tambah akun admin</a></p>

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
            @foreach ($admins as $admin)
                <tr>
                    <td>{{ $admin->name }}</td>
                    <td>{{ $admin->username }}</td>
                    <td>{{ $admin->isSuperAdmin() ? 'Super admin' : 'Admin' }}</td>
                    <td>{{ $admin->isSuperAdmin() ? 'Semua' : $admin->microsites->pluck('name')->join(', ') }}</td>
                    <td>
                        <a href="{{ route('admin.admins.edit', $admin) }}">Ubah</a>
                        <form class="inline" method="POST" action="{{ route('admin.admins.destroy', $admin) }}"
                            onsubmit="return confirm('Hapus akun ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
