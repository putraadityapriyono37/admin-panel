<div class="space-y-5">
    @if ($categories->isEmpty())
        <div class="alert-error">
            Belum ada kategori. <a class="underline"
                href="{{ route('admin.categories.create', $currentMicrosite) }}">Buat kategori</a> terlebih dahulu.
        </div>
    @endif

    <div>
        <label class="form-label" for="name">Nama menu</label>
        <input class="input-field" type="text" id="name" name="name"
            value="{{ old('name', $item->name ?? '') }}" required>
    </div>

    <div>
        <label class="form-label" for="category_id">Kategori</label>
        <select class="input-field" id="category_id" name="category_id" required>
            <option value="">-- pilih kategori --</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected(old('category_id', $item->category_id ?? '') == $category->id)>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="form-label" for="description">Deskripsi</label>
        <textarea class="textarea-field" id="description" name="description" rows="3">{{ old('description', $item->description ?? '') }}</textarea>
    </div>

    <div>
        <label class="form-label" for="price">Harga (Rp)</label>
        <input class="input-field" type="number" id="price" name="price" min="0"
            value="{{ old('price', $item->price ?? '') }}" required>
    </div>

    <div>
        <label class="form-label" for="image">Foto (jpg, png, webp; maksimal 2 MB)</label>
        <input class="block w-full text-sm text-gray-700 file:mr-4 file:rounded-lg file:border-0 file:bg-gray-100 file:px-4 file:py-3 file:text-sm file:font-medium file:text-gray-700 hover:file:bg-gray-200 dark:text-gray-400 dark:file:bg-white/5 dark:file:text-gray-300"
            type="file" id="image" name="image" accept="image/*">
        @isset($item)
            @if ($item->image)
                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Foto saat ini:</p>
                <img class="mt-2 max-h-60 rounded-lg border border-gray-200 dark:border-gray-800"
                    src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}">
            @endif
        @endisset
    </div>

    <div>
        <input type="hidden" name="is_available" value="0">
        <label class="inline-flex items-center gap-2 text-sm text-gray-700 dark:text-gray-400">
            <input class="h-4 w-4 rounded border-gray-300 text-brand-500" type="checkbox" name="is_available"
                value="1" @checked(old('is_available', $item->is_available ?? true))>
            Tersedia
        </label>
    </div>

    <div class="flex items-center gap-3">
        <button class="btn btn-primary px-5 py-3.5 text-sm" type="submit">Simpan</button>
        <a class="btn btn-outline px-5 py-3.5 text-sm"
            href="{{ route('admin.menu-items.index', $currentMicrosite) }}">Batal</a>
    </div>
</div>
