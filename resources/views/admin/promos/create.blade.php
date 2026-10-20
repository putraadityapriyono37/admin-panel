@extends('admin.layout')

@section('title', 'Tambah Promo')

@section('content')
    <h1>Tambah Promo</h1>
    <div class="card">
        <form method="POST" action="{{ route('admin.promos.store', $currentMicrosite) }}">
            @csrf
            @include('admin.promos._form')
        </form>
    </div>
@endsection
