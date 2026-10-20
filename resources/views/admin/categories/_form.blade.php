<div class="field">
    <label>Nama
        <input type="text" name="name" value="{{ old('name', $category->name ?? '') }}" required>
    </label>
</div>

<div class="field">
    <label>Urutan tampil
        <input type="number" name="sort_order" min="0" value="{{ old('sort_order', $category->sort_order ?? 0) }}">
    </label>
</div>

<button type="submit">Simpan</button>
<a href="{{ route('admin.categories.index', $currentMicrosite) }}">Batal</a>
