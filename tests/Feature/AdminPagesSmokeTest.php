<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Microsite;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminPagesSmokeTest extends TestCase
{
    use RefreshDatabase;

    private Microsite $kafe;

    private Admin $adminKafe;

    private Admin $superAdmin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->kafe = Microsite::create([
            'name' => 'Kafe Contoh',
            'slug' => 'kafe',
            'settings' => ['color' => '#8B5E3C'],
        ]);

        $this->adminKafe = Admin::create([
            'name' => 'Admin Kafe',
            'username' => 'admin_kafe',
            'password' => 'password123',
            'role' => 'admin',
        ]);
        $this->adminKafe->microsites()->attach($this->kafe->id);

        $this->superAdmin = Admin::create([
            'name' => 'Super Admin',
            'username' => 'superadmin',
            'password' => 'password123',
            'role' => 'super_admin',
        ]);
    }

    /**
     * Halaman login tampil tanpa error
     */
    public function test_login_page_renders(): void
    {
        $response = $this->get(route('admin.login'));

        $response->assertOk();
        $response->assertSee('Login Admin');
        $response->assertSee('data-toggle-password', false);
    }

    /**
     * Halaman super admin tampil tanpa error
     */
    public function test_super_admin_pages_render(): void
    {
        $this->actingAs($this->superAdmin, 'admin')
            ->get(route('admin.super.dashboard'))
            ->assertOk()
            ->assertSee('Dashboard Super Admin');

        $this->actingAs($this->superAdmin, 'admin')
            ->get(route('admin.microsites.index'))
            ->assertOk()
            ->assertSee('Microsite');

        $this->actingAs($this->superAdmin, 'admin')
            ->get(route('admin.admins.index'))
            ->assertOk()
            ->assertSee('Akun Admin');
    }

    /**
     * Semua halaman microsite tampil tanpa error
     */
    public function test_microsite_pages_render(): void
    {
        $routes = [
            'admin.dashboard',
            'admin.info.edit',
            'admin.categories.index',
            'admin.menu-items.index',
            'admin.galleries.index',
            'admin.promos.index',
            'admin.orders.index',
        ];

        foreach ($routes as $route) {
            $this->actingAs($this->adminKafe, 'admin')
                ->get(route($route, $this->kafe))
                ->assertOk();
        }
    }

    /**
     * Halaman tambah data tampil tanpa error
     */
    public function test_create_form_pages_render(): void
    {
        $routes = [
            'admin.categories.create',
            'admin.menu-items.create',
            'admin.galleries.create',
            'admin.promos.create',
        ];

        foreach ($routes as $route) {
            $this->actingAs($this->adminKafe, 'admin')
                ->get(route($route, $this->kafe))
                ->assertOk();
        }
    }
}
