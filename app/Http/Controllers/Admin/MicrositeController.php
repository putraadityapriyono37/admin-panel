<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Microsite;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class MicrositeController extends Controller
{
    private const SETTING_KEYS = ['color', 'open_hours', 'address', 'phone'];

    public function index()
    {
        $microsites = Microsite::withCount('admins')->orderBy('name')->get();

        return view('admin.microsites.index', compact('microsites'));
    }

    public function create()
    {
        return view('admin.microsites.create');
    }

    public function store(Request $request)
    {
        $request->merge(['slug' => strtolower((string) $request->input('slug'))]);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'slug' => ['required', 'alpha_dash', 'max:50', 'unique:microsites,slug'],
            'domain' => ['nullable', 'string', 'max:255'],
            'color' => ['nullable', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'open_hours' => ['nullable', 'string', 'max:100'],
            'address' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
        ]);

        Microsite::create([
            'name' => $data['name'],
            'slug' => $data['slug'],
            'domain' => $data['domain'] ?? null,
            'is_active' => $request->boolean('is_active'),
            'settings' => $this->settingsFrom($data),
        ]);

        return redirect()->route('admin.microsites.index')
            ->with('status', 'Microsite berhasil ditambahkan.');
    }

    public function edit(Microsite $microsite)
    {
        return view('admin.microsites.edit', compact('microsite'));
    }

    public function update(Request $request, Microsite $microsite)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'domain' => ['nullable', 'string', 'max:255'],
            'color' => ['nullable', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'open_hours' => ['nullable', 'string', 'max:100'],
            'address' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
        ]);

        $otherSettings = Arr::except($microsite->settings ?? [], self::SETTING_KEYS);

        $microsite->update([
            'name' => $data['name'],
            'domain' => $data['domain'] ?? null,
            'is_active' => $request->boolean('is_active'),
            'settings' => array_merge($otherSettings, $this->settingsFrom($data)),
        ]);

        return redirect()->route('admin.microsites.index')
            ->with('status', 'Microsite berhasil diperbarui.');
    }

    public function destroy(Microsite $microsite)
    {
        if ($microsite->is_active) {
            return back()->withErrors([
                'microsite' => 'Nonaktifkan microsite terlebih dahulu sebelum menghapusnya.',
            ]);
        }

        $microsite->delete();

        return redirect()->route('admin.microsites.index')
            ->with('status', 'Microsite beserta seluruh datanya telah dihapus.');
    }

    private function settingsFrom(array $data): array
    {
        return array_filter(
            Arr::only($data, self::SETTING_KEYS),
            fn($value) => filled($value)
        );
    }
}