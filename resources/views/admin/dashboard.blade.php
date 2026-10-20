@extends('admin.layout')

@section('title', 'Dashboard ' . $microsite->name)

@section('content')
    <h1>Dashboard {{ $microsite->name }}</h1>
    <p>Halo, {{ auth('admin')->user()->name }}</p>

    <div class="card">
        <h2>Kelola data</h2>
        <p class="hint">Perubahan data di sini langsung tampil di microsite {{ $microsite->name }}.</p>
        <div class="form-actions">
            <a class="btn btn-secondary" href="{{ route('admin.categories.index', $microsite) }}">Kelola kategori menu</a>
            <a class="btn btn-secondary" href="{{ route('admin.menu-items.index', $microsite) }}">Kelola menu</a>
            <a class="btn btn-secondary" href="{{ route('admin.orders.index', $microsite) }}">Kelola pesanan</a>
        </div>
    </div>
@endsection
