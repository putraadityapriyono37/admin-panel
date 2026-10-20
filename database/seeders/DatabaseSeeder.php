<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Category;
use App\Models\Gallery;
use App\Models\MenuItem;
use App\Models\Microsite;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Promo;
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

        Gallery::create(['microsite_id' => $kafe->id, 'image' => 'gallery/kafe-1.jpg', 'caption' => 'Suasana kafe di sore hari']);
        Gallery::create(['microsite_id' => $kafe->id, 'image' => 'gallery/kafe-2.jpg', 'caption' => 'Sudut tempat duduk']);
        Gallery::create(['microsite_id' => $restoran->id, 'image' => 'gallery/restoran-1.jpg', 'caption' => 'Ruang makan keluarga']);
        Gallery::create(['microsite_id' => $restoran->id, 'image' => 'gallery/restoran-2.jpg', 'caption' => 'Meja panjang untuk acara']);

        Promo::create([
            'microsite_id' => $kafe->id,
            'title' => 'Diskon Kopi 20%',
            'description' => 'Berlaku untuk semua menu kopi.',
            'start_date' => now()->subDays(7),
            'end_date' => now()->addDays(7),
        ]);
        Promo::create([
            'microsite_id' => $kafe->id,
            'title' => 'Promo Akhir Bulan',
            'description' => 'Sudah berakhir.',
            'start_date' => now()->subDays(30),
            'end_date' => now()->subDays(15),
        ]);
        Promo::create([
            'microsite_id' => $restoran->id,
            'title' => 'Paket Keluarga Hemat',
            'description' => 'Diskon paket keluarga untuk akhir pekan.',
            'start_date' => now()->subDays(7),
            'end_date' => now()->addDays(7),
        ]);

        $order1 = Order::create([
            'microsite_id' => $kafe->id,
            'order_code' => 'KAFE-001',
            'customer_name' => 'Budi Santoso',
            'table_number' => '3',
            'notes' => 'Gula dipisah ya',
            'status' => 'baru',
            'total_price' => 33000,
        ]);
        OrderItem::create([
            'order_id' => $order1->id,
            'microsite_id' => $kafe->id,
            'item_name' => 'Kopi Susu',
            'unit_price' => 18000,
            'quantity' => 1,
        ]);
        OrderItem::create([
            'order_id' => $order1->id,
            'microsite_id' => $kafe->id,
            'item_name' => 'Kentang Goreng',
            'unit_price' => 15000,
            'quantity' => 1,
        ]);

        $order2 = Order::create([
            'microsite_id' => $kafe->id,
            'order_code' => 'KAFE-002',
            'customer_name' => 'Siti Rahma',
            'customer_phone' => '08123456789',
            'table_number' => '5',
            'notes' => '',
            'status' => 'diproses',
            'total_price' => 36000,
        ]);
        OrderItem::create([
            'order_id' => $order2->id,
            'microsite_id' => $kafe->id,
            'item_name' => 'Kopi Susu',
            'unit_price' => 18000,
            'quantity' => 2,
        ]);
    }
}
