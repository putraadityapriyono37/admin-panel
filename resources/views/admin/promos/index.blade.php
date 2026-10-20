@extends('admin.layout')

@section('title', 'Promo')

@section('content')
    <h1>Promo</h1>
    <p><a href="{{ route('admin.promos.create', $currentMicrosite) }}">+ Tambah promo</a></p>

    <table>
        <thead>
            <tr>
                <th>Judul</th>
                <th>Periode</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($promos as $promo)
                <tr>
                    <td>{{ $promo->title }}</td>
                    <td>{{ $promo->start_date->format('d M Y') }} - {{ $promo->end_date->format('d M Y') }}</td>
                    <td>
                        @if ($now->lt($promo->start_date))
                            Akan datang
                        @elseif ($now->lte($promo->end_date))
                            Aktif
                        @else
                            Berakhir
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.promos.edit', [$currentMicrosite, $promo]) }}">Ubah</a>
                        <form class="inline" method="POST"
                            action="{{ route('admin.promos.destroy', [$currentMicrosite, $promo]) }}"
                            onsubmit="return confirm('Hapus promo ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">Belum ada promo.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
