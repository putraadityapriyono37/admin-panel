@extends('admin.layout')

@section('title', 'Tambah Promo')

@section('content')
    <div class="card p-6">
        <form method="POST" action="{{ route('admin.promos.store', $currentMicrosite) }}">
            @csrf
            @include('admin.promos._form')
        </form>
    </div>
@endsection
