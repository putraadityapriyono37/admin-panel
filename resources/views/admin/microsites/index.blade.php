@extends('admin.layout')

@section('title', 'Kelola Microsite')

@section('content')
    <div class="page-head">
        <h1>Microsite</h1>
        <a class="btn btn-primary" href="{{ route('admin.microsites.create') }}">+ Tambah microsite</a>
    </div>

    <div class="table-scroll">
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
                @forelse ($microsites as $microsite)
                    <tr>
                        <td>{{ $microsite->name }}</td>
                        <td><code>{{ $microsite->slug }}</code></td>
                        <td>{{ $microsite->domain ?? '-' }}</td>
                        <td>
                            <span class="badge {{ $microsite->is_active ? 'badge-ok' : 'badge-off' }}">
                                {{ $microsite->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td>{{ $microsite->admins_count }}</td>
                        <td>
                            <div class="actions">
                                <a class="btn btn-secondary btn-sm" href="{{ route('admin.microsites.edit', $microsite) }}">Ubah</a>
                                <form class="inline" method="POST" action="{{ route('admin.microsites.destroy', $microsite) }}"
                                    onsubmit="return confirm('Hapus microsite ini beserta seluruh datanya?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" type="submit">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="empty">Belum ada microsite.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
