@php($settings = isset($microsite) ? $microsite->settings ?? [] : [])

<div class="field">
    <label>Nama
        <input type="text" name="name" value="{{ old('name', $microsite->name ?? '') }}" required>
    </label>
</div>

<div class="field">
    @isset($microsite)
        <label>Slug (tidak bisa diubah)</label>
        <code>{{ $microsite->slug }}</code>
    @else
        <label>Slug (huruf kecil, angka, dan tanda strip; dipakai sebagai MICROSITE_SLUG)
            <input type="text" name="slug" value="{{ old('slug') }}" required>
        </label>
    @endisset
</div>

<div class="field">
    <label>Domain (opsional)
        <input type="text" name="domain" value="{{ old('domain', $microsite->domain ?? '') }}">
    </label>
</div>

<div class="field">
    <label>Warna utama
        <input type="color" name="color" value="{{ old('color', $settings['color'] ?? '#8B5E3C') }}">
    </label>
</div>

<div class="field">
    <label>Jam buka
        <input type="text" name="open_hours" value="{{ old('open_hours', $settings['open_hours'] ?? '') }}">
    </label>
</div>

<div class="field">
    <label>Alamat
        <input type="text" name="address" value="{{ old('address', $settings['address'] ?? '') }}">
    </label>
</div>

<div class="field">
    <label>Telepon
        <input type="text" name="phone" value="{{ old('phone', $settings['phone'] ?? '') }}">
    </label>
</div>

<div class="field">
    <input type="hidden" name="is_active" value="0">
    <label>
        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $microsite->is_active ?? true))>
        Aktif
    </label>
</div>

<button type="submit">Simpan</button>
<a href="{{ route('admin.microsites.index') }}">Batal</a>
