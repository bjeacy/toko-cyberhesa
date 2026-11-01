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

        // Ikon hardware per kategori, dicocokkan lewat nama kategori.
        // Fallback ke ikon box bila nama tidak dikenali, jadi kategori baru tetap tampil rapi.
        $ikonRak = function ($nama) {
            $n = strtolower($nama);
            if (str_contains($n, 'processor') || str_contains($n, 'cpu')) {
                return 'chip';
            }
            if (str_contains($n, 'vga') || str_contains($n, 'gpu')) {
                return 'gpu';
            }
            if (str_contains($n, 'ram') || str_contains($n, 'storage') || str_contains($n, 'ssd') || str_contains($n, 'memory')) {
                return 'ram';
            }
            if (str_contains($n, 'gaming') || str_contains($n, 'gear') || str_contains($n, 'aksesoris')) {
                return 'gear';
            }
            return 'box';
        };

        // Warna aksen per ikon agar tiap kartu rak punya identitas sendiri.
        $warnaRak = [
            'chip' => ['bg' => 'bg-indigo-50', 'text' => 'text-indigo-600', 'border' => 'border-indigo-200'],
            'gpu'  => ['bg' => 'bg-violet-50', 'text' => 'text-violet-600', 'border' => 'border-violet-200'],
            'ram'  => ['bg' => 'bg-cyan-50',   'text' => 'text-cyan-700',   'border' => 'border-cyan-200'],
            'gear' => ['bg' => 'bg-teal-50',   'text' => 'text-teal-700',   'border' => 'border-teal-200'],
            'box'  => ['bg' => 'bg-sky-50',    'text' => 'text-sky-700',    'border' => 'border-sky-200'],
        ];
    @endphp

    {{-- BAGIAN 1: 3 Kartu Utama. Rata kiri, ikon di pojok kanan, angka pakai font sans tabular. --}}
    <section class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-6">

        {{-- Kartu 1: Valuasi --}}
        <div class="relative overflow-hidden bg-white border border-blue-100/80 rounded-2xl shadow-sm p-6 text-left transition-all duration-200 hover:-translate-y-0.5 hover:shadow-md">
            <span class="absolute top-6 right-6 w-11 h-11 rounded-xl flex items-center justify-center bg-blue-50 text-[#1976d2]">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"
                     stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <rect x="2.5" y="6.5" width="19" height="11" rx="2"/>
                    <circle cx="12" cy="12" r="2.6"/>
                    <path d="M6 9.5v5M18 9.5v5"/>
                </svg>
            </span>
            <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Valuasi Inventaris</p>
            <p class="text-xl sm:text-2xl font-sans font-extrabold tracking-tight tabular-nums text-blue-950 mt-2">
                {{ 'Rp ' . number_format($totalNilai, 0, ',', '.') }}
            </p>
            <p class="text-xs text-slate-500 mt-3 flex items-center gap-1.5">
                <svg class="h-3.5 w-3.5 shrink-0" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8"
                     stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <circle cx="10" cy="10" r="7"/>
                    <path d="M10 6.5v7M8 8.5h3.2a1.4 1.4 0 0 1 0 2.8H8.8a1.4 1.4 0 0 0 0 2.8H12"/>
                </svg>
                Akumulasi nilai seluruh komponen aktif
            </p>
        </div>

        {{-- Kartu 2: Penyimpanan --}}
        <div class="relative overflow-hidden bg-white border border-blue-100/80 rounded-2xl shadow-sm p-6 text-left transition-all duration-200 hover:-translate-y-0.5 hover:shadow-md">
            <span class="absolute top-6 right-6 w-11 h-11 rounded-xl flex items-center justify-center bg-indigo-50 text-indigo-600">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"
                     stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <rect x="3" y="4" width="18" height="6" rx="2"/>
                    <rect x="3" y="14" width="18" height="6" rx="2"/>
                    <path d="M7 7h.01M7 17h.01"/>
                </svg>
            </span>
            <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Kapasitas Penyimpanan</p>
            <p class="text-xl sm:text-2xl font-sans font-extrabold tracking-tight tabular-nums text-blue-950 mt-2">
                {{ $categories->count() }} Rak Aktif
            </p>
            <span class="bg-blue-50 text-[#1565c0] font-semibold text-xs px-2.5 py-1 rounded-lg inline-flex items-center gap-1.5 mt-3">
                Total {{ $totalSku }} Jenis SKU Terdaftar
            </span>
        </div>

        {{-- Kartu 3: Monitoring stok --}}
        <div class="relative overflow-hidden bg-white border border-blue-100/80 rounded-2xl shadow-sm p-6 text-left transition-all duration-200 hover:-translate-y-0.5 hover:shadow-md">
            <span class="absolute top-6 right-6 w-11 h-11 rounded-xl flex items-center justify-center {{ $stokMenipis > 0 ? 'bg-amber-50 text-amber-600' : 'bg-emerald-50 text-emerald-600' }}">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"
                     stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M3.5 12h3.5l2-5 3 10 2.5-7 1.5 2h4.5"/>
                </svg>
            </span>
            <p class="text-xs font-bold uppercase tracking-wider text-slate-400 flex items-center gap-2">
                Monitoring Stok
                <span class="bg-emerald-50 text-emerald-700 border border-emerald-200 text-[10px] font-bold px-2 py-0.5 rounded-full normal-case tracking-normal">LIVE / ACTIVE</span>
            </p>
            <p class="text-xl sm:text-2xl font-sans font-extrabold tracking-tight tabular-nums text-blue-950 mt-2">
                {{ $totalUnit }} Unit Tersedia
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
        </div>

    </section>

    {{-- BAGIAN 2: Showcase Rak Komponen PC (interaktif, 1 kartu per kategori) --}}
    <section class="mb-6">
        <div class="flex items-baseline justify-between gap-3 mb-3">
            <h2 class="text-sm font-bold text-blue-950">Rak Komponen PC</h2>
            <a href="{{ route('items.index') }}"
               class="text-xs font-medium text-[#2196f3] hover:text-blue-700 transition-all duration-200">
                Lihat semua komponen &rarr;
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
            @foreach ($categories as $rak)
                @php
                    $jenis = $ikonRak($rak->nama_kategori);
                    $warna = $warnaRak[$jenis];
                    $unitRak = $rak->items->sum('stok');
                    // Proporsi unit rak terhadap total stok gudang (hindari bagi nol).
                    $persen = $totalUnit > 0 ? round($unitRak / $totalUnit * 100) : 0;
                @endphp

                <a href="{{ route('categories.show', $rak->id) }}"
                   class="group bg-white border border-blue-100 shadow-sm rounded-xl p-5 flex flex-col transition-all duration-200 hover:-translate-y-0.5 hover:shadow-md hover:border-blue-300">
                    <div class="flex items-start justify-between gap-3">
                        <span class="w-11 h-11 shrink-0 rounded-xl {{ $warna['bg'] }} {{ $warna['text'] }} border {{ $warna['border'] }} flex items-center justify-center">
                            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"
                                 stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                @if ($jenis === 'chip')
                                    <rect x="7" y="7" width="10" height="10" rx="1.5"/>
                                    <path d="M10 2.5v3M14 2.5v3M10 18.5v3M14 18.5v3M2.5 10h3M2.5 14h3M18.5 10h3M18.5 14h3"/>
                                    <rect x="11" y="11" width="2" height="2" rx="0.4"/>
                                @elseif ($jenis === 'gpu')
                                    <rect x="2.5" y="6" width="17" height="11" rx="2"/>
                                    <circle cx="9" cy="11.5" r="2.8"/>
                                    <path d="M9 11.5h4.5M16 9v5M19.5 9.5v1.5M19.5 13v1.5"/>
                                @elseif ($jenis === 'ram')
                                    <rect x="2.5" y="7" width="19" height="10" rx="1.5"/>
                                    <path d="M6 17v2.5M10 17v2.5M14 17v2.5M18 17v2.5"/>
                                    <rect x="6" y="10" width="3" height="4" rx="0.5"/>
                                    <rect x="10.5" y="10" width="3" height="4" rx="0.5"/>
                                    <rect x="15" y="10" width="3" height="4" rx="0.5"/>
                                @elseif ($jenis === 'gear')
                                    <path d="M8 4.5h8l1.5 4.5-1.2 10.5a1.5 1.5 0 0 1-1.5 1.4H9.2a1.5 1.5 0 0 1-1.5-1.4L6.5 9z"/>
                                    <path d="M8 4.5C8 3 9 2 10 2h4c1 0 2 1 2 2.5"/>
                                    <path d="M12 9.5v6M9.5 12.5h5"/>
                                @else
                                    <path d="M3 7.5L12 3l9 4.5-9 4.5-9-4.5z"/>
                                    <path d="M3 7.5v9L12 21l9-4.5v-9"/>
                                    <path d="M12 12v9"/>
                                @endif
                            </svg>
                        </span>
                        <span class="font-mono text-[10px] font-semibold uppercase tracking-wider text-blue-700 bg-blue-50 border border-blue-200 px-2 py-0.5 rounded">
                            {{ $rak->kode_rak }}
                        </span>
                    </div>

                    <p class="mt-3 text-sm font-bold text-blue-950 truncate group-hover:text-[#2196f3] transition-all duration-200">
                        {{ $rak->nama_kategori }}
                    </p>

                    <p class="mt-1 font-mono text-[11px] text-slate-600">
                        {{ $rak->items_count }} SKU &middot; {{ $unitRak }} unit
                    </p>

                    {{-- Mini progress bar: proporsi unit rak terhadap total stok gudang. --}}
                    <div class="mt-3">
                        <div class="flex items-center justify-between text-[10px] font-mono text-slate-500 mb-1">
                            <span>Porsi Gudang</span>
                            <span>{{ $persen }}%</span>
                        </div>
                        <div class="h-1.5 w-full rounded-full bg-blue-100 overflow-hidden">
                            <div class="h-full rounded-full bg-[#2196f3] transition-all duration-500" style="width: {{ $persen }}%"></div>
                        </div>
                    </div>
                </a>
            @endforeach

            @if ($categories->isEmpty())
                <p class="col-span-full py-10 text-center text-sm text-slate-500">Belum ada kategori pada database.</p>
            @endif
        </div>
    </section>

    {{-- BAGIAN 3: Tabel Daftar Kategori Rak --}}
    <div class="bg-white border border-blue-100 shadow-sm rounded-xl p-6">
        <div class="flex items-baseline justify-between gap-3 mb-4">
            <h2 class="text-sm font-bold text-blue-950">Daftar Kategori Rak</h2>
            <span class="font-mono text-[11px] text-slate-500">{{ $categories->count() }} RAK</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-blue-50/80">
                    <tr class="text-[11px] text-blue-900 font-semibold border-b border-blue-100">
                        <th scope="col" class="py-2.5 px-3 font-semibold">Kode Rak</th>
                        <th scope="col" class="py-2.5 px-3 font-semibold">Kategori</th>
                        <th scope="col" class="py-2.5 px-3 font-semibold">Deskripsi Komponen</th>
                        <th scope="col" class="py-2.5 px-3 font-semibold text-right">Jumlah SKU</th>
                        <th scope="col" class="py-2.5 px-3 font-semibold text-right">Total Unit</th>
                        <th scope="col" class="py-2.5 px-3 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-blue-100 text-xs">
                    @forelse ($categories as $category)
                        <tr class="transition-colors duration-150 hover:bg-blue-50/70">
                            <td class="py-3.5 px-3 font-mono text-[11px] text-blue-700 uppercase align-top">{{ $category->kode_rak }}</td>
                            <td class="py-3.5 px-3 align-top">
                                <a href="{{ route('categories.show', $category->id) }}"
                                   class="inline-flex items-center gap-1 font-medium text-[#0d47a1] hover:text-[#2196f3] transition-all duration-200">
                                    <svg class="h-3 w-3 text-slate-400" viewBox="0 0 20 20" fill="none" stroke="currentColor"
                                         stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="M8 5.5L12.5 10 8 14.5"/>
                                    </svg>
                                    {{ $category->nama_kategori }}
                                </a>
                            </td>
                            <td class="py-3.5 px-3 text-slate-600 max-w-md align-top">
                                {{ $category->deskripsi ?? 'Belum ada deskripsi.' }}
                            </td>
                            <td class="py-3.5 px-3 font-mono text-slate-700 text-right align-top">{{ $category->items_count }}</td>
                            <td class="py-3.5 px-3 font-mono font-semibold text-right align-top
                                       {{ $category->items->sum('stok') > 5 ? 'text-emerald-600' : 'text-amber-600' }}">
                                @if ($category->items->sum('stok') <= 5)
                                    <span class="inline-flex items-center gap-1.5 justify-end">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse" aria-hidden="true"></span>
                                        {{ $category->items->sum('stok') }}
                                    </span>
                                @else
                                    {{ $category->items->sum('stok') }}
                                @endif
                            </td>
                            <td class="py-3.5 px-3 text-right align-top">
                                <a href="{{ route('categories.show', $category->id) }}"
                                   class="text-[#2196f3] hover:text-blue-700 font-medium transition-all duration-200 whitespace-nowrap">
                                    Buka Rak &rarr;
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-10 text-center text-slate-500">
                                Belum ada kategori pada database.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
