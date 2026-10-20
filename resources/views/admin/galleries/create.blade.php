@extends('admin.layout')

@section('title', 'Tambah Foto')

@section('content')
    <h1>Tambah Foto</h1>
    <form method="POST" action="{{ route('admin.galleries.store', $currentMicrosite) }}" enctype="multipart/form-data">
        @csrf
        @include('admin.galleries._form')
    </form>
@endsection
