@extends('admin.layout')

@section('title', 'Dashboard Super Admin')

@section('content')
    <h1>Dashboard Super Admin</h1>
    <p>Halo, {{ auth('admin')->user()->name }}</p>

    <div class="table-scroll">
        <table>
            <thead>
                <tr>
                    <th>Microsite</th>
                    <th>Status</th>
                    <th>Lihat dashboard</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($microsites as $microsite)
                    <tr>
                        <td>{{ $microsite->name }}</td>
                        <td>
                            <span class="badge {{ $microsite->is_active ? 'badge-ok' : 'badge-off' }}">
                                {{ $microsite->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td><a href="{{ route('admin.dashboard', $microsite) }}">Buka</a></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="empty">Belum ada microsite. Tambahkan lewat menu Microsite.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
