<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Category;
use App\Models\MenuItem;
use App\Models\Microsite;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccessControlTest extends TestCase
{
    use RefreshDatabase;

    private Microsite $kafe;

    private Microsite $restoran;

    private Admin $adminKafe;

    private Admin $adminRestoran;

    protected function setUp(): void
    {
        parent::setUp();

        $this->kafe = Microsite::create([
            'name' => 'Kafe Contoh',
            'slug' => 'kafe',
            'settings' => ['color' => '#8B5E3C'],
        ]);

        $this->restoran = Microsite::create([
            'name' => 'Restoran Contoh',
            'slug' => 'restoran',
            'settings' => ['color' => '#B23A48'],
        ]);

        $this->adminKafe = Admin::create([
            'name' => 'Admin Kafe',
            'username' => 'admin_kafe',
            'password' => 'password123',
            'role' => 'admin',
        ]);
        $this->adminKafe->microsites()->attach($this->kafe->id);

        $this->adminRestoran = Admin::create([
            'name' => 'Admin Restoran',
            'username' => 'admin_restoran',
            'password' => 'password123',
            'role' => 'admin',
        ]);
        $this->adminRestoran->microsites()->attach($this->restoran->id);
    }

    /**
     * admin_kafe mengakses /admin/m/restoran/categories → 403
     */
    public function test_admin_kafe_accessing_restoran_categories_gets_403(): void
    {
        $response = $this->actingAs($this->adminKafe, 'admin')
            ->get(route('admin.categories.index', $this->restoran));

        $response->assertStatus(403);
    }

    /**
     * admin_kafe mengakses /admin/m/kafe/categories/{id} di mana kategori milik restoran → 404
     */
    public function test_admin_kafe_accessing_restoran_category_via_kafe_url_gets_404(): void
    {
        $restoranCategory = Category::create([
            'microsite_id' => $this->restoran->id,
            'name' => 'Makanan Utama',
            'sort_order' => 1,
        ]);

        $response = $this->actingAs($this->adminKafe, 'admin')
            ->get("/admin/m/kafe/categories/{$restoranCategory->id}/edit");

        $response->assertStatus(404);
    }

    /**
     * admin_kafe mengakses /admin/m/kafe/menu-items/{id} di mana menu milik restoran → 404
     */
    public function test_admin_kafe_accessing_restoran_menu_item_via_kafe_url_gets_404(): void
    {
        $restoranCategory = Category::create([
            'microsite_id' => $this->restoran->id,
            'name' => 'Makanan Utama',
            'sort_order' => 1,
        ]);

        $restoranItem = MenuItem::create([
            'microsite_id' => $this->restoran->id,
            'category_id' => $restoranCategory->id,
            'name' => 'Nasi Goreng',
            'price' => 25000,
        ]);

        $response = $this->actingAs($this->adminKafe, 'admin')
            ->get("/admin/m/kafe/menu-items/{$restoranItem->id}/edit");

        $response->assertStatus(404);
    }

    /**
     * Form tambah menu: category_id dimanipulasi ke milik restoran → ditolak (validasi gagal)
     */
    public function test_menu_store_with_manipulated_category_id_is_rejected(): void
    {
        $restoranCategory = Category::create([
            'microsite_id' => $this->restoran->id,
            'name' => 'Makanan Utama',
            'sort_order' => 1,
        ]);

        $response = $this->actingAs($this->adminKafe, 'admin')
            ->post(route('admin.menu-items.store', $this->kafe), [
                'name' => 'Menu Curang',
                'category_id' => $restoranCategory->id, // manipulated: belongs to restoran
                'price' => 10000,
                'is_available' => '1',
            ]);

        // Harus ditolak dengan validation error (422 atau redirect with errors)
        $response->assertSessionHasErrors('category_id');
    }

    /**
     * admin_kafe dapat mengakses kategori miliknya sendiri (kafe)
     */
    public function test_admin_kafe_can_access_own_category(): void
    {
        $kafeCategory = Category::create([
            'microsite_id' => $this->kafe->id,
            'name' => 'Minuman',
            'sort_order' => 1,
        ]);

        $response = $this->actingAs($this->adminKafe, 'admin')
            ->get(route('admin.categories.edit', [$this->kafe, $kafeCategory]));

        $response->assertStatus(200);
    }

    /**
     * admin_kafe dapat melihat kategori milik kafe di halaman daftar kategori
     */
    public function test_admin_kafe_categories_index_only_shows_kafe_categories(): void
    {
        Category::create(['microsite_id' => $this->kafe->id, 'name' => 'Minuman', 'sort_order' => 1]);
        Category::create(['microsite_id' => $this->restoran->id, 'name' => 'Makanan Utama', 'sort_order' => 1]);

        $response = $this->actingAs($this->adminKafe, 'admin')
            ->get(route('admin.categories.index', $this->kafe));

        $response->assertStatus(200);
        $response->assertSee('Minuman');
        $response->assertDontSee('Makanan Utama');
    }

    /**
     * Nama kategori yang sama ditolak untuk microsite yang sama (unique per microsite)
     */
    public function test_duplicate_category_name_in_same_microsite_is_rejected(): void
    {
        Category::create(['microsite_id' => $this->kafe->id, 'name' => 'Minuman', 'sort_order' => 1]);

        $response = $this->actingAs($this->adminKafe, 'admin')
            ->post(route('admin.categories.store', $this->kafe), [
                'name' => 'Minuman',
                'sort_order' => 2,
            ]);

        $response->assertSessionHasErrors('name');
    }

    /**
     * Nama kategori yang sama BOLEH ada di microsite berbeda
     */
    public function test_same_category_name_allowed_in_different_microsites(): void
    {
        Category::create(['microsite_id' => $this->restoran->id, 'name' => 'Minuman', 'sort_order' => 1]);

        $response = $this->actingAs($this->adminKafe, 'admin')
            ->post(route('admin.categories.store', $this->kafe), [
                'name' => 'Minuman',
                'sort_order' => 1,
            ]);

        $response->assertRedirect(route('admin.categories.index', $this->kafe));
        $this->assertDatabaseHas('categories', [
            'microsite_id' => $this->kafe->id,
            'name' => 'Minuman',
        ]);
    }

    /**
     * Hapus kategori yang masih punya menu → ditolak
     */
    public function test_deleting_category_with_menu_items_is_rejected(): void
    {
        $kafeCategory = Category::create([
            'microsite_id' => $this->kafe->id,
            'name' => 'Minuman',
            'sort_order' => 1,
        ]);

        MenuItem::create([
            'microsite_id' => $this->kafe->id,
            'category_id' => $kafeCategory->id,
            'name' => 'Es Teh',
            'price' => 8000,
        ]);

        $response = $this->actingAs($this->adminKafe, 'admin')
            ->delete(route('admin.categories.destroy', [$this->kafe, $kafeCategory]));

        $response->assertSessionHasErrors('category');
        $this->assertDatabaseHas('categories', ['id' => $kafeCategory->id]);
    }
}
