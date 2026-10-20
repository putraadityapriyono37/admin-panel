<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DatabaseSeederTest extends TestCase
{
    use RefreshDatabase;

    /**
     * DatabaseSeeder dapat membangun database lokal lengkap untuk ketiga repo
     */
    public function test_database_seeder_seeds_all_sample_data(): void
    {
        $this->seed();

        $this->assertDatabaseHas('microsites', ['slug' => 'kafe']);
        $this->assertDatabaseHas('microsites', ['slug' => 'restoran']);
        $this->assertDatabaseHas('admins', ['username' => 'superadmin']);
        $this->assertDatabaseHas('admins', ['username' => 'admin_kafe']);
        $this->assertDatabaseHas('menu_items', ['name' => 'Kopi Susu']);
        $this->assertDatabaseHas('orders', ['order_code' => 'KAFE-001']);
        $this->assertDatabaseCount('galleries', 4);
        $this->assertDatabaseCount('promos', 3);
    }
}
