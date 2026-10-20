<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Microsite;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderManagementTest extends TestCase
{
    use RefreshDatabase;

    private Microsite $kafe;

    private Microsite $restoran;

    private Admin $adminKafe;

    private Admin $adminRestoran;

    private Admin $superAdmin;

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

        $this->superAdmin = Admin::create([
            'name' => 'Super Admin',
            'username' => 'superadmin',
            'password' => 'password123',
            'role' => 'super_admin',
        ]);
    }

    /**
     * FA-11: Admin biasa dapat melihat daftar pesanan microsite miliknya.
     */
    public function test_admin_kafe_can_view_orders_index_of_kafe(): void
    {
        $order = Order::create([
            'microsite_id' => $this->kafe->id,
            'order_code' => 'ORD-KAFE-001',
            'customer_name' => 'Budi',
            'table_number' => '4',
            'status' => 'baru',
            'total_price' => 25000,
        ]);

        $response = $this->actingAs($this->adminKafe, 'admin')
            ->get(route('admin.orders.index', $this->kafe));

        $response->assertStatus(200);
        $response->assertSee('ORD-KAFE-001');
        $response->assertSee('Budi');
    }

    /**
     * FA-11: Pesanan microsite lain tidak boleh terlihat di daftar pesanan.
     */
    public function test_orders_from_other_microsites_are_not_visible(): void
    {
        Order::create([
            'microsite_id' => $this->kafe->id,
            'order_code' => 'ORD-KAFE-001',
            'customer_name' => 'Budi Kafe',
            'table_number' => '4',
            'status' => 'baru',
            'total_price' => 25000,
        ]);

        Order::create([
            'microsite_id' => $this->restoran->id,
            'order_code' => 'ORD-RESTO-999',
            'customer_name' => 'Siti Resto',
            'table_number' => '10',
            'status' => 'baru',
            'total_price' => 120000,
        ]);

        $response = $this->actingAs($this->adminKafe, 'admin')
            ->get(route('admin.orders.index', $this->kafe));

        $response->assertStatus(200);
        $response->assertSee('ORD-KAFE-001');
        $response->assertDontSee('ORD-RESTO-999');
    }

    /**
     * FA-11: Admin kafe tidak bisa membuka daftar pesanan restoran (403).
     */
    public function test_admin_kafe_accessing_restoran_orders_gets_403(): void
    {
        $response = $this->actingAs($this->adminKafe, 'admin')
            ->get(route('admin.orders.index', $this->restoran));

        $response->assertStatus(403);
    }

    /**
     * FA-11: Admin kafe membuka pesanan restoran lewat URL kafe -> 404 (scoped binding).
     */
    public function test_admin_kafe_accessing_restoran_order_via_kafe_url_gets_404(): void
    {
        $restoOrder = Order::create([
            'microsite_id' => $this->restoran->id,
            'order_code' => 'ORD-RESTO-001',
            'customer_name' => 'Andi',
            'table_number' => '1',
            'status' => 'baru',
            'total_price' => 50000,
        ]);

        $response = $this->actingAs($this->adminKafe, 'admin')
            ->get("/admin/m/kafe/orders/{$restoOrder->id}");

        $response->assertStatus(404);
    }

    /**
     * FA-11: Detail pesanan dan item menu terlihat oleh admin yang berhak.
     */
    public function test_admin_can_view_order_details_and_items(): void
    {
        $order = Order::create([
            'microsite_id' => $this->kafe->id,
            'order_code' => 'ORD-KAFE-002',
            'customer_name' => 'Dewi',
            'table_number' => '2',
            'notes' => 'Kurang manis',
            'status' => 'baru',
            'total_price' => 30000,
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'microsite_id' => $this->kafe->id,
            'item_name' => 'Kopi Susu Gula Aren',
            'unit_price' => 15000,
            'quantity' => 2,
        ]);

        $response = $this->actingAs($this->adminKafe, 'admin')
            ->get(route('admin.orders.show', [$this->kafe, $order]));

        $response->assertStatus(200);
        $response->assertSee('ORD-KAFE-002');
        $response->assertSee('Dewi');
        $response->assertSee('Kurang manis');
        $response->assertSee('Kopi Susu Gula Aren');
        $response->assertSee('15.000');
        $response->assertSee('30.000');
    }

    /**
     * FA-11: Filter pesanan berdasarkan status.
     */
    public function test_filter_orders_by_status(): void
    {
        Order::create([
            'microsite_id' => $this->kafe->id,
            'order_code' => 'ORD-BARU',
            'customer_name' => 'User Baru',
            'status' => 'baru',
            'total_price' => 10000,
        ]);

        Order::create([
            'microsite_id' => $this->kafe->id,
            'order_code' => 'ORD-SELESAI',
            'customer_name' => 'User Selesai',
            'status' => 'selesai',
            'total_price' => 10000,
        ]);

        $response = $this->actingAs($this->adminKafe, 'admin')
            ->get(route('admin.orders.index', [$this->kafe, 'status' => 'baru']));

        $response->assertStatus(200);
        $response->assertSee('ORD-BARU');
        $response->assertDontSee('ORD-SELESAI');
    }

    /**
     * FA-12: Admin biasa dapat mengubah status pesanan (baru -> diproses -> siap -> selesai -> dibatalkan).
     */
    public function test_admin_can_update_order_status(): void
    {
        $order = Order::create([
            'microsite_id' => $this->kafe->id,
            'order_code' => 'ORD-KAFE-003',
            'customer_name' => 'Rian',
            'status' => 'baru',
            'total_price' => 20000,
        ]);

        $response = $this->actingAs($this->adminKafe, 'admin')
            ->patch(route('admin.orders.status', [$this->kafe, $order]), [
                'status' => 'diproses',
            ]);

        $response->assertRedirect();
        $this->assertEquals('diproses', $order->fresh()->status);
    }

    /**
     * FA-12: Update status pesanan dengan nilai tidak valid ditolak.
     */
    public function test_invalid_order_status_update_is_rejected(): void
    {
        $order = Order::create([
            'microsite_id' => $this->kafe->id,
            'order_code' => 'ORD-KAFE-004',
            'customer_name' => 'Rian',
            'status' => 'baru',
            'total_price' => 20000,
        ]);

        $response = $this->actingAs($this->adminKafe, 'admin')
            ->patch(route('admin.orders.status', [$this->kafe, $order]), [
                'status' => 'status_palsu',
            ]);

        $response->assertSessionHasErrors('status');
        $this->assertEquals('baru', $order->fresh()->status);
    }
}
