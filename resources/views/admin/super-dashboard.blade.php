@extends('admin.layout')

@section('title', 'Dashboard Super Admin')

@section('content')
    <h1>Dashboard Super Admin</h1>
    <p>Halo, {{ auth('admin')->user()->name }}</p>

    <table>
        <thead>
            <tr>
                <th>Microsite</th>
                <th>Status</th>
                <th>Lihat dashboard</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($microsites as $microsite)
                <tr>
                    <td>{{ $microsite->name }}</td>
                    <td>{{ $microsite->is_active ? 'Aktif' : 'Nonaktif' }}</td>
                    <td><a href="{{ route('admin.dashboard', $microsite) }}">Buka</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
