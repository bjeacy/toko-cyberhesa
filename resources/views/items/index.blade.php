@extends('layouts.app')

@section('title', 'Semua Barang - CyberRig Inventory')
@section('heading', 'Daftar Seluruh Barang')
@section('subheading', 'Semua barang dari seluruh kategori, diurutkan dari yang terbaru.')

@section('content')
    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
        <table class="min-w-full divide-y divide-slate-200 text-sm">
            <thead class="bg-slate-50 text-left text-xs uppercase tracking-wide text-slate-500">
                <tr>
                    <th class="px-4 py-3">Kode SKU</th>
                    <th class="px-4 py-3">Nama Barang</th>
                    <th class="px-4 py-3">Kategori / Rak</th>
                    <th class="px-4 py-3">Merk</th>
                    <th class="px-4 py-3">Stok</th>
                    <th class="px-4 py-3">Harga</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($items as $item)
                    <tr class="hover:bg-slate-50">
                        <td class="px-4 py-3 font-mono text-xs text-slate-500">{{ $item->kode_sku }}</td>
                        <td class="px-4 py-3 font-medium text-slate-900">{{ $item->nama_barang }}</td>
                        <td class="px-4 py-3 text-slate-600">
                            <a href="{{ route('categories.show', $item->category->id) }}" class="text-brand-700 hover:underline">
                                {{ $item->category->nama_kategori }}
                            </a>
                            <span class="ml-1 rounded bg-slate-100 px-2 py-0.5 text-xs text-slate-500">{{ $item->category->kode_rak }}</span>
                        </td>
                        <td class="px-4 py-3 text-slate-600">{{ $item->merk }}</td>
                        <td class="px-4 py-3 font-semibold text-slate-900">{{ $item->stok }}</td>
                        <td class="px-4 py-3 font-semibold text-slate-900">{{ 'Rp ' . number_format($item->harga, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-6 text-center text-slate-500">
                            Belum ada barang pada database.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
