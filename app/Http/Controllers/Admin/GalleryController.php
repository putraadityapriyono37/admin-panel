<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\Microsite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index(Microsite $microsite)
    {
        // Query ini otomatis dibatasi ke microsite aktif oleh MicrositeScope
        $galleries = Gallery::orderByDesc('created_at')->get();

        return view('admin.galleries.index', [
            'currentMicrosite' => $microsite,
            'galleries' => $galleries,
        ]);
    }

    public function create(Microsite $microsite)
    {
        return view('admin.galleries.create', ['currentMicrosite' => $microsite]);
    }

    public function store(Request $request, Microsite $microsite)
    {
        $data = $this->validateInput($request, true);
        $data['image'] = $request->file('image')->store('gallery', 'public');

        // microsite_id diisi otomatis oleh trait BelongsToMicrosite
        Gallery::create($data);

        return redirect()->route('admin.galleries.index', $microsite)
            ->with('status', 'Galeri berhasil ditambahkan.');
    }

    public function edit(Microsite $microsite, Gallery $gallery)
    {
        Gate::authorize('update', $gallery);

        return view('admin.galleries.edit', [
            'currentMicrosite' => $microsite,
            'gallery' => $gallery,
        ]);
    }

    public function update(Request $request, Microsite $microsite, Gallery $gallery)
    {
        Gate::authorize('update', $gallery);

        $data = $this->validateInput($request);

        if ($request->hasFile('image')) {
            if ($gallery->image) {
                Storage::disk('public')->delete($gallery->image);
            }

            $data['image'] = $request->file('image')->store('gallery', 'public');
        }

        $gallery->update($data);

        return redirect()->route('admin.galleries.index', $microsite)
            ->with('status', 'Galeri berhasil diperbarui.');
    }

    public function destroy(Microsite $microsite, Gallery $gallery)
    {
        Gate::authorize('delete', $gallery);

        if ($gallery->image) {
            Storage::disk('public')->delete($gallery->image);
        }

        $gallery->delete();

        return redirect()->route('admin.galleries.index', $microsite)
            ->with('status', 'Galeri berhasil dihapus.');
    }

    private function validateInput(Request $request, bool $imageRequired = false): array
    {
        return $request->validate([
            // Saat update foto boleh dilewati, foto lama tetap dipakai
            'image' => [$imageRequired ? 'required' : 'nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'caption' => ['nullable', 'string', 'max:255'],
        ]);
    }
}
