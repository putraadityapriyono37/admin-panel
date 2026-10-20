@extends('admin.layout')

@section('title', 'Promo')

@section('content')
    <div class="page-head">
        <h1>Promo</h1>
        <a class="btn btn-primary" href="{{ route('admin.promos.create', $currentMicrosite) }}">+ Tambah promo</a>
    </div>

    <div class="table-scroll">
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
                                <span class="badge badge-info">Akan datang</span>
                            @elseif ($now->lte($promo->end_date))
                                <span class="badge badge-ok">Aktif</span>
                            @else
                                <span class="badge badge-off">Berakhir</span>
                            @endif
                        </td>
                        <td>
                            <div class="actions">
                                <a class="btn btn-secondary btn-sm" href="{{ route('admin.promos.edit', [$currentMicrosite, $promo]) }}">Ubah</a>
                                <form class="inline" method="POST"
                                    action="{{ route('admin.promos.destroy', [$currentMicrosite, $promo]) }}"
                                    onsubmit="return confirm('Hapus promo ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" type="submit">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="empty">Belum ada promo. Tambahkan promo untuk periode diskon.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
