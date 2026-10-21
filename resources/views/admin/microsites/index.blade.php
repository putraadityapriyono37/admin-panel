@extends('admin.layout')

@section('title', 'Kelola Microsite')

@section('content')
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <h2 class="text-title-sm font-semibold text-gray-800 dark:text-white/90">Microsite</h2>
        <a class="btn btn-primary px-5 py-3.5 text-sm" href="{{ route('admin.microsites.create') }}">+ Tambah
            microsite</a>
    </div>

    <div class="table-wrap">
        <table class="w-full">
            <thead class="border-b border-gray-200 dark:border-gray-800">
                <tr>
                    <th class="table-head">Nama</th>
                    <th class="table-head">Slug</th>
                    <th class="table-head">Domain</th>
                    <th class="table-head">Status</th>
                    <th class="table-head">Jumlah admin</th>
                    <th class="table-head">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                @forelse ($microsites as $microsite)
                    <tr>
                        <td class="table-cell">{{ $microsite->name }}</td>
                        <td class="table-cell">
                            <code
                                class="rounded bg-gray-100 px-2 py-0.5 text-xs text-gray-700 dark:bg-white/5 dark:text-gray-300">{{ $microsite->slug }}</code>
                        </td>
                        <td class="table-cell">{{ $microsite->domain ?? '-' }}</td>
                        <td class="table-cell">
                            <span class="badge {{ $microsite->is_active ? 'badge-success' : 'badge-neutral' }}">
                                {{ $microsite->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td class="table-cell">{{ $microsite->admins_count }}</td>
                        <td class="table-cell">
                            <div class="flex items-center gap-2">
                                <a class="btn btn-outline px-4 py-3 text-sm"
                                    href="{{ route('admin.microsites.edit', $microsite) }}">Ubah</a>
                                <form method="POST" action="{{ route('admin.microsites.destroy', $microsite) }}"
                                    onsubmit="return confirm('Hapus microsite ini beserta seluruh datanya?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger px-4 py-3 text-sm" type="submit">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="empty-cell">Belum ada microsite.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
