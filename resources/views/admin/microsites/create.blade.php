@extends('admin.layout')

@section('title', 'Tambah Microsite')

@section('content')
    <div class="card p-6">
        <form method="POST" action="{{ route('admin.microsites.store') }}">
            @csrf
            @include('admin.microsites._form')
        </form>
    </div>
@endsection
