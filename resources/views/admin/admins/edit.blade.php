@extends('admin.layout')

@section('title', 'Ubah Akun Admin')

@section('content')
    <div class="card p-6">
        <form method="POST" action="{{ route('admin.admins.update', $admin) }}">
            @csrf
            @method('PUT')
            @include('admin.admins._form')
        </form>
    </div>
@endsection
