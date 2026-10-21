@php($selected = old('microsite_ids', isset($admin) ? $admin->microsites->pluck('id')->all() : []))

<div class="space-y-5">
    <div>
        <label class="form-label" for="name">Nama</label>
        <input class="input-field" type="text" id="name" name="name"
            value="{{ old('name', $admin->name ?? '') }}" required>
    </div>

    <div>
        <label class="form-label" for="username">Username</label>
        <input class="input-field" type="text" id="username" name="username"
            value="{{ old('username', $admin->username ?? '') }}" required>
    </div>

    <div>
        <label class="form-label" for="password">Password @isset($admin)
                (kosongkan jika tidak diganti)
            @endisset</label>
        <input class="input-field" type="password" id="password" name="password" @empty($admin) required @endempty>
    </div>

    <div>
        <label class="form-label" for="password_confirmation">Ulangi password</label>
        <input class="input-field" type="password" id="password_confirmation" name="password_confirmation">
    </div>

    <div>
        <label class="form-label" for="role">Role</label>
        <select class="input-field" id="role" name="role" @disabled($isSelf ?? false)>
            <option value="admin" @selected(old('role', $admin->role ?? 'admin') === 'admin')>Admin biasa</option>
            <option value="super_admin" @selected(old('role', $admin->role ?? 'admin') === 'super_admin')>Super
                admin</option>
        </select>
        @if ($isSelf ?? false)
            <p class="mt-1.5 text-xs text-gray-500 dark:text-gray-400">Role akunmu sendiri tidak bisa diubah.</p>
        @endif
    </div>

    <div>
        <span class="form-label">Microsite yang dipegang</span>
        <p class="mb-2 text-xs text-gray-500 dark:text-gray-400">(wajib untuk admin biasa, diabaikan untuk super
            admin)</p>
        @foreach ($microsites as $microsite)
            <label class="inline-flex items-center gap-2 text-sm text-gray-700 dark:text-gray-400">
                <input class="h-4 w-4 rounded border-gray-300 text-brand-500" type="checkbox" name="microsite_ids[]"
                    value="{{ $microsite->id }}" @checked(in_array($microsite->id, $selected))>
                {{ $microsite->name }}
            </label>
        @endforeach
    </div>

    <div class="flex items-center gap-3">
        <button class="btn btn-primary px-5 py-3.5 text-sm" type="submit">Simpan</button>
        <a class="btn btn-outline px-5 py-3.5 text-sm" href="{{ route('admin.admins.index') }}">Batal</a>
    </div>
</div>
