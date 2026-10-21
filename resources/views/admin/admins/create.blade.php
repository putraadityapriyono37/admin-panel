@extends('admin.layout')

@section('title', 'Tambah Akun Admin')

@section('content')
    <div class="card p-6">
        <form method="POST" action="{{ route('admin.admins.store') }}">
            @csrf
            @include('admin.admins._form')
        </form>
    </div>
@endsection
