@extends('admin.layout')

@section('title', 'Tambah Kategori')

@section('content')
    <h1>Tambah Kategori</h1>
    <div class="card">
        <form method="POST" action="{{ route('admin.categories.store', $currentMicrosite) }}">
            @csrf
            @include('admin.categories._form')
        </form>
    </div>
@endsection
