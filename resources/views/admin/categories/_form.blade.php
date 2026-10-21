<div class="space-y-5">
    <div>
        <label class="form-label" for="name">Nama</label>
        <input class="input-field" type="text" id="name" name="name"
            value="{{ old('name', $category->name ?? '') }}" required>
    </div>

    <div>
        <label class="form-label" for="sort_order">Urutan tampil</label>
        <input class="input-field" type="number" id="sort_order" name="sort_order" min="0"
            value="{{ old('sort_order', $category->sort_order ?? 0) }}">
    </div>

    <div class="flex items-center gap-3">
        <button class="btn btn-primary px-5 py-3.5 text-sm" type="submit">Simpan</button>
        <a class="btn btn-outline px-5 py-3.5 text-sm"
            href="{{ route('admin.categories.index', $currentMicrosite) }}">Batal</a>
    </div>
</div>
