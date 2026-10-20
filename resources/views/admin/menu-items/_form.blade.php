@if ($categories->isEmpty())
    <p class="err">
        Belum ada kategori. <a href="{{ route('admin.categories.create', $currentMicrosite) }}">Buat kategori</a>
        terlebih dahulu.
    </p>
@endif

<div class="field">
    <label>Nama menu
        <input type="text" name="name" value="{{ old('name', $item->name ?? '') }}" required>
    </label>
</div>

<div class="field">
    <label>Kategori
        <select name="category_id" required>
            <option value="">-- pilih kategori --</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected(old('category_id', $item->category_id ?? '') == $category->id)>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </label>
</div>

<div class="field">
    <label>Deskripsi
        <textarea name="description" rows="3" cols="40">{{ old('description', $item->description ?? '') }}</textarea>
    </label>
</div>

<div class="field">
    <label>Harga (Rp)
        <input type="number" name="price" min="0" value="{{ old('price', $item->price ?? '') }}" required>
    </label>
</div>

<div class="field">
    <label>Foto (jpg, png, webp; maksimal 2 MB)
        <input type="file" name="image" accept="image/*">
    </label>
    @if (isset($item) && $item->image)
        <p>Foto saat ini: <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" width="80"></p>
    @endif
</div>

<div class="field">
    <input type="hidden" name="is_available" value="0">
    <label>
        <input type="checkbox" name="is_available" value="1" @checked(old('is_available', $item->is_available ?? true))>
        Tersedia
    </label>
</div>

<button type="submit">Simpan</button>
<a href="{{ route('admin.menu-items.index', $currentMicrosite) }}">Batal</a>
