@extends('admin.layout')

@section('title', 'Kategori Menu')

@section('content')
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <h2 class="text-title-sm font-semibold text-gray-800 dark:text-white/90">Kategori Menu</h2>
        <a class="btn btn-primary px-5 py-3.5 text-sm"
            href="{{ route('admin.categories.create', $currentMicrosite) }}">+ Tambah kategori</a>
    </div>

    <div class="table-wrap">
        <table class="w-full">
            <thead class="border-b border-gray-200 dark:border-gray-800">
                <tr>
                    <th class="table-head">Urutan</th>
                    <th class="table-head">Nama</th>
                    <th class="table-head">Jumlah menu</th>
                    <th class="table-head">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                @forelse ($categories as $category)
                    <tr>
                        <td class="table-cell">{{ $category->sort_order }}</td>
                        <td class="table-cell">{{ $category->name }}</td>
                        <td class="table-cell">{{ $category->menu_items_count }}</td>
                        <td class="table-cell">
                            <div class="flex items-center gap-2">
                                <a class="btn btn-outline px-4 py-3 text-sm"
                                    href="{{ route('admin.categories.edit', [$currentMicrosite, $category]) }}">Ubah</a>
                                <form method="POST"
                                    action="{{ route('admin.categories.destroy', [$currentMicrosite, $category]) }}"
                                    onsubmit="return confirm('Hapus kategori ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger px-4 py-3 text-sm" type="submit">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="empty-cell">Belum ada kategori. Tambahkan kategori sebelum menambah menu.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
