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

    {{-- 3 Kartu Ringkasan --}}
    <section class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">

        <div class="bg-white border border-blue-100 shadow-sm rounded-xl p-6 transition-all duration-200 hover:-translate-y-0.5 hover:shadow-md">
            <p class="text-xs font-medium text-slate-600">Info Rak</p>
            <p class="text-2xl font-mono font-bold text-[#0d47a1] mt-1 mb-2 uppercase">{{ $category->kode_rak }}</p>
            <p class="text-xs text-slate-600 leading-relaxed">{{ $category->deskripsi ?? 'Belum ada deskripsi.' }}</p>
        </div>

        <div class="bg-white border border-blue-100 shadow-sm rounded-xl p-6 transition-all duration-200 hover:-translate-y-0.5 hover:shadow-md">
            <p class="text-xs font-medium text-slate-600">Total SKU &amp; Unit</p>
            <div class="border border-blue-200 bg-[#e3f2fd] rounded-lg p-3 my-3">
                <p class="font-mono text-sm text-[#0d47a1]">{{ $totalSku }} Jenis Komponen</p>
                <p class="font-mono text-[11px] text-slate-600 mt-0.5">{{ $totalUnit }} unit fisik tersedia</p>
            </div>
            <p class="font-mono text-[11px] font-semibold {{ $stokMenipis > 0 ? 'text-amber-600' : 'text-emerald-600' }}">
                @if ($stokMenipis > 0)
                    <span class="inline-flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse" aria-hidden="true"></span>
                        {{ $stokMenipis . ' SKU stok menipis' }}
                    </span>
                @else
                    Semua stok aman
                @endif
            </p>
        </div>

        <div class="bg-white border border-blue-100 shadow-sm rounded-xl p-6 transition-all duration-200 hover:-translate-y-0.5 hover:shadow-md">
            <p class="text-xs font-medium text-slate-600">Total Valuasi Rak</p>
            <p class="text-2xl font-mono font-bold text-[#0d47a1] mt-1 mb-5">{{ 'Rp ' . number_format($nilaiAset, 0, ',', '.') }}</p>
            <a href="{{ route('items.create', ['category_id' => $category->id]) }}"
               class="bg-[#2196f3] hover:bg-blue-600 active:scale-[0.98] text-white font-medium shadow-sm text-xs px-4 py-2 rounded-lg transition-all duration-200 inline-flex items-center gap-1.5">
                <svg class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2.4"
                     stroke-linecap="round" aria-hidden="true">
                    <path d="M10 4v12M4 10h12"/>
                </svg>
                Tambah ke Rak Ini
            </a>
        </div>

    </section>

    {{-- Toolbar: Search --}}
    <div class="flex flex-wrap items-center justify-end gap-3 mb-4">

        <div class="relative w-full sm:w-64">
            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                <svg class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2"
                     stroke-linecap="round" aria-hidden="true">
                    <circle cx="9" cy="9" r="5.5"/>
                    <path d="M13.5 13.5L17 17"/>
                </svg>
            </span>
            <input type="search" id="table-search" data-target="komponen-table" autocomplete="off"
                   placeholder="Cari komponen..."
                   class="w-full bg-white border border-blue-200 text-slate-700 placeholder-slate-400 rounded-lg pl-9 pr-3 py-2 text-xs focus:border-[#2196f3] focus:outline-none focus:ring-2 focus:ring-blue-100">
        </div>
    </div>

    <p class="mb-3 font-mono text-[11px] text-slate-500">
        <span id="row-count">{{ $totalSku }}</span> / {{ $totalSku }} BARIS
    </p>

    {{-- Tabel di dalam kartu putih --}}
    <div class="bg-white border border-blue-100 shadow-sm rounded-xl p-6">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse" id="komponen-table">
                <thead class="bg-blue-50/80">
                    <tr class="text-[11px] text-blue-900 font-semibold border-b border-blue-100">
                        <th scope="col" class="py-2.5 px-3 font-semibold">Kode SKU</th>
                        <th scope="col" class="py-2.5 px-3 font-semibold">Merk</th>
                        <th scope="col" class="py-2.5 px-3 font-semibold">Nama Komponen</th>
                        <th scope="col" class="py-2.5 px-3 font-semibold text-right">Stok</th>
                        <th scope="col" class="py-2.5 px-3 font-semibold text-right">Harga Satuan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-blue-100 text-xs">
                    @forelse ($category->items as $item)
                        <tr class="transition-colors duration-150 hover:bg-blue-50/70" data-search-row>
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

    <script>
        // Pencarian instan pada tabel (tanpa reload).
        (function () {
            var input = document.getElementById('table-search');
            var table = document.getElementById('komponen-table');
            if (!table) return;

            var rows = table.querySelectorAll('[data-search-row]');
            var emptyRow = document.getElementById('no-result-row');
            var counter = document.getElementById('row-count');

            function apply() {
                var q = input ? input.value.trim().toLowerCase() : '';
                var visible = 0;

                rows.forEach(function (row) {
                    var show = row.textContent.toLowerCase().indexOf(q) !== -1;
                    row.classList.toggle('hidden', !show);
                    if (show) visible++;
                });

                if (counter) counter.textContent = visible;
                if (emptyRow) emptyRow.classList.toggle('hidden', !(visible === 0 && rows.length > 0));
            }

            if (input) input.addEventListener('input', apply);
        })();
    </script>
@endsection
