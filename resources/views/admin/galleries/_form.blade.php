<div class="field">
    <label>Foto (jpg, png, webp; maksimal 2 MB)
        <input type="file" name="image" accept="image/*" @required(!isset($gallery))>
    </label>
    @isset($gallery)
        @if ($gallery->image)
            <p>Foto saat ini: <img src="{{ asset('storage/' . $gallery->image) }}" alt="{{ $gallery->caption }}" width="120"></p>
        @endif
    @endisset
</div>

<div class="field">
    <label>Caption
        <input type="text" name="caption" value="{{ old('caption', $gallery->caption ?? '') }}" maxlength="255">
    </label>
</div>

<button type="submit">Simpan</button>
<a href="{{ route('admin.galleries.index', $currentMicrosite) }}">Batal</a>
