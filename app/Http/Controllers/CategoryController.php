<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\View\View;

class CategoryController extends Controller
{
    /**
     * Daftar kategori beserta ringkasan relasinya.
     */
    public function index(): View
    {
        $categories = Category::with('items')->withCount('items')->get();

        return view('categories.index', compact('categories'));
    }

    /**
     * Detail satu kategori beserta seluruh barangnya.
     */
    public function show(string $id): View
    {
        $category = Category::with('items')->findOrFail($id);

        return view('categories.show', compact('category'));
    }
}
