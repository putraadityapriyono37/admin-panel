@extends('admin.layout')

@section('title', 'Dashboard ' . $microsite->name)

@section('content')
    <div class="card p-6">
        <h2 class="text-base font-medium text-gray-800 dark:text-white/90">Halo, {{ auth('admin')->user()->name }}</h2>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            Perubahan data di sini langsung tampil di microsite {{ $microsite->name }}.
        </p>
        <div class="mt-5 flex flex-wrap items-center gap-3">
            <a class="btn btn-primary px-5 py-3.5 text-sm"
                href="{{ route('admin.categories.index', $microsite) }}">Kelola kategori menu</a>
            <a class="btn btn-outline px-5 py-3.5 text-sm"
                href="{{ route('admin.menu-items.index', $microsite) }}">Kelola menu</a>
            <a class="btn btn-outline px-5 py-3.5 text-sm"
                href="{{ route('admin.orders.index', $microsite) }}">Kelola pesanan</a>
        </div>
    </div>
@endsection
