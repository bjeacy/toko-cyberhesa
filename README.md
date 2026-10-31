# cyberhesa Inventory

Sistem Manajemen Inventaris & Kategori Toko Komputer. Proyek UTS Pemrograman Web Tingkat Mahir (PG184), dibangun dengan Laravel (MVC), Eloquent ORM relasi One-to-Many, Blade Templating, dan Tailwind CSS via Play CDN.

## Menjalankan Aplikasi

```bash
composer install
copy .env.example .env        # jika .env belum ada
php artisan key:generate

# buat database MySQL (sekali saja)
# mysql -u root -e "CREATE DATABASE IF NOT EXISTS db_inventaris_pc CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci"

php artisan config:clear
php artisan migrate:fresh --seed
php artisan serve
```

Buka `http://127.0.0.1:8000`. Tidak perlu `npm install` atau `npm run dev` — Tailwind dimuat dari CDN. Pastikan MySQL/MariaDB aktif di `127.0.0.1:3306` sebelum migrate.

## Halaman

| Method | URI | Controller | Name |
| --- | --- | --- | --- |
| GET | `/` | `CategoryController@index` | `categories.index` |
| GET | `/categories/{id}` | `CategoryController@show` | `categories.show` |
| GET | `/items` | `ItemController@index` | `items.index` |
| GET | `/items/create` | `ItemController@create` | `items.create` |
| POST | `/items` | `ItemController@store` | `items.store` |

## Skema Database & Relasi (One-to-Many)

**Tabel induk `categories`** — `hasMany(Item::class)`

| Kolom | Tipe |
| --- | --- |
| `id` | PK |
| `nama_kategori` | string |
| `kode_rak` | string |
| `deskripsi` | text, nullable |
| `timestamps` | |

**Tabel anak `items`** — `belongsTo(Category::class)`

| Kolom | Tipe |
| --- | --- |
| `id` | PK |
| `category_id` | `foreignId()->constrained('categories')->onDelete('cascade')` |
| `kode_sku` | string, unique |
| `nama_barang` | string |
| `merk` | string |
| `stok` | integer |
| `harga` | bigInteger |
| `timestamps` | |

### Driver database

Proyek ini memakai **MySQL/MariaDB** sesuai spesifikasi rubrik. Konfigurasi aktif di `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_inventaris_pc
DB_USERNAME=root
DB_PASSWORD=
```

Database `db_inventaris_pc` dibuat dengan:

```sql
CREATE DATABASE IF NOT EXISTS db_inventaris_pc
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Atau setara lewat PDO PHP bila `mysql` CLI tidak ada di `PATH`:

```php
new PDO('mysql:host=127.0.0.1;port=3306', 'root', '')
    ->exec('CREATE DATABASE IF NOT EXISTS db_inventaris_pc CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
```

Setelah konfigurasi berubah, jalankan:

```bash
php artisan config:clear
php artisan migrate:fresh --seed
```

Semua tabel memakai engine InnoDB dengan collation `utf8mb4_unicode_ci`. Kunci asing `items.category_id -> categories.id ON DELETE CASCADE` aktif, terbukti saat diuji: menghapus satu kategori ikut menghapus baris `items` miliknya.

Jika perlu kembali ke SQLite untuk portabilitas, set `DB_CONNECTION=sqlite` dan migration tetap berjalan tanpa perubahan.

## Struktur Berkas

```
app/
  Http/Controllers/CategoryController.php   # index, show
  Http/Controllers/ItemController.php       # index, create, store
  Models/Category.php                       # hasMany Item
  Models/Item.php                           # belongsTo Category

database/
  migrations/2026_01_01_000001_create_categories_table.php
  migrations/2026_01_01_000002_create_items_table.php
  seeders/DatabaseSeeder.php                # 4 kategori, 10 item

resources/views/
  layouts/app.blade.php                     # master layout, Tailwind CDN, flash message
  partials/navbar.blade.php                 # navigasi modular
  categories/index.blade.php                # grid kartu kategori
  categories/show.blade.php                 # detail + tabel barang
  items/index.blade.php                     # tabel semua barang
  items/create.blade.php                    # form tambah barang

routes/web.php
```

## Data Awal (Seeder)

4 kategori, 10 item komponen PC nyata:

| Kategori | Kode Rak | Jenis Barang | Total Stok |
| --- | --- | --- | --- |
| Processor | RAK-A1 | 2 | 19 |
| VGA/GPU | RAK-B2 | 2 | 8 |
| RAM & Storage | RAK-C3 | 3 | 43 |
| Gaming Gear | RAK-D4 | 3 | 40 |

Total 4 baris di `categories` dan 10 baris di `items`. Data bisa diperiksa di phpMyAdmin pada database `db_inventaris_pc`.

## Catatan Pemenuhan Rubrik

1. **Database & Eloquent (20%):** relasi One-to-Many `Category hasMany Item`, foreign key cascade, data awal dari `DatabaseSeeder`. Eager loading dipakai di semua query controller — `Category::with('items')->withCount('items')->get()`, `Category::with('items')->findOrFail($id)`, `Item::with('category')->latest()->get()`. Tidak ada lazy loading di dalam loop Blade.
2. **Blade Modularity & UI/UX (15%):** `@extends`/`@section`/`@yield` pada master layout, `@include('partials.navbar')` untuk navigasi, Tailwind Play CDN tanpa build step.
3. **Master-Detail Views (20%):** `categories.index` menampilkan `items_count` dan `$category->items->sum('stok')`; `categories.show` menampilkan detail kategori plus tabel barang lengkap dengan badge stok menipis dan harga format Rupiah.
4. **Interactive Form Entry (15%):** `@csrf`, validasi server-side di `ItemController@store`, `@error` di setiap field, dropdown `<select name="category_id">` dinamis yang otomatis terpilih bila URL membawa `?category_id=`, dan flash message `session('success')` setelah simpan.
