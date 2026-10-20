@extends('admin.layout')

@section('title', 'Kelola Microsite')

@section('content')
    <h1>Microsite</h1>
    <p><a href="{{ route('admin.microsites.create') }}">+ Tambah microsite</a></p>

    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>Slug</th>
                <th>Domain</th>
                <th>Status</th>
                <th>Jumlah admin</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($microsites as $microsite)
                <tr>
                    <td>{{ $microsite->name }}</td>
                    <td>{{ $microsite->slug }}</td>
                    <td>{{ $microsite->domain ?? '-' }}</td>
                    <td>{{ $microsite->is_active ? 'Aktif' : 'Nonaktif' }}</td>
                    <td>{{ $microsite->admins_count }}</td>
                    <td>
                        <a href="{{ route('admin.microsites.edit', $microsite) }}">Ubah</a>
                        <form class="inline" method="POST" action="{{ route('admin.microsites.destroy', $microsite) }}"
                            onsubmit="return confirm('Hapus microsite ini beserta seluruh datanya?')">
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
