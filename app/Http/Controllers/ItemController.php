<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ItemController extends Controller
{
    /**
     * Daftar seluruh barang dari semua kategori.
     */
    public function index(): View
    {
        $items = Item::with('category')->latest()->get();

        return view('items.index', compact('items'));
    }

    /**
     * Form tambah barang baru.
     */
    public function create(): View
    {
        $categories = Category::all();

        return view('items.create', compact('categories'));
    }

    /**
     * Simpan barang baru lalu kembali ke detail kategorinya.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'kode_sku' => ['required', 'string', 'max:255', 'unique:items,kode_sku'],
            'nama_barang' => ['required', 'string', 'max:255'],
            'merk' => ['required', 'string', 'max:255'],
            'stok' => ['required', 'integer', 'min:0'],
            'harga' => ['required', 'integer', 'min:0'],
        ]);

        Item::create($validated);

        return redirect()
            ->route('categories.show', $validated['category_id'])
            ->with('success', 'Barang "' . $validated['nama_barang'] . '" berhasil ditambahkan.');
    }
}
