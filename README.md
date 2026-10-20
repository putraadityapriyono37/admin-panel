# Admin Panel - Sistem Microsite Restoran

Repository ini merupakan **Panel Admin Terpusat** untuk sistem microsite restoran multi-repository berbasis Laravel. Repo ini memegang seluruh **skema database (migrations)** dan **data awal (seeders)** yang digunakan bersama oleh **Microsite A (Kafe)** dan **Microsite B (Restoran Keluarga)**.

---

## 🛠️ Arsitektur Sistem

```
[Microsite A (Kafe)]      ── baca & tulis orders ──┐
                                                  ▼
                                          [ Database Bersama ] ◄── baca/tulis ── [Panel Admin]
                                                  ▲
[Microsite B (Restoran)]   ── hanya baca ─────────┘
```

- **Nama Database Lokal Bersama**: `microsite_db`
- **Versi Lingkungan**: PHP >= 8.3 & MySQL / MariaDB (Laragon / XAMPP)

---

## 🚀 Panduan Setup Lokal (Untuk Angga & Naufal)

Setiap anggota tim menjalankan database lokal masing-masing dengan nama dan skema yang sama melalui migration & seeder dari repo ini:

### 1. Clone Repository & Install Dependency
```bash
git clone <url-repo-admin-panel>
cd admin-panel
composer install
npm install && npm run build
```

### 2. Konfigurasi Environment (`.env`)
Salin file `.env.example`:
```bash
cp .env.example .env
php artisan key:generate
```
Pastikan konfigurasi database di file `.env` mengarah ke database lokal Anda:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=microsite_db
DB_USERNAME=root
DB_PASSWORD=

# Session cookie unik agar tidak saling menimpa session saat dijalankan di localhost bersamaan
SESSION_COOKIE=admin_panel_session
CACHE_PREFIX=admin_panel_cache
```

### 3. Buat Database & Jalankan Migration + Seeder
Buat database bernama `microsite_db` di MySQL Anda (misal via HeidiSQL / phpMyAdmin), lalu jalankan:
```bash
php artisan migrate --seed
php artisan storage:link
```

### 4. Jalankan Aplikasi
```bash
php artisan serve
```
Akses di browser: `http://localhost:8000` (akan diarahkan ke `/admin/login`).

---

## 🔑 Akun Login Default (Dari Seeder)

| Peran | Username | Password | Keterangan Akses |
|---|---|---|---|
| **Super Admin** | `superadmin` | `password123` | Mengelola semua microsite, akun admin, dan seluruh data |
| **Admin Kafe** | `admin_kafe` | `password123` | Dashboard Kafe (`/admin/m/kafe`): Kategori, Menu, Pesanan |
| **Admin Restoran** | `admin_restoran` | `password123` | Dashboard Restoran (`/admin/m/restoran`): Kategori, Menu |

---

## 📌 Catatan Integrasi untuk Microsite A & B

1. **Akses Database**:
   - Model di Microsite A dan Microsite B langsung mengarah ke tabel yang sudah dibuat oleh `admin-panel`.
   - **Microsite B** hanya membaca data (SELECT).
   - **Microsite A** membaca data serta menulis ke tabel `orders` dan `order_items`.
2. **Identitas Microsite**:
   - Di `.env` masing-masing microsite, tambahkan:
     - Microsite A: `MICROSITE_SLUG=kafe`
     - Microsite B: `MICROSITE_SLUG=restoran`
3. **Session Cookie**:
   - Microsite A: `SESSION_COOKIE=microsite_a_session`
   - Microsite B: `SESSION_COOKIE=microsite_b_session`
4. **Media / Gambar Menu**:
   - File gambar menu diunggah ke `public/storage/menu/`.
   - Microsite dapat menampilkan gambar melalui URL storage admin (misal: `http://localhost:8000/storage/...`).

---

## 🧪 Menjalankan Pengujian Otomatis (Tests)

```bash
php artisan test
```
Seluruh skenario isolasi data, otorisasi peran, scoping route model binding, dan manajemen pesanan dicakup dalam pengujian fitur.
