@extends('layouts.app')

@section('title', $category->nama_kategori . ' - cyberhesa')
@section('header_title', 'Detail Rak')
@section('header_subtitle', 'Rincian komponen, sebaran stok, dan nilai aset pada rak kategori ini')

@section('content')
    @php
        $totalSku = $category->items->count();
        $totalUnit = $category->items->sum('stok');
        $nilaiAset = $category->items->sum(fn ($i) => $i->stok * $i->harga);
        $stokMenipis = $category->items->filter(fn ($i) => $i->stok <= 5)->count();
    @endphp

    {{-- Breadcrumb --}}
    <nav class="mb-6 flex items-center gap-2 text-xs" aria-label="Breadcrumb">
        <a href="{{ route('categories.index') }}" class="text-slate-500 hover:text-[#0d47a1] transition-all duration-200">Overview</a>
        <span class="text-slate-400">/</span>
        <span class="text-slate-500">Rak</span>
        <span class="text-slate-400">/</span>
        <span class="text-[#0d47a1] font-medium">{{ $category->nama_kategori }}</span>
    </nav>

    {{-- 3 Kartu Ringkasan. Gaya seragam dengan dashboard: rata kiri, ikon pojok kanan, font sans tabular. --}}
    <section class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">

        {{-- Kartu 1: Identitas rak --}}
        <div class="relative overflow-hidden bg-white border border-blue-100/80 rounded-2xl shadow-sm p-6 text-left transition-all duration-200 hover:-translate-y-0.5 hover:shadow-md">
            <span class="absolute top-6 right-6 w-11 h-11 rounded-xl flex items-center justify-center bg-indigo-50 text-indigo-600">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"
                     stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <rect x="3" y="4" width="18" height="6" rx="2"/>
                    <rect x="3" y="14" width="18" height="6" rx="2"/>
                    <path d="M7 7h.01M7 17h.01"/>
                </svg>
            </span>
            <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Kode Rak</p>
            <p class="text-xl sm:text-2xl font-sans font-extrabold tracking-tight tabular-nums text-blue-950 mt-2 uppercase">
                {{ $category->kode_rak }}
            </p>
            <p class="text-xs text-slate-500 mt-3 flex items-start gap-1.5">
                <svg class="h-3.5 w-3.5 shrink-0 mt-0.5" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8"
                     stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <circle cx="10" cy="10" r="7"/>
                    <path d="M10 6.5v7M8 8.5h3.2a1.4 1.4 0 0 1 0 2.8H8.8a1.4 1.4 0 0 0 0 2.8H12"/>
                </svg>
                {{ $category->deskripsi ?? 'Belum ada deskripsi.' }}
            </p>
        </div>

        {{-- Kartu 2: Isi rak --}}
        <div class="relative overflow-hidden bg-white border border-blue-100/80 rounded-2xl shadow-sm p-6 text-left transition-all duration-200 hover:-translate-y-0.5 hover:shadow-md">
            <span class="absolute top-6 right-6 w-11 h-11 rounded-xl flex items-center justify-center bg-blue-50 text-[#1976d2]">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"
                     stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <rect x="2.5" y="3.5" width="19" height="7" rx="2"/>
                    <rect x="2.5" y="13.5" width="19" height="7" rx="2"/>
                    <path d="M6.5 7h.01M6.5 17h.01"/>
                </svg>
            </span>
            <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Isi Rak</p>
            <p class="text-xl sm:text-2xl font-sans font-extrabold tracking-tight tabular-nums text-blue-950 mt-2">
                {{ $totalUnit }} Unit
            </p>
            <span class="bg-blue-50 text-[#1565c0] font-semibold text-xs px-2.5 py-1 rounded-lg inline-flex items-center gap-1.5 mt-3">
                {{ $totalSku }} Jenis Komponen Terdaftar
            </span>
        </div>

        {{-- Kartu 3: Valuasi rak + aksi --}}
        <div class="relative overflow-hidden bg-white border border-blue-100/80 rounded-2xl shadow-sm p-6 text-left transition-all duration-200 hover:-translate-y-0.5 hover:shadow-md">
            <span class="absolute top-6 right-6 w-11 h-11 rounded-xl flex items-center justify-center bg-emerald-50 text-emerald-600">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"
                     stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <rect x="2.5" y="6.5" width="19" height="11" rx="2"/>
                    <circle cx="12" cy="12" r="2.6"/>
                    <path d="M6 9.5v5M18 9.5v5"/>
                </svg>
            </span>
            <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Valuasi Rak</p>
            <p class="text-xl sm:text-2xl font-sans font-extrabold tracking-tight tabular-nums text-blue-950 mt-2">
                {{ 'Rp ' . number_format($nilaiAset, 0, ',', '.') }}
            </p>
            @if ($stokMenipis > 0)
                <span class="bg-amber-50 text-amber-800 border border-amber-200/70 text-xs font-semibold px-2.5 py-1 rounded-lg inline-flex items-center gap-1.5 mt-3">
                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse" aria-hidden="true"></span>
                    {{ $stokMenipis }} SKU perlu segera restock
                </span>
            @else
                <span class="bg-emerald-50 text-emerald-800 border border-emerald-200/70 text-xs font-semibold px-2.5 py-1 rounded-lg inline-flex items-center gap-1.5 mt-3">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500" aria-hidden="true"></span>
                    Semua stok komponen aman
                </span>
            @endif
            <div class="mt-3">
                <a href="{{ route('items.create', ['category_id' => $category->id]) }}"
                   class="bg-[#2196f3] hover:bg-blue-600 active:scale-[0.98] text-white font-medium shadow-sm text-xs px-4 py-2 rounded-lg transition-all duration-200 inline-flex items-center gap-1.5">
                    <svg class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2.4"
                         stroke-linecap="round" aria-hidden="true">
                        <path d="M10 4v12M4 10h12"/>
                    </svg>
                    Tambah ke Rak Ini
                </a>
            </div>
        </div>

    </section>

    {{-- Toolbar: Search + Export --}}
    <div class="flex flex-wrap items-center justify-between gap-3 mb-4">

        <div class="relative w-full sm:w-64">
            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                <svg class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2"
                     stroke-linecap="round" aria-hidden="true">
                    <circle cx="9" cy="9" r="5.5"/>
                    <path d="M13.5 13.5L17 17"/>
                </svg>
            </span>
            <input type="search" id="table-search" autocomplete="off"
                   placeholder="Cari komponen..."
                   class="w-full bg-white border border-blue-200 text-slate-700 placeholder-slate-400 rounded-lg pl-9 pr-3 py-2 text-xs focus:border-[#2196f3] focus:outline-none focus:ring-2 focus:ring-blue-100">
        </div>

        <button type="button" id="csv-export" data-filename="stok-{{ $category->kode_rak }}"
                class="bg-white hover:bg-blue-50 active:scale-[0.98] text-[#0d47a1] border border-blue-200 font-medium text-xs px-3.5 py-2 rounded-lg transition-all duration-200 inline-flex items-center gap-1.5">
            <svg class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8"
                 stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M10 3v9"/>
                <path d="M6.5 9L10 12.5 13.5 9"/>
                <path d="M4 15.5h12"/>
            </svg>
            Unduh CSV
        </button>
    </div>

    <p class="mb-3 font-mono text-[11px] text-slate-500">
        <span id="row-count">{{ $totalSku }}</span> / {{ $totalSku }} BARIS
    </p>

    {{-- Tabel di dalam kartu putih --}}
    <div class="bg-white border border-blue-100 shadow-sm rounded-xl p-6">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse" id="komponen-table" data-table>
                <thead class="bg-blue-50/80">
                    <tr class="text-[11px] text-blue-900 font-semibold border-b border-blue-100">
                        <th scope="col" data-sort="sku" data-label="Kode SKU"
                            class="py-2.5 px-3 font-semibold cursor-pointer select-none hover:text-[#2196f3] transition-all duration-200">
                            Kode SKU <span data-arrow class="font-mono text-[9px]"></span>
                        </th>
                        <th scope="col" data-label="Merk" class="py-2.5 px-3 font-semibold">Merk</th>
                        <th scope="col" data-label="Nama Komponen" class="py-2.5 px-3 font-semibold">Nama Komponen</th>
                        <th scope="col" data-sort="stok" data-label="Stok"
                            class="py-2.5 px-3 font-semibold text-right cursor-pointer select-none hover:text-[#2196f3] transition-all duration-200">
                            Stok <span data-arrow class="font-mono text-[9px]"></span>
                        </th>
                        <th scope="col" data-sort="harga" data-label="Harga Satuan"
                            class="py-2.5 px-3 font-semibold text-right cursor-pointer select-none hover:text-[#2196f3] transition-all duration-200">
                            Harga Satuan <span data-arrow class="font-mono text-[9px]"></span>
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-blue-100 text-xs">
                    @forelse ($category->items as $item)
                        <tr class="transition-colors duration-150 hover:bg-blue-50/70" data-search-row
                            data-sortsku="{{ strtolower($item->kode_sku) }}"
                            data-sortstok="{{ $item->stok }}"
                            data-sortharga="{{ $item->harga }}">
                            <td class="py-3.5 px-3 font-mono text-slate-700 align-top">{{ $item->kode_sku }}</td>
                            <td class="py-3.5 px-3 font-mono text-[11px] uppercase text-blue-700 align-top">{{ $item->merk }}</td>
                            <td class="py-3.5 px-3 text-slate-700 align-top">{{ $item->nama_barang }}</td>
                            <td class="py-3.5 px-3 font-mono font-semibold text-right align-top {{ $item->stok <= 5 ? 'text-amber-600' : 'text-emerald-600' }}">
                                @if ($item->stok <= 5)
                                    <span class="inline-flex items-center gap-1.5 justify-end">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse" aria-hidden="true"></span>
                                        {{ $item->stok }}
                                    </span>
                                @else
                                    {{ $item->stok }}
                                @endif
                            </td>
                            <td class="py-3.5 px-3 font-mono font-semibold text-emerald-700 text-right align-top">
                                {{ 'Rp ' . number_format($item->harga, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-10 text-center text-slate-500">
                                Rak ini belum memiliki komponen.
                            </td>
                        </tr>
                    @endforelse
                    <tr id="no-result-row" class="hidden">
                        <td colspan="5" class="py-10 text-center text-slate-500">
                            Tidak ada komponen yang cocok.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
