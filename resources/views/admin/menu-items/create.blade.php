@extends('admin.layout')

@section('title', 'Tambah Menu')

@section('content')
    <h1>Tambah Menu</h1>
    <div class="card">
        <form method="POST" action="{{ route('admin.menu-items.store', $currentMicrosite) }}" enctype="multipart/form-data">
            @csrf
            @include('admin.menu-items._form')
        </form>
    </div>
@endsection
