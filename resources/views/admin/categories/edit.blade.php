@extends('admin.layout')

@section('title', 'Ubah Kategori')

@section('content')
    <div class="card p-6">
        <form method="POST" action="{{ route('admin.categories.update', [$currentMicrosite, $category]) }}">
            @csrf
            @method('PUT')
            @include('admin.categories._form')
        </form>
    </div>
@endsection
