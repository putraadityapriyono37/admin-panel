<div class="space-y-5">
    <div>
        <label class="form-label" for="title">Judul promo</label>
        <input class="input-field" type="text" id="title" name="title"
            value="{{ old('title', $promo->title ?? '') }}" maxlength="150" required>
    </div>

    <div>
        <label class="form-label" for="description">Deskripsi</label>
        <textarea class="textarea-field" id="description" name="description"
            rows="3">{{ old('description', $promo->description ?? '') }}</textarea>
    </div>

    <div>
        <label class="form-label" for="start_date">Tanggal mulai</label>
        <input class="input-field" type="date" id="start_date" name="start_date"
            value="{{ old('start_date', ($promo->start_date ?? null)?->format('Y-m-d')) }}" required>
    </div>

    <div>
        <label class="form-label" for="end_date">Tanggal berakhir</label>
        <input class="input-field" type="date" id="end_date" name="end_date"
            value="{{ old('end_date', ($promo->end_date ?? null)?->format('Y-m-d')) }}" required>
    </div>

    <div class="flex items-center gap-3">
        <button class="btn btn-primary px-5 py-3.5 text-sm" type="submit">Simpan</button>
        <a class="btn btn-outline px-5 py-3.5 text-sm"
            href="{{ route('admin.promos.index', $currentMicrosite) }}">Batal</a>
    </div>
</div>
