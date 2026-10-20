<div class="field">
    <label>Foto (jpg, png, webp; maksimal 2 MB)
        <input type="file" name="image" accept="image/*" @required(!isset($gallery))>
    </label>
    @isset($gallery)
        @if ($gallery->image)
            <p class="hint">Foto saat ini:</p>
            <img class="thumb thumb-lg" src="{{ asset('storage/' . $gallery->image) }}" alt="{{ $gallery->caption }}">
        @endif
    @endisset
</div>

<div class="field">
    <label>Caption
        <input type="text" name="caption" value="{{ old('caption', $gallery->caption ?? '') }}" maxlength="255">
    </label>
</div>

<div class="form-actions">
    <button class="btn btn-primary" type="submit">Simpan</button>
    <a class="btn btn-secondary" href="{{ route('admin.galleries.index', $currentMicrosite) }}">Batal</a>
</div>
