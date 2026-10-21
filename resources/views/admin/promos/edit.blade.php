@extends('admin.layout')

@section('title', 'Ubah Promo')

@section('content')
    <div class="card p-6">
        <form method="POST" action="{{ route('admin.promos.update', [$currentMicrosite, $promo]) }}">
            @csrf
            @method('PUT')
            @include('admin.promos._form')
        </form>
    </div>
@endsection
