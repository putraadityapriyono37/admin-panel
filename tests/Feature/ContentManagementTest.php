<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Gallery;
use App\Models\Microsite;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Promo;
use App\Support\CurrentMicrosite;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ContentManagementTest extends TestCase
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
     * Daftar galeri hanya menampilkan data milik microsite aktif
     */
    public function test_admin_kafe_galleries_index_only_shows_kafe_galleries(): void
    {
        Gallery::create(['microsite_id' => $this->kafe->id, 'image' => 'gallery/kafe.jpg', 'caption' => 'Suasana Kafe']);
        Gallery::create(['microsite_id' => $this->restoran->id, 'image' => 'gallery/restoran.jpg', 'caption' => 'Suasana Restoran']);

        $response = $this->actingAs($this->adminKafe, 'admin')
            ->get(route('admin.galleries.index', $this->kafe));

        $response->assertStatus(200);
        $response->assertSee('Suasana Kafe');
        $response->assertDontSee('Suasana Restoran');
    }

    /**
     * admin_kafe mengakses /admin/m/kafe/galleries/{id} di mana galeri milik restoran → 404
     */
    public function test_admin_kafe_accessing_restoran_gallery_edit_via_kafe_url_gets_404(): void
    {
        $restoranGallery = Gallery::create([
            'microsite_id' => $this->restoran->id,
            'image' => 'gallery/restoran.jpg',
            'caption' => 'Suasana Restoran',
        ]);

        $response = $this->actingAs($this->adminKafe, 'admin')
            ->get("/admin/m/kafe/galleries/{$restoranGallery->id}/edit");

        $response->assertStatus(404);
    }

    /**
     * admin_kafe menambah galeri dengan foto
     */
    public function test_admin_kafe_can_add_gallery_item(): void
    {
        Storage::fake('public');

        $response = $this->actingAs($this->adminKafe, 'admin')
            ->post(route('admin.galleries.store', $this->kafe), [
                'image' => UploadedFile::fake()->image('suasana.jpg'),
                'caption' => 'Suasana Kafe',
            ]);

        $response->assertRedirect(route('admin.galleries.index', $this->kafe));
        $this->assertDatabaseHas('galleries', [
            'microsite_id' => $this->kafe->id,
            'caption' => 'Suasana Kafe',
        ]);
    }

    /**
     * Tambah galeri tanpa foto → ditolak
     */
    public function test_gallery_store_requires_image(): void
    {
        $response = $this->actingAs($this->adminKafe, 'admin')
            ->post(route('admin.galleries.store', $this->kafe), [
                'caption' => 'Tanpa foto',
            ]);

        $response->assertSessionHasErrors('image');
    }

    /**
     * Daftar promo hanya menampilkan data milik microsite aktif
     */
    public function test_admin_kafe_promos_index_only_shows_kafe_promos(): void
    {
        Promo::create([
            'microsite_id' => $this->kafe->id,
            'title' => 'Promo Kopi Kafe',
            'start_date' => '2026-10-01',
            'end_date' => '2026-10-31',
        ]);
        Promo::create([
            'microsite_id' => $this->restoran->id,
            'title' => 'Promo Paket Restoran',
            'start_date' => '2026-10-01',
            'end_date' => '2026-10-31',
        ]);

        $response = $this->actingAs($this->adminKafe, 'admin')
            ->get(route('admin.promos.index', $this->kafe));

        $response->assertStatus(200);
        $response->assertSee('Promo Kopi Kafe');
        $response->assertDontSee('Promo Paket Restoran');
    }

    /**
     * admin_kafe mengakses /admin/m/kafe/promos/{id} di mana promo milik restoran → 404
     */
    public function test_admin_kafe_accessing_restoran_promo_edit_via_kafe_url_gets_404(): void
    {
        $restoranPromo = Promo::create([
            'microsite_id' => $this->restoran->id,
            'title' => 'Promo Paket Restoran',
            'start_date' => '2026-10-01',
            'end_date' => '2026-10-31',
        ]);

        $response = $this->actingAs($this->adminKafe, 'admin')
            ->get("/admin/m/kafe/promos/{$restoranPromo->id}/edit");

        $response->assertStatus(404);
    }

    /**
     * Tanggal berakhir sebelum tanggal mulai → ditolak
     */
    public function test_promo_with_end_date_before_start_date_is_rejected(): void
    {
        $response = $this->actingAs($this->adminKafe, 'admin')
            ->post(route('admin.promos.store', $this->kafe), [
                'title' => 'Promo Salah',
                'start_date' => '2026-10-20',
                'end_date' => '2026-10-19',
            ]);

        $response->assertSessionHasErrors('end_date');
    }

    /**
     * admin_kafe menambah promo valid
     */
    public function test_admin_kafe_can_add_promo(): void
    {
        $response = $this->actingAs($this->adminKafe, 'admin')
            ->post(route('admin.promos.store', $this->kafe), [
                'title' => 'Promo Kopi',
                'description' => 'Diskon 20% untuk semua kopi',
                'start_date' => '2026-10-20',
                'end_date' => '2026-10-31',
            ]);

        $response->assertRedirect(route('admin.promos.index', $this->kafe));
        $this->assertDatabaseHas('promos', [
            'microsite_id' => $this->kafe->id,
            'title' => 'Promo Kopi',
        ]);
    }

    /**
     * admin biasa dapat mengubah info restoran (deskripsi dan media sosial tersimpan)
     */
    public function test_admin_kafe_can_update_restoran_info(): void
    {
        $response = $this->actingAs($this->adminKafe, 'admin')
            ->patch(route('admin.info.update', $this->kafe), [
                'open_hours' => '08.00 - 22.00',
                'address' => 'Jl. Merdeka No. 1',
                'phone' => '08123456789',
                'description' => 'Kafe nyaman untuk kerja dan nongkrong.',
                'social_media' => '@kafekita',
            ]);

        $response->assertRedirect();

        $this->kafe->refresh();
        $this->assertSame('Kafe nyaman untuk kerja dan nongkrong.', $this->kafe->settings['description']);
        $this->assertSame('@kafekita', $this->kafe->settings['social_media']);
    }

    /**
     * Ubah info restoran tidak menghapus warna tema yang diatur super admin
     */
    public function test_restoran_info_update_preserves_theme_color(): void
    {
        $response = $this->actingAs($this->adminKafe, 'admin')
            ->patch(route('admin.info.update', $this->kafe), [
                'description' => 'Deskripsi baru.',
            ]);

        $response->assertRedirect();

        $this->kafe->refresh();
        $this->assertSame('#8B5E3C', $this->kafe->settings['color']);
    }

    /**
     * admin_kafe tidak dapat mengubah info restoran milik restoran
     */
    public function test_admin_kafe_cannot_update_restoran_info(): void
    {
        $response = $this->actingAs($this->adminKafe, 'admin')
            ->patch(route('admin.info.update', $this->restoran), [
                'description' => 'Disusupi.',
            ]);

        $response->assertStatus(403);

        $this->restoran->refresh();
        $this->assertArrayNotHasKey('description', $this->restoran->settings ?? []);
    }

    /**
     * Query order_items otomatis dibatasi ke microsite aktif
     */
    public function test_order_items_are_scoped_to_current_microsite(): void
    {
        $kafeOrder = Order::create([
            'microsite_id' => $this->kafe->id,
            'order_code' => 'KAFE-001',
            'customer_name' => 'Budi',
            'status' => 'baru',
            'total_price' => 18000,
        ]);
        OrderItem::create([
            'order_id' => $kafeOrder->id,
            'microsite_id' => $this->kafe->id,
            'item_name' => 'Kopi Susu',
            'unit_price' => 18000,
            'quantity' => 1,
        ]);

        $restoranOrder = Order::create([
            'microsite_id' => $this->restoran->id,
            'order_code' => 'RESTORAN-001',
            'customer_name' => 'Siti',
            'status' => 'baru',
            'total_price' => 28000,
        ]);
        OrderItem::create([
            'order_id' => $restoranOrder->id,
            'microsite_id' => $this->restoran->id,
            'item_name' => 'Nasi Goreng',
            'unit_price' => 28000,
            'quantity' => 1,
        ]);

        app(CurrentMicrosite::class)->set($this->kafe);

        $this->assertSame(1, OrderItem::count());
        $this->assertSame('Kopi Susu', OrderItem::first()->item_name);
    }
}
