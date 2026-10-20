@php($selected = old('microsite_ids', isset($admin) ? $admin->microsites->pluck('id')->all() : []))

<div class="field">
    <label>Nama
        <input type="text" name="name" value="{{ old('name', $admin->name ?? '') }}" required>
    </label>
</div>

<div class="field">
    <label>Username
        <input type="text" name="username" value="{{ old('username', $admin->username ?? '') }}" required>
    </label>
</div>

<div class="field">
    <label>Password @isset($admin)
            (kosongkan jika tidak diganti)
        @endisset
        <input type="password" name="password" @empty($admin) required @endempty>
    </label>
</div>

<div class="field">
    <label>Ulangi password
        <input type="password" name="password_confirmation">
    </label>
</div>

<div class="field">
    <label>Role
        <select name="role" @disabled($isSelf ?? false)>
            <option value="admin" @selected(old('role', $admin->role ?? 'admin') === 'admin')>Admin biasa</option>
            <option value="super_admin" @selected(old('role', $admin->role ?? 'admin') === 'super_admin')>Super admin</option>
        </select>
    </label>
    @if ($isSelf ?? false)
        <small>Role akunmu sendiri tidak bisa diubah.</small>
    @endif
</div>

<div class="field">
    <strong>Microsite yang dipegang</strong> (wajib untuk admin biasa, diabaikan untuk super admin)
    @foreach ($microsites as $microsite)
        <label>
            <input type="checkbox" name="microsite_ids[]" value="{{ $microsite->id }}" @checked(in_array($microsite->id, $selected))>
            {{ $microsite->name }}
        </label>
    @endforeach
</div>

<button type="submit">Simpan</button>
<a href="{{ route('admin.admins.index') }}">Batal</a>
