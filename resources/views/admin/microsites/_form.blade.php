@php($settings = isset($microsite) ? $microsite->settings ?? [] : [])

<div class="space-y-5">
    <div>
        <label class="form-label" for="name">Nama</label>
        <input class="input-field" type="text" id="name" name="name"
            value="{{ old('name', $microsite->name ?? '') }}" required>
    </div>

    <div>
        @isset($microsite)
            <label class="form-label">Slug (tidak bisa diubah)</label>
            <code
                class="inline-block rounded-lg bg-gray-100 px-3 py-1.5 text-sm text-gray-700 dark:bg-white/5 dark:text-gray-300">{{ $microsite->slug }}</code>
        @else
            <label class="form-label" for="slug">Slug (huruf kecil, angka, dan tanda strip; dipakai sebagai
                MICROSITE_SLUG)</label>
            <input class="input-field" type="text" id="slug" name="slug" value="{{ old('slug') }}" required>
        @endisset
    </div>

    <div>
        <label class="form-label" for="domain">Domain (opsional)</label>
        <input class="input-field" type="text" id="domain" name="domain"
            value="{{ old('domain', $microsite->domain ?? '') }}">
    </div>

    <div>
        <label class="form-label" for="color">Warna utama</label>
        <input class="h-11 w-16 rounded-lg border border-gray-300 bg-transparent p-1 dark:border-gray-700 dark:bg-gray-900"
            type="color" id="color" name="color" value="{{ old('color', $settings['color'] ?? '#8B5E3C') }}">
    </div>

    <div>
        <label class="form-label" for="open_hours">Jam buka</label>
        <input class="input-field" type="text" id="open_hours" name="open_hours"
            value="{{ old('open_hours', $settings['open_hours'] ?? '') }}">
    </div>

    <div>
        <label class="form-label" for="address">Alamat</label>
        <input class="input-field" type="text" id="address" name="address"
            value="{{ old('address', $settings['address'] ?? '') }}">
    </div>

    <div>
        <label class="form-label" for="phone">Telepon</label>
        <input class="input-field" type="text" id="phone" name="phone"
            value="{{ old('phone', $settings['phone'] ?? '') }}">
    </div>

    <div>
        <label class="form-label" for="description">Deskripsi</label>
        <textarea class="textarea-field" id="description" name="description"
            rows="3">{{ old('description', $settings['description'] ?? '') }}</textarea>
    </div>

    <div>
        <label class="form-label" for="social_media">Media sosial</label>
        <input class="input-field" type="text" id="social_media" name="social_media"
            value="{{ old('social_media', $settings['social_media'] ?? '') }}" maxlength="100" placeholder="@kafekita">
    </div>

    <div>
        <input type="hidden" name="is_active" value="0">
        <label class="inline-flex items-center gap-2 text-sm text-gray-700 dark:text-gray-400">
            <input class="h-4 w-4 rounded border-gray-300 text-brand-500" type="checkbox" name="is_active" value="1"
                @checked(old('is_active', $microsite->is_active ?? true))>
            Aktif
        </label>
    </div>

    <div class="flex items-center gap-3">
        <button class="btn btn-primary px-5 py-3.5 text-sm" type="submit">Simpan</button>
        <a class="btn btn-outline px-5 py-3.5 text-sm" href="{{ route('admin.microsites.index') }}">Batal</a>
    </div>
</div>
