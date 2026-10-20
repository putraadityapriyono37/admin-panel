<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Microsite;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AdminAccountController extends Controller
{
    public function index()
    {
        $admins = Admin::with('microsites')->orderBy('role')->orderBy('name')->get();

        return view('admin.admins.index', compact('admins'));
    }

    public function create()
    {
        return view('admin.admins.create', [
            'microsites' => Microsite::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'username' => ['required', 'alpha_dash', 'max:50', 'unique:admins,username'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', Rule::in(['super_admin', 'admin'])],
            'microsite_ids' => ['required_if:role,admin', 'array'],
            'microsite_ids.*' => ['exists:microsites,id'],
        ]);

        $admin = Admin::create(Arr::only($data, ['name', 'username', 'password', 'role']));
        $this->syncMicrosites($admin, $data);

        return redirect()->route('admin.admins.index')
            ->with('status', 'Akun admin berhasil dibuat.');
    }

    public function edit(Admin $admin)
    {
        return view('admin.admins.edit', [
            'admin' => $admin,
            'microsites' => Microsite::orderBy('name')->get(),
            'isSelf' => $admin->is(Auth::guard('admin')->user()),
        ]);
    }

    public function update(Request $request, Admin $admin)
    {
        if ($admin->is(Auth::guard('admin')->user())) {
            $request->merge(['role' => $admin->role]);
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'username' => ['required', 'alpha_dash', 'max:50', Rule::unique('admins', 'username')->ignore($admin->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'role' => ['required', Rule::in(['super_admin', 'admin'])],
            'microsite_ids' => ['required_if:role,admin', 'array'],
            'microsite_ids.*' => ['exists:microsites,id'],
        ]);

        $admin->fill(Arr::only($data, ['name', 'username', 'role']));

        if (filled($data['password'] ?? null)) {
            $admin->password = $data['password'];
        }

        $admin->save();
        $this->syncMicrosites($admin, $data);

        return redirect()->route('admin.admins.index')
            ->with('status', 'Akun admin berhasil diperbarui.');
    }

    public function destroy(Admin $admin)
    {
        if ($admin->is(Auth::guard('admin')->user())) {
            return back()->withErrors(['admin' => 'Kamu tidak bisa menghapus akunmu sendiri.']);
        }

        $admin->delete();

        return redirect()->route('admin.admins.index')
            ->with('status', 'Akun admin telah dihapus.');
    }

    private function syncMicrosites(Admin $admin, array $data): void
    {
        $admin->microsites()->sync(
            $admin->isSuperAdmin() ? [] : ($data['microsite_ids'] ?? [])
        );
    }
}