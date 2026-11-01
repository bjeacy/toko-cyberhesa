<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Sidebar menu diambil dari database agar tidak ada ID kategori yang di-hardcode.
        // Hasilnya di-cache per-request supaya tidak query berulang di satu halaman.
        View::composer('partials.navbar', function ($view) {
            $view->with('navCategories', Category::withCount('items')->orderBy('kode_rak')->get());
        });
    }
}
