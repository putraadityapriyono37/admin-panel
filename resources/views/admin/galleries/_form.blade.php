<div class="space-y-5">
    <div>
        <label class="form-label" for="image">Foto (jpg, png, webp; maksimal 2 MB)</label>
        <input class="block w-full text-sm text-gray-700 file:mr-4 file:rounded-lg file:border-0 file:bg-gray-100 file:px-4 file:py-3 file:text-sm file:font-medium file:text-gray-700 hover:file:bg-gray-200 dark:text-gray-400 dark:file:bg-white/5 dark:file:text-gray-300"
            type="file" id="image" name="image" accept="image/*" @required(!isset($gallery))>
        @isset($gallery)
            @if ($gallery->image)
                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Foto saat ini:</p>
                <img class="mt-2 max-h-60 rounded-lg border border-gray-200 dark:border-gray-800"
                    src="{{ asset('storage/' . $gallery->image) }}" alt="{{ $gallery->caption }}">
            @endif
        @endisset
    </div>

    <div>
        <label class="form-label" for="caption">Caption</label>
        <input class="input-field" type="text" id="caption" name="caption"
            value="{{ old('caption', $gallery->caption ?? '') }}" maxlength="255">
    </div>

    <div class="flex items-center gap-3">
        <button class="btn btn-primary px-5 py-3.5 text-sm" type="submit">Simpan</button>
        <a class="btn btn-outline px-5 py-3.5 text-sm"
            href="{{ route('admin.galleries.index', $currentMicrosite) }}">Batal</a>
    </div>
</div>
