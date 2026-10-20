@extends('admin.layout')

@section('title', 'Tambah Microsite')

@section('content')
    <h1>Tambah Microsite</h1>
    <form method="POST" action="{{ route('admin.microsites.store') }}">
        @csrf
        @include('admin.microsites._form')
    </form>
@endsection
