@extends('admin.layout')

@section('title', 'Ubah Microsite')

@section('content')
    <div class="card p-6">
        <form method="POST" action="{{ route('admin.microsites.update', $microsite) }}">
            @csrf
            @method('PUT')
            @include('admin.microsites._form')
        </form>
    </div>
@endsection
