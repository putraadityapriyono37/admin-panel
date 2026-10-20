@extends('admin.layout')

@section('title', 'Ubah Promo')

@section('content')
    <h1>Ubah Promo</h1>
    <div class="card">
        <form method="POST" action="{{ route('admin.promos.update', [$currentMicrosite, $promo]) }}">
            @csrf
            @method('PUT')
            @include('admin.promos._form')
        </form>
    </div>
@endsection
