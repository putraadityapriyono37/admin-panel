@extends('admin.layout')

@section('title', 'Galeri')

@section('content')
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <h2 class="text-title-sm font-semibold text-gray-800 dark:text-white/90">Galeri</h2>
        <a class="btn btn-primary px-5 py-3.5 text-sm"
            href="{{ route('admin.galleries.create', $currentMicrosite) }}">+ Tambah foto</a>
    </div>

    <div class="table-wrap">
        <table class="w-full">
            <thead class="border-b border-gray-200 dark:border-gray-800">
                <tr>
                    <th class="table-head">Foto</th>
                    <th class="table-head">Caption</th>
                    <th class="table-head">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                @forelse ($galleries as $gallery)
                    <tr>
                        <td class="table-cell">
                            <img class="h-12 w-16 rounded-lg border border-gray-200 object-cover dark:border-gray-800"
                                src="{{ asset('storage/' . $gallery->image) }}" alt="{{ $gallery->caption }}">
                        </td>
                        <td class="table-cell">{{ $gallery->caption }}</td>
                        <td class="table-cell">
                            <div class="flex items-center gap-2">
                                <a class="btn btn-outline px-4 py-3 text-sm"
                                    href="{{ route('admin.galleries.edit', [$currentMicrosite, $gallery]) }}">Ubah</a>
                                <form method="POST"
                                    action="{{ route('admin.galleries.destroy', [$currentMicrosite, $gallery]) }}"
                                    onsubmit="return confirm('Hapus foto ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger px-4 py-3 text-sm" type="submit">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="empty-cell">Belum ada foto. Tambahkan foto untuk mengisi galeri.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
