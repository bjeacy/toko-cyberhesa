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
        <a href="{{ route('categories.index') }}" class="text-slate-400 hover:text-slate-200 transition">Overview</a>
        <span class="text-slate-400">/</span>
        <span class="text-slate-400">Rak</span>
        <span class="text-slate-400">/</span>
        <span class="text-slate-200">{{ $category->nama_kategori }}</span>
    </nav>

    {{-- 3 Kartu Ringkasan --}}
    <section class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">

        <div class="bg-[#1e293b] border border-slate-700/80 rounded-xl p-6 shadow-sm">
            <p class="text-xs font-medium text-slate-300">Info Rak</p>
            <p class="text-2xl font-mono font-bold text-white mt-1 mb-2 uppercase">{{ $category->kode_rak }}</p>
            <p class="text-xs text-slate-300 leading-relaxed">{{ $category->deskripsi ?? 'Belum ada deskripsi.' }}</p>
        </div>

        <div class="bg-[#1e293b] border border-slate-700/80 rounded-xl p-6 shadow-sm">
            <p class="text-xs font-medium text-slate-300">Total SKU &amp; Unit</p>
            <div class="border border-slate-600/80 bg-[#0f172a] rounded-lg p-3 my-3">
                <p class="font-mono text-sm text-white">{{ $totalSku }} Jenis Komponen</p>
                <p class="font-mono text-[11px] text-slate-400 mt-0.5">{{ $totalUnit }} unit fisik tersedia</p>
            </div>
            <p class="font-mono text-[11px] {{ $stokMenipis > 0 ? 'text-amber-400' : 'text-emerald-400' }}">
                {{ $stokMenipis > 0 ? $stokMenipis . ' SKU stok menipis' : 'Semua stok aman' }}
            </p>
        </div>

        <div class="bg-[#1e293b] border border-slate-700/80 rounded-xl p-6 shadow-sm">
            <p class="text-xs font-medium text-slate-300">Total Valuasi Rak</p>
            <p class="text-2xl font-mono font-bold text-white mt-1 mb-5">{{ 'Rp ' . number_format($nilaiAset, 0, ',', '.') }}</p>
            <a href="{{ route('items.create', ['category_id' => $category->id]) }}"
               class="bg-[#a5c4ff] hover:bg-[#8eb4ff] text-[#0f172a] font-semibold text-xs px-4 py-2 rounded-lg transition inline-flex items-center gap-1.5">
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
                   class="w-full bg-[#0f172a] border border-slate-600/80 text-slate-100 placeholder-slate-400 rounded-lg pl-9 pr-3 py-2 text-xs focus:border-[#a5c4ff] focus:outline-none">
        </div>
    </div>

    <p class="mb-3 font-mono text-[11px] text-slate-400">
        <span id="row-count">{{ $totalSku }}</span> / {{ $totalSku }} BARIS
    </p>

    {{-- Tabel Borderless Minimalis --}}
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse" id="komponen-table">
            <thead>
                <tr class="text-[11px] text-slate-400 font-medium border-b border-slate-700/70">
                    <th scope="col" class="pb-2.5 pr-4 font-medium">Kode SKU</th>
                    <th scope="col" class="pb-2.5 pr-4 font-medium">Merk</th>
                    <th scope="col" class="pb-2.5 pr-4 font-medium">Nama Komponen</th>
                    <th scope="col" class="pb-2.5 pr-4 font-medium text-right">Stok</th>
                    <th scope="col" class="pb-2.5 font-medium text-right">Harga Satuan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-700/60 text-xs">
                @forelse ($category->items as $item)
                    <tr class="hover:bg-slate-800/60 transition" data-search-row>
                        <td class="py-3.5 pr-4 font-mono text-slate-200 align-top">{{ $item->kode_sku }}</td>
                        <td class="py-3.5 pr-4 font-mono text-[11px] uppercase text-sky-400 align-top">{{ $item->merk }}</td>
                        <td class="py-3.5 pr-4 text-slate-100 align-top">{{ $item->nama_barang }}</td>
                        <td class="py-3.5 pr-4 font-mono text-right align-top {{ $item->stok <= 5 ? 'text-amber-400' : 'text-emerald-400' }}">
                            {{ $item->stok }}
                        </td>
                        <td class="py-3.5 font-mono text-emerald-400 text-right align-top">
                            {{ 'Rp ' . number_format($item->harga, 0, ',', '.') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-10 text-center text-slate-400">
                            Rak ini belum memiliki komponen.
                        </td>
                    </tr>
                @endforelse
                <tr id="no-result-row" class="hidden">
                    <td colspan="5" class="py-10 text-center text-slate-400">
                        Tidak ada komponen yang cocok.
                    </td>
                </tr>
            </tbody>
        </table>
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
