@extends('admin.layout')

@section('title', 'Tambah Menu')

@section('content')
    <div class="card p-6">
        <form method="POST" action="{{ route('admin.menu-items.store', $currentMicrosite) }}"
            enctype="multipart/form-data">
            @csrf
            @include('admin.menu-items._form')
        </form>
    </div>
@endsection
