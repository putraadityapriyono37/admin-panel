@extends('admin.layout')

@section('title', 'Ubah Menu')

@section('content')
    <h1>Ubah Menu</h1>
    <div class="card">
        <form method="POST" action="{{ route('admin.menu-items.update', [$currentMicrosite, $item]) }}"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('admin.menu-items._form')
        </form>
    </div>
@endsection
