@extends('layouts.app')

@section('title', $category->nama_kategori . ' - CyberRig Inventory')
@section('heading', 'Detail Kategori: ' . $category->nama_kategori)
@section('subheading', 'Daftar seluruh barang yang tersimpan pada kategori ini.')

@section('content')
    <section class="mb-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="grid gap-4 sm:grid-cols-3">
            <div>
                <p class="text-xs uppercase tracking-wide text-slate-400">Nama Kategori</p>
                <p class="font-semibold text-slate-900">{{ $category->nama_kategori }}</p>
            </div>
            <div>
                <p class="text-xs uppercase tracking-wide text-slate-400">Kode Rak</p>
                <p class="font-semibold text-slate-900">{{ $category->kode_rak }}</p>
            </div>
            <div>
                <p class="text-xs uppercase tracking-wide text-slate-400">Jenis Barang</p>
                <p class="font-semibold text-slate-900">{{ $category->items->count() }} jenis ({{ $category->items->sum('stok') }} unit)</p>
            </div>
            <div class="sm:col-span-3">
                <p class="text-xs uppercase tracking-wide text-slate-400">Deskripsi</p>
                <p class="text-sm text-slate-700">{{ $category->deskripsi ?? 'Belum ada deskripsi untuk kategori ini.' }}</p>
            </div>
        </div>

        <div class="mt-6 flex flex-wrap gap-3">
            <a href="{{ route('items.create', ['category_id' => $category->id]) }}"
               class="rounded-md bg-brand-600 px-4 py-2 text-sm font-semibold text-white hover:bg-brand-700">
                + Tambah Barang ke Kategori Ini
            </a>
            <a href="{{ route('categories.index') }}"
               class="rounded-md border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100">
                &larr; Kembali ke Daftar Kategori
            </a>
        </div>
    </section>

    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
        <table class="min-w-full divide-y divide-slate-200 text-sm">
            <thead class="bg-slate-50 text-left text-xs uppercase tracking-wide text-slate-500">
                <tr>
                    <th class="px-4 py-3">Kode SKU</th>
                    <th class="px-4 py-3">Nama Barang</th>
                    <th class="px-4 py-3">Merk</th>
                    <th class="px-4 py-3">Stok</th>
                    <th class="px-4 py-3">Harga</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($category->items as $item)
                    <tr class="hover:bg-slate-50">
                        <td class="px-4 py-3 font-mono text-xs text-slate-500">{{ $item->kode_sku }}</td>
                        <td class="px-4 py-3 font-medium text-slate-900">{{ $item->nama_barang }}</td>
                        <td class="px-4 py-3 text-slate-600">{{ $item->merk }}</td>
                        <td class="px-4 py-3">
                            <span class="font-semibold text-slate-900">{{ $item->stok }}</span>
                            @if ($item->stok <= 5)
                                <span class="ml-2 rounded-full bg-amber-100 px-2 py-0.5 text-xs font-semibold text-amber-800">
                                    Stok Menipis
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-3 font-semibold text-slate-900">{{ 'Rp ' . number_format($item->harga, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-6 text-center text-slate-500">
                            Kategori ini belum memiliki barang.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
