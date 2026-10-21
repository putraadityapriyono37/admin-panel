@extends('admin.layout')

@section('title', 'Ubah Menu')

@section('content')
    <div class="card p-6">
        <form method="POST" action="{{ route('admin.menu-items.update', [$currentMicrosite, $item]) }}"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('admin.menu-items._form')
        </form>
    </div>
@endsection
