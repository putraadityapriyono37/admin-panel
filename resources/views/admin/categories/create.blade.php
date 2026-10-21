@extends('admin.layout')

@section('title', 'Tambah Kategori')

@section('content')
    <div class="card p-6">
        <form method="POST" action="{{ route('admin.categories.store', $currentMicrosite) }}">
            @csrf
            @include('admin.categories._form')
        </form>
    </div>
@endsection
