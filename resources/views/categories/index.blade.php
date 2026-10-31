@extends('layouts.app')

@section('title', 'Inventory Overview - cyberhesa')
@section('header_title', 'Inventory Overview')
@section('header_subtitle', 'Ringkasan real-time pergerakan inventaris dan status stok komponen PC')

@section('content')
    @php
        $totalNilai = $categories->sum(fn ($c) => $c->items->sum(fn ($i) => $i->stok * $i->harga));
        $totalUnit = $categories->sum(fn ($c) => $c->items->sum('stok'));
        $totalSku = $categories->sum('items_count');
        $stokMenipis = $categories->sum(fn ($c) => $c->items->where('stok', '<=', 5)->count());
    @endphp

    {{-- BAGIAN 1: 3 Kartu Utama --}}
    <section class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-6">

        <div class="bg-[#1e293b] border border-slate-700/80 rounded-xl p-6 shadow-sm">
            <p class="text-xs font-medium text-slate-300">Total Valuasi Inventaris</p>
            <p class="text-2xl font-mono font-bold text-white mt-1 mb-5">{{ 'Rp ' . number_format($totalNilai, 0, ',', '.') }}</p>
            <a href="{{ route('items.create') }}"
               class="bg-[#a5c4ff] hover:bg-[#8eb4ff] text-[#0f172a] font-semibold text-xs px-4 py-2 rounded-lg transition inline-flex items-center gap-1.5">
                <svg class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2.4"
                     stroke-linecap="round" aria-hidden="true">
                    <path d="M10 4v12M4 10h12"/>
                </svg>
                Input Komponen
            </a>
        </div>

        <div class="bg-[#1e293b] border border-slate-700/80 rounded-xl p-6 shadow-sm">
            <p class="text-xs font-medium text-slate-300">Ringkasan Penyimpanan</p>
            <div class="border border-slate-600/80 bg-[#0f172a] rounded-lg p-3 my-3">
                <p class="font-mono text-sm text-white">{{ $categories->count() }} Kategori Rak Aktif</p>
                <p class="font-mono text-[11px] text-slate-400 mt-0.5">Total {{ $totalSku }} Jenis SKU Terdaftar</p>
            </div>
            <a href="{{ route('items.index') }}"
               class="bg-transparent hover:bg-slate-700/60 text-slate-200 border border-slate-600/80 font-medium text-xs px-3.5 py-2 rounded-lg transition inline-flex items-center gap-1.5">
                Lihat Semua Barang
                <svg class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2"
                     stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M4 10h11M10.5 5.5L15 10l-4.5 4.5"/>
                </svg>
            </a>
        </div>

        <div class="bg-[#1e293b] border border-slate-700/80 rounded-xl p-6 shadow-sm">
            <p class="text-xs font-medium text-slate-300">
                Monitoring Stok
                <span class="bg-slate-700 text-slate-200 text-[10px] font-mono px-1.5 py-0.5 rounded ml-1">ACTIVE</span>
            </p>
            <p class="text-xs text-slate-300 leading-relaxed my-3">
                Terdapat <span class="font-mono text-white">{{ $totalUnit }} unit tersedia</span> di seluruh rak.
                @if ($stokMenipis > 0)
                    <span class="text-amber-400 font-mono">{{ $stokMenipis }} SKU</span> perlu segera ditambah stoknya.
                @else
                    Seluruh SKU berada pada level stok aman.
                @endif
            </p>
            <a href="{{ route('items.create') }}"
               class="bg-[#a5c4ff] hover:bg-[#8eb4ff] text-[#0f172a] font-semibold text-xs px-4 py-2 rounded-lg transition inline-flex items-center gap-1.5">
                Tambah Stok
            </a>
        </div>

    </section>

    {{-- BAGIAN 1b: Grid 4 Kartu KPI Berikon --}}
    <section class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

        <div class="bg-[#1e293b] border border-slate-700/80 rounded-xl p-4 flex items-center gap-3 shadow-sm">
            <span class="w-9 h-9 shrink-0 rounded-lg bg-indigo-500/10 text-indigo-400 border border-indigo-500/20 flex items-center justify-center">
                <svg class="h-4 w-4" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8"
                     stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M10 2.5l6.5 3.5v8L10 17.5 3.5 14V6L10 2.5z"/>
                    <path d="M10 10v7.5M3.5 6L10 9.5 16.5 6"/>
                </svg>
            </span>
            <div class="min-w-0">
                <p class="text-[10px] font-mono uppercase tracking-wider text-slate-400">Total Jenis SKU</p>
                <p class="font-mono text-lg font-bold text-white">{{ $totalSku }}</p>
            </div>
        </div>

        <div class="bg-[#1e293b] border border-slate-700/80 rounded-xl p-4 flex items-center gap-3 shadow-sm">
            <span class="w-9 h-9 shrink-0 rounded-lg bg-sky-500/10 text-sky-400 border border-sky-500/20 flex items-center justify-center">
                <svg class="h-4 w-4" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8"
                     stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <ellipse cx="10" cy="5" rx="6" ry="2.5"/>
                    <path d="M4 5v10c0 1.38 2.69 2.5 6 2.5s6-1.12 6-2.5V5"/>
                    <path d="M4 10c0 1.38 2.69 2.5 6 2.5s6-1.12 6-2.5"/>
                </svg>
            </span>
            <div class="min-w-0">
                <p class="text-[10px] font-mono uppercase tracking-wider text-slate-400">Total Stok Fisik</p>
                <p class="font-mono text-lg font-bold text-white">{{ $totalUnit }}</p>
            </div>
        </div>

        <div class="bg-[#1e293b] border border-slate-700/80 rounded-xl p-4 flex items-center gap-3 shadow-sm">
            <span class="w-9 h-9 shrink-0 rounded-lg bg-teal-500/10 text-teal-400 border border-teal-500/20 flex items-center justify-center">
                <svg class="h-4 w-4" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8"
                     stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M3 3h14v14H3z"/>
                    <path d="M3 8h14M8 8v9"/>
                </svg>
            </span>
            <div class="min-w-0">
                <p class="text-[10px] font-mono uppercase tracking-wider text-slate-400">Total Kategori Rak</p>
                <p class="font-mono text-lg font-bold text-white">{{ $categories->count() }}</p>
            </div>
        </div>

        <div class="bg-[#1e293b] border border-slate-700/80 rounded-xl p-4 flex items-center gap-3 shadow-sm">
            <span class="w-9 h-9 shrink-0 rounded-lg bg-amber-500/10 text-amber-400 border border-amber-500/20 flex items-center justify-center">
                <svg class="h-4 w-4" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8"
                     stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M10 3l7 12H3l7-12z"/>
                    <path d="M10 8v3.5M10 13.5v.01"/>
                </svg>
            </span>
            <div class="min-w-0">
                <p class="text-[10px] font-mono uppercase tracking-wider text-slate-400">Stok Menipis (&le;5)</p>
                <p class="font-mono text-lg font-bold text-white">{{ $stokMenipis }}</p>
            </div>
        </div>

    </section>

    {{-- BAGIAN 3: Tabs + Tabel --}}
    <div class="border-b border-slate-700/70 mb-5 flex gap-6 text-xs font-medium">
        <span class="text-white border-b-2 border-[#a5c4ff] pb-2.5">Daftar Kategori &amp; Rak</span>
        <a href="{{ route('items.index') }}" class="text-slate-400 hover:text-slate-200 pb-2.5 transition">Semua Komponen</a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="text-[11px] text-slate-400 font-medium border-b border-slate-700/70">
                    <th scope="col" class="pb-2.5 pr-4 font-medium">Kode Rak</th>
                    <th scope="col" class="pb-2.5 pr-4 font-medium">Kategori</th>
                    <th scope="col" class="pb-2.5 pr-4 font-medium">Deskripsi Komponen</th>
                    <th scope="col" class="pb-2.5 pr-4 font-medium text-right">Jumlah SKU</th>
                    <th scope="col" class="pb-2.5 pr-4 font-medium text-right">Total Unit</th>
                    <th scope="col" class="pb-2.5 font-medium text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-700/60 text-xs">
                @forelse ($categories as $category)
                    <tr class="hover:bg-slate-800/60 transition">
                        <td class="py-3.5 pr-4 font-mono text-[11px] text-sky-400 uppercase align-top">{{ $category->kode_rak }}</td>
                        <td class="py-3.5 pr-4 align-top">
                            <a href="{{ route('categories.show', $category->id) }}"
                               class="inline-flex items-center gap-1 font-medium text-slate-100 hover:text-white transition">
                                <svg class="h-3 w-3 text-slate-400" viewBox="0 0 20 20" fill="none" stroke="currentColor"
                                     stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M8 5.5L12.5 10 8 14.5"/>
                                </svg>
                                {{ $category->nama_kategori }}
                            </a>
                        </td>
                        <td class="py-3.5 pr-4 text-slate-300 max-w-md align-top">
                            {{ $category->deskripsi ?? 'Belum ada deskripsi.' }}
                        </td>
                        <td class="py-3.5 pr-4 font-mono text-slate-100 text-right align-top">{{ $category->items_count }}</td>
                        <td class="py-3.5 pr-4 font-mono text-right align-top
                                   {{ $category->items->sum('stok') > 5 ? 'text-emerald-400' : 'text-amber-400' }}">
                            {{ $category->items->sum('stok') }}
                        </td>
                        <td class="py-3.5 text-right align-top">
                            <a href="{{ route('categories.show', $category->id) }}"
                               class="text-slate-300 hover:text-white transition whitespace-nowrap">
                                Buka Rak &rarr;
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-10 text-center text-slate-400">
                            Belum ada kategori pada database.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
