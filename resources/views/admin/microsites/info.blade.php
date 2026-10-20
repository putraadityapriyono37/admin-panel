@extends('admin.layout')

@section('title', 'Info Restoran')

@section('content')
    <h1>Info Restoran</h1>
    <form method="POST" action="{{ route('admin.info.update', $currentMicrosite) }}">
        @csrf
        @method('PATCH')

        <div class="field">
            <label>Jam buka
                <input type="text" name="open_hours" value="{{ old('open_hours', $currentMicrosite->settings['open_hours'] ?? '') }}"
                    maxlength="100" placeholder="08.00 - 22.00">
            </label>
        </div>

        <div class="field">
            <label>Alamat
                <input type="text" name="address" value="{{ old('address', $currentMicrosite->settings['address'] ?? '') }}"
                    maxlength="255">
            </label>
        </div>

        <div class="field">
            <label>Telepon
                <input type="text" name="phone" value="{{ old('phone', $currentMicrosite->settings['phone'] ?? '') }}"
                    maxlength="30">
            </label>
        </div>

        <div class="field">
            <label>Deskripsi
                <textarea name="description" rows="3"
                    cols="40">{{ old('description', $currentMicrosite->settings['description'] ?? '') }}</textarea>
            </label>
        </div>

        <div class="field">
            <label>Media sosial
                <input type="text" name="social_media"
                    value="{{ old('social_media', $currentMicrosite->settings['social_media'] ?? '') }}" maxlength="100"
                    placeholder="@kafekita">
            </label>
        </div>

        <button type="submit">Simpan</button>
    </form>
@endsection
