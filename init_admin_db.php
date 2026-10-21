<?php
$migrationsDir = "database/migrations/";
$seedersDir = "database/seeders/";

if (!is_dir($migrationsDir)) mkdir($migrationsDir, 0755, true);
if (!is_dir($seedersDir)) mkdir($seedersDir, 0755, true);

// 1. BUAT FILE SEEDER DENGAN DATA DUMMY RESTORAN & KAFE
$seederContent = <<<EOT
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
        \$kafe = Microsite::create(['name' => 'Kafe Contoh', 'slug' => 'kafe', 'settings' => json_encode(['color' => '#8B5E3C', 'open_hours' => '08.00 - 22.00'])]);
        \$restoran = Microsite::create(['name' => 'Restoran Contoh', 'slug' => 'restoran', 'settings' => json_encode(['color' => '#B23A48', 'open_hours' => '10.00 - 21.00'])]);
        
        Admin::create(['name' => 'Super Admin', 'username' => 'superadmin', 'password' => bcrypt('password123'), 'role' => 'super_admin']);
        \$adminKafe = Admin::create(['name' => 'Admin Kafe', 'username' => 'admin_kafe', 'password' => bcrypt('password123'), 'role' => 'admin']);
        \$adminKafe->microsites()->attach(\$kafe->id);
        \$adminRestoran = Admin::create(['name' => 'Admin Restoran', 'username' => 'admin_restoran', 'password' => bcrypt('password123'), 'role' => 'admin']);
        \$adminRestoran->microsites()->attach(\$restoran->id);
        
        \$minuman = Category::create(['microsite_id' => \$kafe->id, 'name' => 'Minuman', 'sort_order' => 1]);
        \$camilan = Category::create(['microsite_id' => \$kafe->id, 'name' => 'Camilan', 'sort_order' => 2]);
        MenuItem::create(['microsite_id' => \$kafe->id, 'category_id' => \$minuman->id, 'name' => 'Kopi Susu', 'price' => 18000]);
        MenuItem::create(['microsite_id' => \$kafe->id, 'category_id' => \$camilan->id, 'name' => 'Kentang Goreng', 'price' => 15000]);
        
        \$utama = Category::create(['microsite_id' => \$restoran->id, 'name' => 'Makanan Utama', 'sort_order' => 1]);
        \$paket = Category::create(['microsite_id' => \$restoran->id, 'name' => 'Paket Keluarga', 'sort_order' => 2]);
        MenuItem::create(['microsite_id' => \$restoran->id, 'category_id' => \$utama->id, 'name' => 'Nasi Goreng Spesial', 'price' => 28000]);
        MenuItem::create(['microsite_id' => \$restoran->id, 'category_id' => \$paket->id, 'name' => 'Paket Keluarga 4 Orang', 'price' => 120000]);
        
        Gallery::create(['microsite_id' => \$kafe->id, 'image' => 'gallery/kafe-1.jpg', 'caption' => 'Suasana kafe']);
        Promo::create(['microsite_id' => \$kafe->id, 'title' => 'Diskon 20%', 'description' => 'Diskon kopi', 'start_date' => now()->subDays(7), 'end_date' => now()->addDays(7)]);
        
        \$order1 = Order::create(['microsite_id' => \$kafe->id, 'order_code' => 'KAFE-001', 'customer_name' => 'Budi Santoso', 'table_number' => '3', 'notes' => 'Gula dipisah', 'status' => 'baru', 'total_price' => 33000]);
        OrderItem::create(['order_id' => \$order1->id, 'microsite_id' => \$kafe->id, 'item_name' => 'Kopi Susu', 'unit_price' => 18000, 'quantity' => 1]);
        OrderItem::create(['order_id' => \$order1->id, 'microsite_id' => \$kafe->id, 'item_name' => 'Kentang Goreng', 'unit_price' => 15000, 'quantity' => 1]);
    }
}
EOT;
file_put_contents($seedersDir . "DatabaseSeeder.php", $seederContent);

// 2. BUAT FILE MIGRATION LENGKAP UNTUK SEMUA TABEL
$migContent = <<<EOT
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('microsites', function (Blueprint \$table) {
            \$table->id(); \$table->string('name'); \$table->string('slug')->unique();
            \$table->string('domain')->nullable(); \$table->boolean('is_active')->default(true);
            \$table->json('settings')->nullable(); \$table->timestamps();
        });

        Schema::create('admins', function (Blueprint \$table) {
            \$table->id(); \$table->string('name'); \$table->string('username')->unique();
            \$table->string('password'); \$table->enum('role', ['super_admin', 'admin'])->default('admin');
            \$table->rememberToken(); \$table->timestamps();
        });

        Schema::create('admin_microsite', function (Blueprint \$table) {
            \$table->foreignId('admin_id')->constrained('admins')->cascadeOnDelete();
            \$table->foreignId('microsite_id')->constrained()->cascadeOnDelete();
            \$table->primary(['admin_id', 'microsite_id']);
        });

        Schema::create('categories', function (Blueprint \$table) {
            \$table->id(); \$table->foreignId('microsite_id')->constrained()->cascadeOnDelete();
            \$table->string('name'); \$table->unsignedInteger('sort_order')->default(0); \$table->timestamps();
        });

        Schema::create('menu_items', function (Blueprint \$table) {
            \$table->id(); \$table->foreignId('microsite_id')->constrained()->cascadeOnDelete();
            \$table->foreignId('category_id')->constrained()->cascadeOnDelete();
            \$table->string('name'); \$table->text('description')->nullable();
            \$table->unsignedInteger('price'); \$table->string('image')->nullable();
            \$table->boolean('is_available')->default(true); \$table->timestamps();
        });

        Schema::create('galleries', function (Blueprint \$table) {
            \$table->id(); \$table->foreignId('microsite_id')->constrained()->cascadeOnDelete();
            \$table->string('image'); \$table->string('caption')->nullable(); \$table->timestamps();
        });

        Schema::create('promos', function (Blueprint \$table) {
            \$table->id(); \$table->foreignId('microsite_id')->constrained()->cascadeOnDelete();
            \$table->string('title'); \$table->text('description')->nullable();
            \$table->date('start_date'); \$table->date('end_date'); \$table->timestamps();
        });

        Schema::create('orders', function (Blueprint \$table) {
            \$table->id(); \$table->foreignId('microsite_id')->constrained()->cascadeOnDelete();
            \$table->string('order_code')->unique(); \$table->string('customer_name');
            \$table->string('customer_phone')->nullable(); \$table->string('table_number')->nullable();
            \$table->text('notes')->nullable();
            \$table->enum('status', ['baru', 'diproses', 'siap', 'selesai', 'dibatalkan'])->default('baru');
            \$table->unsignedInteger('total_price'); \$table->timestamps();
        });

        Schema::create('order_items', function (Blueprint \$table) {
            \$table->id(); \$table->foreignId('order_id')->constrained()->cascadeOnDelete();
            \$table->foreignId('microsite_id')->constrained()->cascadeOnDelete();
            \$table->foreignId('menu_item_id')->nullable()->constrained('menu_items')->nullOnDelete();
            \$table->string('item_name'); \$table->unsignedInteger('unit_price');
            \$table->unsignedInteger('quantity'); \$table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('promos');
        Schema::dropIfExists('galleries');
        Schema::dropIfExists('menu_items');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('admin_microsite');
        Schema::dropIfExists('admins');
        Schema::dropIfExists('microsites');
    }
};
EOT;

// Hapus sisa-sisa migration agar bersih
\$files = glob(\$migrationsDir . "*_create_restaurant_tables.php");
foreach (\$files as \$file) unlink(\$file);

file_put_contents(\$migrationsDir . date('Y_m_d_His') . "_create_restaurant_tables.php", \$migContent);

echo "? Berhasil! File Migration lengkap dan Seeder restoran telah ditambahkan ke Panel Admin.\n";
unlink(__FILE__);
