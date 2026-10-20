@extends('admin.layout')

@section('title', 'Ubah Foto')

@section('content')
    <h1>Ubah Foto</h1>
    <div class="card">
        <form method="POST" action="{{ route('admin.galleries.update', [$currentMicrosite, $gallery]) }}"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('admin.galleries._form')
        </form>
    </div>
@endsection
