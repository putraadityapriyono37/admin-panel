@extends('admin.layout')

@section('title', 'Ubah Kategori')

@section('content')
    <h1>Ubah Kategori</h1>
    <form method="POST" action="{{ route('admin.categories.update', [$currentMicrosite, $category]) }}">
        @csrf
        @method('PUT')
        @include('admin.categories._form')
    </form>
@endsection
