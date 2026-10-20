<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Microsite;
use App\Models\Promo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PromoController extends Controller
{
    public function index(Microsite $microsite)
    {
        // Query ini otomatis dibatasi ke microsite aktif oleh MicrositeScope
        $promos = Promo::orderBy('start_date')->orderByDesc('end_date')->get();

        return view('admin.promos.index', [
            'currentMicrosite' => $microsite,
            'promos' => $promos,
            'now' => now()->startOfDay(),
        ]);
    }

    public function create(Microsite $microsite)
    {
        return view('admin.promos.create', ['currentMicrosite' => $microsite]);
    }

    public function store(Request $request, Microsite $microsite)
    {
        // microsite_id diisi otomatis oleh trait BelongsToMicrosite
        Promo::create($this->validateInput($request));

        return redirect()->route('admin.promos.index', $microsite)
            ->with('status', 'Promo berhasil ditambahkan.');
    }

    public function edit(Microsite $microsite, Promo $promo)
    {
        Gate::authorize('update', $promo);

        return view('admin.promos.edit', [
            'currentMicrosite' => $microsite,
            'promo' => $promo,
        ]);
    }

    public function update(Request $request, Microsite $microsite, Promo $promo)
    {
        Gate::authorize('update', $promo);

        $promo->update($this->validateInput($request));

        return redirect()->route('admin.promos.index', $microsite)
            ->with('status', 'Promo berhasil diperbarui.');
    }

    public function destroy(Microsite $microsite, Promo $promo)
    {
        Gate::authorize('delete', $promo);

        $promo->delete();

        return redirect()->route('admin.promos.index', $microsite)
            ->with('status', 'Promo berhasil dihapus.');
    }

    private function validateInput(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string', 'max:1000'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
        ]);
    }
}
