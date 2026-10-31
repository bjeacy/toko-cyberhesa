# AGENTS.md - Coding Guidelines & Project Context

## Project Overview
- **Project Name:** CyberRig Inventory (Sistem Manajemen Inventaris & Kategori Toko Komputer)
- **Purpose:** Proyek UTS Pemrograman Web Tingkat Mahir (PG184)
- **Framework:** Laravel (MVC Architecture)
- **Database:** MySQL (`db_inventaris_pc`)
- **Frontend:** Laravel Blade Templating + Tailwind CSS (via CDN untuk kemudahan setup tanpa Vite build)

## Strict Academic Rubric Constraints (MUST FOLLOW)
Setiap kode yang di-generate atau dimodifikasi oleh Agent **WAJIB** mematuhi aturan penilaian berikut:

1. **Database & Eloquent Relationship (Bobot 20%):**
   - Menggunakan 2 tabel berelasi *One-to-Many*: `categories` (Parent) dan `items` (Child).
   - Migration pada tabel `items` wajib menggunakan `foreignId('category_id')->constrained('categories')->onDelete('cascade')`.
   - Data awal wajib disediakan di `database/seeders/DatabaseSeeder.php`.
   - **CRITICAL:** Setiap query pemanggilan relasi di Controller **WAJIB** menggunakan teknik **Eager Loading** (`with('items')`, `withCount('items')`, atau `with('category')`). Dilarang memanggil relasi secara *lazy loading* di dalam looping Blade.

2. **Blade Modularity & UI/UX (Bobot 15%):**
   - Wajib menggunakan *Template Inheritance*:
     - Master layout di `resources/views/layouts/app.blade.php` menggunakan `@yield('content')`.
     - Child views menggunakan `@extends('layouts.app')` dan `@section('content')`.
   - Wajib menggunakan komponen modular `@include('partials.navbar')` untuk navigasi.
   - Gunakan Tailwind CSS via CDN di `<head>` master layout agar proyek langsung berjalan dengan `php artisan serve` tanpa perlu menjalankan `npm run dev`.

3. **Master-Detail Views (Bobot 20%):**
   - **Index Kategori (`categories.index`):** Menampilkan kartu/tabel daftar kategori beserta ringkasan relasinya (jumlah jenis item & total stok per kategori).
   - **Detail Kategori (`categories.show`):** Menampilkan informasi lengkap 1 kategori beserta tabel daftar seluruh barang (`items`) yang terhubung dengan kategori tersebut.

4. **Interactive Form Entry (Bobot 15%):**
   - **Form Tambah Barang (`items.create` & `items.store`):** Wajib menggunakan method `POST`, direktif `@csrf`, dan validasi input di `ItemController`.
   - Pilihan kategori pada form wajib menggunakan elemen `<select name="category_id">` (Dropdown) yang datanya di-looping dari tabel `categories`.
   - Tampilkan pesan error validasi (`@error`) dan flash message sukses (`session('success')`).

## File Structure Target
- `app/Models/Category.php` (`hasMany` ke `Item`)
- `app/Models/Item.php` (`belongsTo` ke `Category`)
- `app/Http/Controllers/CategoryController.php` (`index`, `show`)
- `app/Http/Controllers/ItemController.php` (`index`, `create`, `store`)
- `resources/views/layouts/app.blade.php`
- `resources/views/partials/navbar.blade.php`
- `resources/views/categories/index.blade.php`
- `resources/views/categories/show.blade.php`
- `resources/views/items/index.blade.php`
- `resources/views/items/create.blade.php`

## Coding Conventions

## Implementasi Aktual (status per selesai)

Semua berkas di "File Structure Target" sudah dibuat dan berfungsi. Ringkasan perilaku nyata:

| Berkas | Isi |
| --- | --- |
| `app/Models/Category.php` | `hasMany(Item::class)`, `$fillable = ['nama_kategori','kode_rak','deskripsi']` |
| `app/Models/Item.php` | `belongsTo(Category::class)`, `$fillable` 6 kolom, cast integer untuk `stok` dan `harga` |
| `app/Http/Controllers/CategoryController.php` | `index` → `Category::with('items')->withCount('items')->get()`; `show` → `Category::with('items')->findOrFail($id)` |
| `app/Http/Controllers/ItemController.php` | `index` → `Item::with('category')->latest()->get()`; `create` → `Category::all()`; `store` → validasi lalu redirect ke `categories.show` dengan flash `success` |
| `database/seeders/DatabaseSeeder.php` | 4 kategori (Processor, VGA/GPU, RAM & Storage, Gaming Gear) dan 10 item nyata |
| `routes/web.php` | 5 route sesuai rubrik, tanpa auth |

Catatan teknis:
- `ItemController@store` memvalidasi `category_id` dengan `exists:categories,id` dan menolak `kode_sku` duplikat lewat `unique:items,kode_sku`.
- Query relasi di controller semuanya eager loading. Di tabel Blade, akses `$item->category->...` dan `$category->items` aman karena relasi sudah dimuat.
- `deskripsi` boleh null; view menampilkan teks pengganti bila kosong.
- Badge "Stok Menipis" muncul bila `stok <= 5`, pada `categories.show`.
- Harga selalu ditampilkan dengan `'Rp ' . number_format($item->harga, 0, ',', '.')`.

## Macam Database

Proyek ini aktif memakai **MySQL/MariaDB**. Konfigurasi `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_inventaris_pc
DB_USERNAME=root
DB_PASSWORD=
```

Database `db_inventaris_pc` dibuat dengan `CREATE DATABASE IF NOT EXISTS db_inventaris_pc CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;` (bisa lewat PDO PHP bila `mysql` CLI tidak ada di `PATH`). Setelah mengubah konfigurasi, jalankan `php artisan config:clear` lalu `php artisan migrate:fresh --seed`.

Migration memakai `foreignId('category_id')->constrained('categories')->onDelete('cascade')`, jadi kunci asing asli terbentuk di MySQL. Semua tabel InnoDB + `utf8mb4_unicode_ci`. Catatan: perintah `php artisan db:show` gagal di MariaDB/XAMPP karena query statistiknya menyentuh `performance_schema.session_status` yang tidak tersedia — ini keterbatasan tool bawaan Laravel, bukan masalah koneksi. Gunakan `php artisan tinker` atau phpMyAdmin untuk memeriksa data.