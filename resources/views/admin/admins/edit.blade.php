@extends('admin.layout')

@section('title', 'Ubah Akun Admin')

@section('content')
    <h1>Ubah Akun Admin</h1>
    <form method="POST" action="{{ route('admin.admins.update', $admin) }}">
        @csrf
        @method('PUT')
        @include('admin.admins._form')
    </form>
@endsection
