@extends('admin.layout')

@section('title', 'Info Restoran')

@section('content')
    <div class="card p-6">
        <form method="POST" action="{{ route('admin.info.update', $currentMicrosite) }}">
            @csrf
            @method('PATCH')

            <div class="space-y-5">
                <div>
                    <label class="form-label" for="open_hours">Jam buka</label>
                    <input class="input-field" type="text" id="open_hours" name="open_hours"
                        value="{{ old('open_hours', $currentMicrosite->settings['open_hours'] ?? '') }}" maxlength="100"
                        placeholder="08.00 - 22.00">
                </div>

                <div>
                    <label class="form-label" for="address">Alamat</label>
                    <input class="input-field" type="text" id="address" name="address"
                        value="{{ old('address', $currentMicrosite->settings['address'] ?? '') }}" maxlength="255">
                </div>

                <div>
                    <label class="form-label" for="phone">Telepon</label>
                    <input class="input-field" type="text" id="phone" name="phone"
                        value="{{ old('phone', $currentMicrosite->settings['phone'] ?? '') }}" maxlength="30">
                </div>

                <div>
                    <label class="form-label" for="description">Deskripsi</label>
                    <textarea class="textarea-field" id="description" name="description"
                        rows="3">{{ old('description', $currentMicrosite->settings['description'] ?? '') }}</textarea>
                </div>

                <div>
                    <label class="form-label" for="social_media">Media sosial</label>
                    <input class="input-field" type="text" id="social_media" name="social_media"
                        value="{{ old('social_media', $currentMicrosite->settings['social_media'] ?? '') }}"
                        maxlength="100" placeholder="@kafekita">
                </div>

                <div>
                    <button class="btn btn-primary px-5 py-3.5 text-sm" type="submit">Simpan</button>
                </div>
            </div>
        </form>
    </div>
@endsection
