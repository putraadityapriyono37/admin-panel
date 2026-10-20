@extends('admin.layout')

@section('title', 'Dashboard ' . $microsite->name)

@section('content')
    <h1>Dashboard {{ $microsite->name }}</h1>
    <p>Halo, {{ auth('admin')->user()->name }}</p>
    <ul>
        <li><a href="{{ route('admin.categories.index', $microsite) }}">Kelola kategori menu</a></li>
        <li><a href="{{ route('admin.menu-items.index', $microsite) }}">Kelola menu</a></li>
    </ul>
@endsection
