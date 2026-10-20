@extends('admin.layout')

@section('title', 'Ubah Microsite')

@section('content')
    <h1>Ubah Microsite</h1>
    <div class="card">
        <form method="POST" action="{{ route('admin.microsites.update', $microsite) }}">
            @csrf
            @method('PUT')
            @include('admin.microsites._form')
        </form>
    </div>
@endsection
