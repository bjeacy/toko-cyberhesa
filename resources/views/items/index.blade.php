@extends('layouts.app')

@section('title', 'Data Komponen - cyberhesa')
@section('header_title', 'Data Komponen')
@section('header_subtitle', 'Katalog seluruh komponen PC dari setiap rak kategori beserta status stok terkini')

@section('content')
    @php
        $totalSku = $items->count();
        $totalUnit = $items->sum('stok');
        $nilaiAset = $items->sum(fn ($i) => $i->stok * $i->harga);
        $stokMenipis = $items->filter(fn ($i) => $i->stok <= 5)->count();

        // Warna badge per merk hardware. Merk di luar daftar pakai gaya netral.
        // Daripada 12 cabang warna, cukup 6 keluarga warna dan sisanya abu-abu.
        $warnaMerk = [
            'INTEL'    => 'bg-blue-50 text-blue-700 border-blue-200',
            'AMD'      => 'bg-orange-50 text-orange-700 border-orange-200',
            'ASUS'     => 'bg-sky-50 text-sky-800 border-sky-200',
            'SAPPHIRE' => 'bg-rose-50 text-rose-700 border-rose-200',
            'CORSAIR'  => 'bg-yellow-50 text-yellow-800 border-yellow-300',
            'LOGITECH' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
            'RAZER'    => 'bg-lime-50 text-lime-800 border-lime-300',
            'HYPERX'   => 'bg-fuchsia-50 text-fuchsia-700 border-fuchsia-200',
            'KINGSTON' => 'bg-red-50 text-red-700 border-red-200',
            'SAMSUNG'  => 'bg-indigo-50 text-indigo-700 border-indigo-200',
        ];
    @endphp

    {{-- Breadcrumb --}}
    <nav class="mb-5 flex items-center gap-2 text-xs" aria-label="Breadcrumb">
        <a href="{{ route('categories.index') }}" class="text-slate-500 hover:text-[#0d47a1] transition-all duration-200">Overview</a>
        <span class="text-slate-400">/</span>
        <span class="text-[#0d47a1] font-medium">Data Komponen</span>
    </nav>

    {{-- Strip ringkasan horizontal + aksi --}}
    <section class="bg-white border border-blue-100 shadow-sm rounded-xl px-5 py-4 mb-5">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div class="flex flex-wrap items-center gap-x-5 gap-y-2.5">
                <div>
                    <p class="text-[10px] font-mono uppercase tracking-wider text-slate-500">Total</p>
                    <p class="font-mono text-sm font-bold text-[#0d47a1]">
                        {{ $totalSku }} <span class="text-[11px] font-semibold text-slate-500">Jenis SKU</span>
                    </p>
                </div>
                <div class="hidden sm:block w-px h-8 bg-blue-100" aria-hidden="true"></div>
                <div>
                    <p class="text-[10px] font-mono uppercase tracking-wider text-slate-500">Stok Fisik</p>
                    <p class="font-mono text-sm font-bold text-[#0d47a1]">
                        {{ $totalUnit }} <span class="text-[11px] font-semibold text-slate-500">Unit</span>
                    </p>
                </div>
                <div class="hidden sm:block w-px h-8 bg-blue-100" aria-hidden="true"></div>
                <div>
                    <p class="text-[10px] font-mono uppercase tracking-wider text-slate-500">Valuasi</p>
                    <p class="font-mono text-sm font-bold text-[#0d47a1]">{{ 'Rp ' . number_format($nilaiAset, 0, ',', '.') }}</p>
                </div>
                <div class="hidden sm:block w-px h-8 bg-blue-100" aria-hidden="true"></div>
                <div>
                    <p class="text-[10px] font-mono uppercase tracking-wider text-slate-500 flex items-center gap-1.5">
                        @if ($stokMenipis > 0)
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse" aria-hidden="true"></span>
                        @endif
                        Stok Menipis
                    </p>
                    <p class="font-mono text-sm font-bold {{ $stokMenipis > 0 ? 'text-amber-600' : 'text-emerald-600' }}">
                        {{ $stokMenipis }} <span class="text-[11px] font-semibold text-slate-500">SKU</span>
                    </p>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-2">
                <button type="button" id="csv-export" data-filename="stok-semua-komponen"
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
        </div>
    </section>

    {{-- Toolbar: Search --}}
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
                   placeholder="Cari barang, SKU, merk, rak..."
                   class="w-full bg-white border border-blue-200 text-slate-700 placeholder-slate-400 rounded-lg pl-9 pr-3 py-2 text-xs focus:border-[#2196f3] focus:outline-none focus:ring-2 focus:ring-blue-100">
        </div>
    </div>

    <div class="mb-3 flex flex-wrap items-center gap-2">
        <p class="font-mono text-[11px] text-slate-500">
            <span id="row-count">{{ $totalSku }}</span> / {{ $totalSku }} BARIS
        </p>
        {{-- Penanda aktif hanya saat dibuka lewat menu "Cek Stok Menipis". --}}
        <span id="fokus-menipis" class="hidden items-center gap-2 rounded-full bg-amber-100 border border-amber-300 pl-2.5 pr-1 py-0.5 text-[11px] font-semibold text-amber-800">
            Filter Aktif: Stok Menipis
            <button type="button" id="fokus-reset" title="Tampilkan semua komponen"
                    aria-label="Matikan filter stok menipis"
                    class="flex h-4 w-4 items-center justify-center rounded-full text-amber-800/70 transition hover:bg-amber-300 hover:text-amber-900 leading-none">
                &times;
            </button>
        </span>
    </div>

    {{-- Tabel di dalam kartu putih --}}
    <div class="bg-white border border-blue-100 shadow-sm rounded-xl p-6">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse" id="inventaris-table" data-table>
                <thead class="bg-blue-50/80">
                    <tr class="text-[11px] text-blue-900 font-semibold border-b border-blue-100">
                        <th scope="col" data-sort="sku" data-label="Kode SKU"
                            class="py-2.5 px-3 font-semibold cursor-pointer select-none hover:text-[#2196f3] transition-all duration-200">
                            Kode SKU <span data-arrow class="font-mono text-[9px]"></span>
                        </th>
                        <th scope="col" data-label="Merk" class="py-2.5 px-3 font-semibold">Merk</th>
                        <th scope="col" data-label="Nama Komponen" class="py-2.5 px-3 font-semibold">Nama Komponen</th>
                        <th scope="col" data-label="Kategori / Rak" class="py-2.5 px-3 font-semibold">Kategori / Rak</th>
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
                    @forelse ($items as $item)
                        <tr class="transition-colors duration-150 hover:bg-blue-50/70" data-search-row
                            data-sortsku="{{ strtolower($item->kode_sku) }}"
                            data-sortstok="{{ $item->stok }}"
                            data-sortharga="{{ $item->harga }}">
                            <td class="py-3.5 px-3 font-mono text-slate-700 align-top">{{ $item->kode_sku }}</td>
                            <td class="py-3.5 px-3 align-top">
                                @php $merkKey = strtoupper($item->merk); @endphp
                                <span class="inline-block rounded-md border px-2 py-0.5 font-mono text-[10px] font-bold tracking-wide {{ $warnaMerk[$merkKey] ?? 'bg-slate-50 text-slate-700 border-slate-200' }}">
                                    {{ $item->merk }}
                                </span>
                            </td>
                            <td class="py-3.5 px-3 text-slate-700 align-top">{{ $item->nama_barang }}</td>
                            <td class="py-3.5 px-3 align-top">
                                <a href="{{ route('categories.show', $item->category_id) }}"
                                   class="inline-flex items-center gap-1.5 text-[#0d47a1] hover:text-[#2196f3] transition-all duration-200">
                                    <span>{{ $item->category->nama_kategori }}</span>
                                    <span class="font-mono text-[10px] text-slate-500 uppercase">{{ $item->category->kode_rak }}</span>
                                </a>
                            </td>
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
                            <td colspan="6" class="py-10 text-center text-slate-500">
                                Belum ada barang pada database.
                            </td>
                        </tr>
                    @endforelse
                    <tr id="no-result-row" class="hidden">
                        <td colspan="6" class="py-10 text-center text-slate-500">
                            Tidak ada komponen yang cocok.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
