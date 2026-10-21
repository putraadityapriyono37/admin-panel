@extends('admin.layout')

@section('title', 'Ubah Foto')

@section('content')
    <div class="card p-6">
        <form method="POST" action="{{ route('admin.galleries.update', [$currentMicrosite, $gallery]) }}"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('admin.galleries._form')
        </form>
    </div>
@endsection
