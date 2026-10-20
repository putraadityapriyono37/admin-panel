<div class="field">
    <label>Judul promo
        <input type="text" name="title" value="{{ old('title', $promo->title ?? '') }}" maxlength="150" required>
    </label>
</div>

<div class="field">
    <label>Deskripsi
        <textarea name="description" rows="3" cols="40">{{ old('description', $promo->description ?? '') }}</textarea>
    </label>
</div>

<div class="field">
    <label>Tanggal mulai
        <input type="date" name="start_date" value="{{ old('start_date', ($promo->start_date ?? null)?->format('Y-m-d')) }}"
            required>
    </label>
</div>

<div class="field">
    <label>Tanggal berakhir
        <input type="date" name="end_date" value="{{ old('end_date', ($promo->end_date ?? null)?->format('Y-m-d')) }}"
            required>
    </label>
</div>

<button type="submit">Simpan</button>
<a href="{{ route('admin.promos.index', $currentMicrosite) }}">Batal</a>
