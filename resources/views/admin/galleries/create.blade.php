@extends('admin.layout')

@section('title', 'Tambah Foto')

@section('content')
    <div class="card p-6">
        <form method="POST" action="{{ route('admin.galleries.store', $currentMicrosite) }}"
            enctype="multipart/form-data">
            @csrf
            @include('admin.galleries._form')
        </form>
    </div>
@endsection
