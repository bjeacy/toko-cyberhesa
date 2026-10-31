# CLAUDE.md

This file provides guidance to Claude Code / AI Coding Assistants when working with code in this repository.

## Project Context
- **Application:** CyberRig Inventory (Sistem Manajemen Inventaris & Kategori Toko Komputer)
- **Objective:** Proyek UTS Pemrograman Web Tingkat Mahir (PG184)
- **Stack:** Laravel, Eloquent ORM, Blade Templating, Tailwind CSS via CDN.
- **Database:** MySQL/MariaDB, database `db_inventaris_pc` (`127.0.0.1:3306`, user `root`, tanpa password). Semua tabel InnoDB, collation `utf8mb4_unicode_ci`. Konfigurasi ada di `.env` dan sudah aktif. Migration memakai `->constrained()->onDelete('cascade')` sehingga kunci asing benar-benar terbentuk di MySQL.

## Common Commands
- **Run Local Server:** `php artisan serve`
- **Reset DB & Run Seeders:** `php artisan migrate:fresh --seed`
- **Check Routes:** `php artisan route:list`
- **Clear Views/Cache:** `php artisan optimize:clear`

## Architecture & Mandatory Grading Rules
1. **Eloquent Relationships & Eager Loading (CRITICAL - 20%):**
   - `Category` (`categories` table) `hasMany` `Item` (`items` table).
   - `Item` `belongsTo` `Category` via `category_id` foreign key (`constrained('categories')->onDelete('cascade')`).
   - **Rule:** Always use Eager Loading (`with('items')`, `withCount('items')`, or `with('category')`) in Controllers. Never trigger N+1 lazy loading inside Blade loops.
   - Database must be populated initially via `DatabaseSeeder.php`.

2. **Blade Modularity & Styling (15%):**
   - Master layout: `resources/views/layouts/app.blade.php` using `@yield('content')`.
   - Child views must use `@extends('layouts.app')` and `@section('content')`.
   - Navigation bar must be modularized in `resources/views/partials/navbar.blade.php` and loaded via `@include('partials.navbar')`.
   - Styling uses **Tailwind CSS Play CDN** (`<script src="https://cdn.tailwindcss.com"></script>`) inside `layouts/app.blade.php` so no Node/Vite build step is required during live demo.

3. **Master-Detail Views (20%):**
   - `GET /` (`CategoryController@index`): Displays all categories with item count (`items_count`) and total unit stock (`$category->items->sum('stok')`).
   - `GET /categories/{id}` (`CategoryController@show`): Displays a single category's details along with a complete table of its related `items`.

4. **Interactive Form Entry (15%):**
   - `GET /items/create` & `POST /items` (`ItemController@create` & `store`): Form to add a new PC component.
   - Must include `@csrf`, server-side validation, error display (`@error`), and a dynamic `<select name="category_id">` dropdown populated from `Category::all()`.

5. **Implementasi Saat Ini (berkas yang ada):**
   - Controller: `app/Http/Controllers/CategoryController.php` (`index`, `show`), `app/Http/Controllers/ItemController.php` (`index`, `create`, `store`).
   - Model: `app/Models/Category.php`, `app/Models/Item.php`.
   - View: `layouts/app.blade.php`, `partials/navbar.blade.php`, `categories/index.blade.php`, `categories/show.blade.php`, `items/index.blade.php`, `items/create.blade.php`.
   - Seeder: `DatabaseSeeder.php` membuat 4 kategori dan 10 item.
   - `ItemController@store` me-redirect ke `categories.show` milik kategori barang yang baru disimpan, membawa flash `success`.

## Scope Boundaries
- Keep the codebase lightweight and strictly focused on the rubric (Master-Detail Read & Interactive Create).
- Do not add authentication (Breeze/Jetstream/Fortify), npm build pipelines, or complex JS frameworks.
- All UI labels, validation messages, and flash notifications must be in **Bahasa Indonesia**.