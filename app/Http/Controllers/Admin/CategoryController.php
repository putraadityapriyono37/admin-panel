<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Microsite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index(Microsite $microsite)
    {
        // Query ini otomatis dibatasi ke microsite aktif oleh MicrositeScope
        $categories = Category::withCount('menuItems')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('admin.categories.index', [
            'currentMicrosite' => $microsite,
            'categories' => $categories,
        ]);
    }

    public function create(Microsite $microsite)
    {
        return view('admin.categories.create', ['currentMicrosite' => $microsite]);
    }

    public function store(Request $request, Microsite $microsite)
    {
        $data = $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('categories', 'name')->where('microsite_id', $microsite->id),
            ],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
        ]);

        // microsite_id diisi otomatis oleh trait BelongsToMicrosite
        Category::create([
            'name' => $data['name'],
            'sort_order' => $data['sort_order'] ?? 0,
        ]);

        return redirect()->route('admin.categories.index', $microsite)
            ->with('status', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Microsite $microsite, Category $category)
    {
        Gate::authorize('update', $category);

        return view('admin.categories.edit', [
            'currentMicrosite' => $microsite,
            'category' => $category,
        ]);
    }

    public function update(Request $request, Microsite $microsite, Category $category)
    {
        Gate::authorize('update', $category);

        $data = $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('categories', 'name')
                    ->where('microsite_id', $microsite->id)
                    ->ignore($category->id),
            ],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
        ]);

        $category->update([
            'name' => $data['name'],
            'sort_order' => $data['sort_order'] ?? 0,
        ]);

        return redirect()->route('admin.categories.index', $microsite)
            ->with('status', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Microsite $microsite, Category $category)
    {
        Gate::authorize('delete', $category);

        if ($category->menuItems()->exists()) {
            return back()->withErrors([
                'category' => 'Kategori masih berisi menu. Pindahkan atau hapus menunya terlebih dahulu.',
            ]);
        }

        $category->delete();

        return redirect()->route('admin.categories.index', $microsite)
            ->with('status', 'Kategori berhasil dihapus.');
    }
}
