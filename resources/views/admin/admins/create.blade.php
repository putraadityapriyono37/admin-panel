@extends('admin.layout')

@section('title', 'Tambah Akun Admin')

@section('content')
    <h1>Tambah Akun Admin</h1>
    <div class="card">
        <form method="POST" action="{{ route('admin.admins.store') }}">
            @csrf
            @include('admin.admins._form')
        </form>
    </div>
@endsection
