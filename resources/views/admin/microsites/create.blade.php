@extends('admin.layout')

@section('title', 'Tambah Microsite')

@section('content')
    <h1>Tambah Microsite</h1>
    <div class="card">
        <form method="POST" action="{{ route('admin.microsites.store') }}">
            @csrf
            @include('admin.microsites._form')
        </form>
    </div>
@endsection
