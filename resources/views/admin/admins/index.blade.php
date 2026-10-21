@extends('admin.layout')

@section('title', 'Kelola Akun Admin')

@section('content')
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <h2 class="text-title-sm font-semibold text-gray-800 dark:text-white/90">Akun Admin</h2>
        <a class="btn btn-primary px-5 py-3.5 text-sm" href="{{ route('admin.admins.create') }}">+ Tambah akun
            admin</a>
    </div>

    <div class="table-wrap">
        <table class="w-full">
            <thead class="border-b border-gray-200 dark:border-gray-800">
                <tr>
                    <th class="table-head">Nama</th>
                    <th class="table-head">Username</th>
                    <th class="table-head">Role</th>
                    <th class="table-head">Microsite</th>
                    <th class="table-head">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                @forelse ($admins as $admin)
                    <tr>
                        <td class="table-cell">{{ $admin->name }}</td>
                        <td class="table-cell">{{ $admin->username }}</td>
                        <td class="table-cell">
                            <span class="badge {{ $admin->isSuperAdmin() ? 'badge-info' : 'badge-neutral' }}">
                                {{ $admin->isSuperAdmin() ? 'Super admin' : 'Admin' }}
                            </span>
                        </td>
                        <td class="table-cell">
                            {{ $admin->isSuperAdmin() ? 'Semua' : $admin->microsites->pluck('name')->join(', ') }}</td>
                        <td class="table-cell">
                            <div class="flex items-center gap-2">
                                <a class="btn btn-outline px-4 py-3 text-sm"
                                    href="{{ route('admin.admins.edit', $admin) }}">Ubah</a>
                                <form method="POST" action="{{ route('admin.admins.destroy', $admin) }}"
                                    onsubmit="return confirm('Hapus akun ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger px-4 py-3 text-sm" type="submit">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="empty-cell">Belum ada akun admin.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
