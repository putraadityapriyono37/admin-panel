@extends('admin.layout')

@section('title', 'Ubah Microsite')

@section('content')
    <h1>Ubah Microsite</h1>
    <form method="POST" action="{{ route('admin.microsites.update', $microsite) }}">
        @csrf
        @method('PUT')
        @include('admin.microsites._form')
    </form>
@endsection
