@extends('admin.layout')

@section('title', 'Promo')

@section('content')
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <h2 class="text-title-sm font-semibold text-gray-800 dark:text-white/90">Promo</h2>
        <a class="btn btn-primary px-5 py-3.5 text-sm"
            href="{{ route('admin.promos.create', $currentMicrosite) }}">+ Tambah promo</a>
    </div>

    <div class="table-wrap">
        <table class="w-full">
            <thead class="border-b border-gray-200 dark:border-gray-800">
                <tr>
                    <th class="table-head">Judul</th>
                    <th class="table-head">Periode</th>
                    <th class="table-head">Status</th>
                    <th class="table-head">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                @forelse ($promos as $promo)
                    <tr>
                        <td class="table-cell">{{ $promo->title }}</td>
                        <td class="table-cell">
                            {{ $promo->start_date->format('d M Y') }} - {{ $promo->end_date->format('d M Y') }}</td>
                        <td class="table-cell">
                            @if ($now->lt($promo->start_date))
                                <span class="badge badge-info">Akan datang</span>
                            @elseif ($now->lte($promo->end_date))
                                <span class="badge badge-success">Aktif</span>
                            @else
                                <span class="badge badge-neutral">Berakhir</span>
                            @endif
                        </td>
                        <td class="table-cell">
                            <div class="flex items-center gap-2">
                                <a class="btn btn-outline px-4 py-3 text-sm"
                                    href="{{ route('admin.promos.edit', [$currentMicrosite, $promo]) }}">Ubah</a>
                                <form method="POST"
                                    action="{{ route('admin.promos.destroy', [$currentMicrosite, $promo]) }}"
                                    onsubmit="return confirm('Hapus promo ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger px-4 py-3 text-sm" type="submit">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="empty-cell">Belum ada promo. Tambahkan promo untuk periode diskon.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
