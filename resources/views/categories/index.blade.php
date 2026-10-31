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

        <div class="bg-white border border-blue-100 shadow-sm rounded-xl p-6 text-center flex flex-col items-center justify-center transition-all duration-200 hover:-translate-y-0.5 hover:shadow-md">
            <p class="text-xs font-medium text-slate-600">Total Valuasi Inventaris</p>
            <p class="text-2xl font-mono font-bold text-[#0d47a1] mt-1">{{ 'Rp ' . number_format($totalNilai, 0, ',', '.') }}</p>
        </div>

        <div class="bg-white border border-blue-100 shadow-sm rounded-xl p-6 text-center flex flex-col items-center justify-center transition-all duration-200 hover:-translate-y-0.5 hover:shadow-md">
            <p class="text-xs font-medium text-slate-600">Ringkasan Penyimpanan</p>
            <div class="border border-blue-200 bg-[#e3f2fd] rounded-lg p-3 mt-3 w-full">
                <p class="font-mono text-sm text-[#0d47a1]">{{ $categories->count() }} Kategori Rak Aktif</p>
                <p class="font-mono text-[11px] text-slate-600 mt-0.5">Total {{ $totalSku }} Jenis SKU Terdaftar</p>
            </div>
        </div>

        <div class="bg-white border border-blue-100 shadow-sm rounded-xl p-6 text-center flex flex-col items-center justify-center transition-all duration-200 hover:-translate-y-0.5 hover:shadow-md">
            <p class="text-xs font-medium text-slate-600 flex items-center justify-center gap-1">
                Monitoring Stok
                <span class="bg-[#2196f3] text-white text-[10px] font-mono px-1.5 py-0.5 rounded">ACTIVE</span>
            </p>
            <p class="text-xs text-slate-600 leading-relaxed mt-3">
                Terdapat <span class="font-mono font-semibold text-[#0d47a1]">{{ $totalUnit }} unit tersedia</span> di seluruh rak.
                @if ($stokMenipis > 0)
                    <span class="inline-flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse" aria-hidden="true"></span>
                        <span class="text-amber-600 font-mono font-semibold">{{ $stokMenipis }} SKU</span>
                    </span>
                    perlu segera ditambah stoknya.
                @else
                    Seluruh SKU berada pada level stok aman.
                @endif
            </p>
        </div>

    </section>

    {{-- BAGIAN 1b: Grid 4 Kartu KPI Berikon --}}
    <section class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

        <div class="bg-white border border-blue-100 shadow-sm rounded-xl p-4 flex items-center gap-3 transition-all duration-200 hover:-translate-y-0.5 hover:shadow-md">
            <span class="w-9 h-9 shrink-0 rounded-lg bg-indigo-50 text-indigo-600 border border-indigo-200 flex items-center justify-center">
                <svg class="h-4 w-4" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8"
                     stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M10 2.5l6.5 3.5v8L10 17.5 3.5 14V6L10 2.5z"/>
                    <path d="M10 10v7.5M3.5 6L10 9.5 16.5 6"/>
                </svg>
            </span>
            <div class="min-w-0">
                <p class="text-[10px] font-mono uppercase tracking-wider text-slate-500">Total Jenis SKU</p>
                <p class="font-mono text-lg font-bold text-[#0d47a1]">{{ $totalSku }}</p>
            </div>
        </div>

        <div class="bg-white border border-blue-100 shadow-sm rounded-xl p-4 flex items-center gap-3 transition-all duration-200 hover:-translate-y-0.5 hover:shadow-md">
            <span class="w-9 h-9 shrink-0 rounded-lg bg-sky-50 text-sky-600 border border-sky-200 flex items-center justify-center">
                <svg class="h-4 w-4" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8"
                     stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <ellipse cx="10" cy="5" rx="6" ry="2.5"/>
                    <path d="M4 5v10c0 1.38 2.69 2.5 6 2.5s6-1.12 6-2.5V5"/>
                    <path d="M4 10c0 1.38 2.69 2.5 6 2.5s6-1.12 6-2.5"/>
                </svg>
            </span>
            <div class="min-w-0">
                <p class="text-[10px] font-mono uppercase tracking-wider text-slate-500">Total Stok Fisik</p>
                <p class="font-mono text-lg font-bold text-[#0d47a1]">{{ $totalUnit }}</p>
            </div>
        </div>

        <div class="bg-white border border-blue-100 shadow-sm rounded-xl p-4 flex items-center gap-3 transition-all duration-200 hover:-translate-y-0.5 hover:shadow-md">
            <span class="w-9 h-9 shrink-0 rounded-lg bg-teal-50 text-teal-600 border border-teal-200 flex items-center justify-center">
                <svg class="h-4 w-4" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8"
                     stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M3 3h14v14H3z"/>
                    <path d="M3 8h14M8 8v9"/>
                </svg>
            </span>
            <div class="min-w-0">
                <p class="text-[10px] font-mono uppercase tracking-wider text-slate-500">Total Kategori Rak</p>
                <p class="font-mono text-lg font-bold text-[#0d47a1]">{{ $categories->count() }}</p>
            </div>
        </div>

        <div class="bg-white border border-blue-100 shadow-sm rounded-xl p-4 flex items-center gap-3 transition-all duration-200 hover:-translate-y-0.5 hover:shadow-md">
            <span class="w-9 h-9 shrink-0 rounded-lg bg-amber-50 text-amber-600 border border-amber-200 flex items-center justify-center">
                <svg class="h-4 w-4" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8"
                     stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M10 3l7 12H3l7-12z"/>
                    <path d="M10 8v3.5M10 13.5v.01"/>
                </svg>
            </span>
            <div class="min-w-0">
                <p class="text-[10px] font-mono uppercase tracking-wider text-slate-500 flex items-center gap-1.5">
                    @if ($stokMenipis > 0)
                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse" aria-hidden="true"></span>
                    @endif
                    Stok Menipis (&le;5)
                </p>
                <p class="font-mono text-lg font-bold text-[#0d47a1]">{{ $stokMenipis }}</p>
            </div>
        </div>

    </section>

    {{-- BAGIAN 3: Tabs + Tabel --}}
    @php
        // Semua item sudah termuat lewat eager loading $categories->items,
        // jadi tidak perlu query baru dan controller tidak perlu diubah.
        // Relasi category disetel manual agar $item->category tidak lazy load.
        $semuaItem = $categories->flatMap(function ($c) {
            return $c->items->each->setRelation('category', $c);
        })->sortByDesc('id')->values();
    @endphp

    <div class="border-b border-blue-200 mb-5 flex gap-6 text-xs font-medium" role="tablist">
        <button type="button" id="tab-btn-kategori" data-tab="kategori" role="tab" aria-selected="true"
                aria-controls="panel-kategori"
                class="tab-btn tab-on text-[#0d47a1] border-b-2 border-[#2196f3] pb-2.5 transition-all duration-200 hover:text-[#2196f3]">
            Kategori
        </button>
        <button type="button" id="tab-btn-komponen" data-tab="komponen" role="tab" aria-selected="false"
                aria-controls="panel-komponen"
                class="tab-btn text-slate-500 hover:text-[#0d47a1] pb-2.5 border-b-2 border-transparent transition-all duration-200">
            Semua Komponen
        </button>
    </div>

    {{-- Panel 1: Tabel Kategori --}}
    <div id="panel-kategori" role="tabpanel" aria-labelledby="tab-btn-kategori"
         class="bg-white border border-blue-100 shadow-sm rounded-xl p-6 opacity-100 transition-opacity duration-300">
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

    {{-- Panel 2: Tabel Semua Komponen --}}
    <div id="panel-komponen" role="tabpanel" aria-labelledby="tab-btn-komponen"
         class="hidden bg-white border border-blue-100 shadow-sm rounded-xl p-6 opacity-0 transition-opacity duration-300">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-blue-50/80">
                    <tr class="text-[11px] text-blue-900 font-semibold border-b border-blue-100">
                        <th scope="col" class="py-2.5 px-3 font-semibold">Kode SKU</th>
                        <th scope="col" class="py-2.5 px-3 font-semibold">Merk</th>
                        <th scope="col" class="py-2.5 px-3 font-semibold">Nama Komponen</th>
                        <th scope="col" class="py-2.5 px-3 font-semibold">Kategori / Rak</th>
                        <th scope="col" class="py-2.5 px-3 font-semibold text-right">Stok</th>
                        <th scope="col" class="py-2.5 px-3 font-semibold text-right">Harga Satuan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-blue-100 text-xs">
                    @forelse ($semuaItem as $item)
                        <tr class="transition-colors duration-150 hover:bg-blue-50/70">
                            <td class="py-3.5 px-3 font-mono text-slate-700 align-top">{{ $item->kode_sku }}</td>
                            <td class="py-3.5 px-3 font-mono text-[11px] uppercase text-blue-700 align-top">{{ $item->merk }}</td>
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
                                Belum ada komponen pada database.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // Tab penampil tabel: Kategori <-> Semua Komponen, tanpa pindah halaman.
        // Panel lama di-fade-out dulu agar kedua tabel tidak tampil bertumpuk.
        (function () {
            var buttons = document.querySelectorAll('.tab-btn');
            var panels = {
                kategori: document.getElementById('panel-kategori'),
                komponen: document.getElementById('panel-komponen')
            };
            if (!buttons.length) return;

            var current = 'kategori';
            var animating = false;

            function reveal(el) {
                el.classList.remove('hidden');
                // Paksa reflow supaya transisi opacity benar-benar berjalan.
                void el.offsetWidth;
                el.classList.remove('opacity-0');
                el.classList.add('opacity-100');
            }

            function conceal(el) {
                el.classList.remove('opacity-100');
                el.classList.add('opacity-0');
            }

            function syncButtons(name) {
                buttons.forEach(function (btn) {
                    var on = btn.dataset.tab === name;
                    btn.setAttribute('aria-selected', on ? 'true' : 'false');
                    btn.classList.toggle('tab-on', on);
                    btn.classList.toggle('text-[#0d47a1]', on);
                    btn.classList.toggle('border-[#2196f3]', on);
                    btn.classList.toggle('border-transparent', !on);
                    btn.classList.toggle('text-slate-500', !on);
                });
            }

            function show(name) {
                var next = panels[name];
                var prev = panels[current];
                if (!next || name === current || animating) return;

                animating = true;
                syncButtons(name);

                if (prev) conceal(prev);

                window.setTimeout(function () {
                    if (prev) prev.classList.add('hidden');
                    reveal(next);
                    current = name;
                    animating = false;
                }, 150);
            }

            buttons.forEach(function (btn) {
                btn.addEventListener('click', function () {
                    show(btn.dataset.tab);
                });
            });
        })();
    </script>
@endsection
