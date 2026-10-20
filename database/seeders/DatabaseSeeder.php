<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Category;
use App\Models\MenuItem;
use App\Models\Microsite;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $kafe = Microsite::create([
            'name' => 'Kafe Contoh',
            'slug' => 'kafe',
            'settings' => ['color' => '#8B5E3C', 'open_hours' => '08.00 - 22.00'],
        ]);

        $restoran = Microsite::create([
            'name' => 'Restoran Contoh',
            'slug' => 'restoran',
            'settings' => ['color' => '#B23A48', 'open_hours' => '10.00 - 21.00'],
        ]);

        Admin::create([
            'name' => 'Super Admin',
            'username' => 'superadmin',
            'password' => 'password123',
            'role' => 'super_admin',
        ]);

        $adminKafe = Admin::create([
            'name' => 'Admin Kafe',
            'username' => 'admin_kafe',
            'password' => 'password123',
            'role' => 'admin',
        ]);
        $adminKafe->microsites()->attach($kafe->id);

        $adminRestoran = Admin::create([
            'name' => 'Admin Restoran',
            'username' => 'admin_restoran',
            'password' => 'password123',
            'role' => 'admin',
        ]);
        $adminRestoran->microsites()->attach($restoran->id);

        $minuman = Category::create(['microsite_id' => $kafe->id, 'name' => 'Minuman', 'sort_order' => 1]);
        $camilan = Category::create(['microsite_id' => $kafe->id, 'name' => 'Camilan', 'sort_order' => 2]);
        MenuItem::create(['microsite_id' => $kafe->id, 'category_id' => $minuman->id, 'name' => 'Kopi Susu', 'price' => 18000]);
        MenuItem::create(['microsite_id' => $kafe->id, 'category_id' => $camilan->id, 'name' => 'Kentang Goreng', 'price' => 15000]);

        $utama = Category::create(['microsite_id' => $restoran->id, 'name' => 'Makanan Utama', 'sort_order' => 1]);
        $paket = Category::create(['microsite_id' => $restoran->id, 'name' => 'Paket Keluarga', 'sort_order' => 2]);
        MenuItem::create(['microsite_id' => $restoran->id, 'category_id' => $utama->id, 'name' => 'Nasi Goreng Spesial', 'price' => 28000]);
        MenuItem::create(['microsite_id' => $restoran->id, 'category_id' => $paket->id, 'name' => 'Paket Keluarga 4 Orang', 'price' => 120000]);
    }
}