@extends('admin.layout')

@section('title', 'Menu')

@section('content')
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <h2 class="text-title-sm font-semibold text-gray-800 dark:text-white/90">Menu</h2>
        <a class="btn btn-primary px-5 py-3.5 text-sm"
            href="{{ route('admin.menu-items.create', $currentMicrosite) }}">+ Tambah menu</a>
    </div>

    <div class="table-wrap">
        <table class="w-full">
            <thead class="border-b border-gray-200 dark:border-gray-800">
                <tr>
                    <th class="table-head">Foto</th>
                    <th class="table-head">Nama</th>
                    <th class="table-head">Kategori</th>
                    <th class="table-head">Harga</th>
                    <th class="table-head">Status</th>
                    <th class="table-head">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                @forelse ($items as $item)
                    <tr>
                        <td class="table-cell">
                            @if ($item->image)
                                <img class="h-12 w-16 rounded-lg border border-gray-200 object-cover dark:border-gray-800"
                                    src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}">
                            @else
                                <span class="text-gray-400 dark:text-gray-500">Tanpa foto</span>
                            @endif
                        </td>
                        <td class="table-cell">{{ $item->name }}</td>
                        <td class="table-cell">{{ $item->category->name }}</td>
                        <td class="table-cell">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                        <td class="table-cell">
                            <span class="badge {{ $item->is_available ? 'badge-success' : 'badge-error' }}">
                                {{ $item->is_available ? 'Tersedia' : 'Habis' }}
                            </span>
                        </td>
                        <td class="table-cell">
                            <div class="flex items-center gap-2">
                                <a class="btn btn-outline px-4 py-3 text-sm"
                                    href="{{ route('admin.menu-items.edit', [$currentMicrosite, $item]) }}">Ubah</a>

                                <form method="POST"
                                    action="{{ route('admin.menu-items.toggle', [$currentMicrosite, $item]) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button class="btn btn-outline px-4 py-3 text-sm"
                                        type="submit">{{ $item->is_available ? 'Tandai habis' : 'Tandai tersedia' }}</button>
                                </form>

                                <form method="POST"
                                    action="{{ route('admin.menu-items.destroy', [$currentMicrosite, $item]) }}"
                                    onsubmit="return confirm('Hapus menu ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger px-4 py-3 text-sm" type="submit">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="empty-cell">Belum ada menu. Tambahkan menu setelah kategori tersedia.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
