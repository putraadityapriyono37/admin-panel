<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\MenuItem;
use App\Models\Microsite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class MenuItemController extends Controller
{
    public function index(Microsite $microsite)
    {
        $items = MenuItem::with('category')
            ->orderBy('category_id')
            ->orderBy('name')
            ->get();

        return view('admin.menu-items.index', [
            'currentMicrosite' => $microsite,
            'items' => $items,
        ]);
    }

    public function create(Microsite $microsite)
    {
        return view('admin.menu-items.create', [
            'currentMicrosite' => $microsite,
            'categories' => $this->categories(),
        ]);
    }

    public function store(Request $request, Microsite $microsite)
    {
        $data = $this->validateInput($request, $microsite);
        $data['is_available'] = $request->boolean('is_available');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('menu', 'public');
        }

        MenuItem::create($data);

        return redirect()->route('admin.menu-items.index', $microsite)
            ->with('status', 'Menu berhasil ditambahkan.');
    }

    public function edit(Microsite $microsite, MenuItem $menuItem)
    {
        Gate::authorize('update', $menuItem);

        return view('admin.menu-items.edit', [
            'currentMicrosite' => $microsite,
            'item' => $menuItem,
            'categories' => $this->categories(),
        ]);
    }

    public function update(Request $request, Microsite $microsite, MenuItem $menuItem)
    {
        Gate::authorize('update', $menuItem);

        $data = $this->validateInput($request, $microsite);
        $data['is_available'] = $request->boolean('is_available');

        if ($request->hasFile('image')) {
            if ($menuItem->image) {
                Storage::disk('public')->delete($menuItem->image);
            }

            $data['image'] = $request->file('image')->store('menu', 'public');
        }

        $menuItem->update($data);

        return redirect()->route('admin.menu-items.index', $microsite)
            ->with('status', 'Menu berhasil diperbarui.');
    }

    public function toggle(Microsite $microsite, MenuItem $menuItem)
    {
        Gate::authorize('update', $menuItem);

        $menuItem->update(['is_available' => ! $menuItem->is_available]);

        return back()->with('status', 'Status menu diperbarui.');
    }

    public function destroy(Microsite $microsite, MenuItem $menuItem)
    {
        Gate::authorize('delete', $menuItem);

        if ($menuItem->image) {
            Storage::disk('public')->delete($menuItem->image);
        }

        $menuItem->delete();

        return redirect()->route('admin.menu-items.index', $microsite)
            ->with('status', 'Menu berhasil dihapus.');
    }

    private function categories()
    {
        return Category::orderBy('sort_order')->orderBy('name')->get();
    }

    private function validateInput(Request $request, Microsite $microsite): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'category_id' => [
                'required',
                // exists: memakai query builder, jadi global scope tidak berlaku. Batasi manual.
                Rule::exists('categories', 'id')->where('microsite_id', $microsite->id),
            ],
            'description' => ['nullable', 'string', 'max:1000'],
            'price' => ['required', 'integer', 'min:0', 'max:100000000'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);
    }
}
