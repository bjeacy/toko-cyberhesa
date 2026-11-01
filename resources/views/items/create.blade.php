@extends('layouts.app')

@section('title', 'Input Komponen Baru - cyberhesa')
@section('header_title', 'Input Komponen Baru')
@section('header_subtitle', 'Catat barang masuk ke dalam rak kategori inventaris')

@section('content')
    {{-- Breadcrumb --}}
    <nav class="mb-6 flex items-center gap-2 text-xs" aria-label="Breadcrumb">
        <a href="{{ route('categories.index') }}" class="text-slate-500 hover:text-[#0d47a1] transition-all duration-200">Overview</a>
        <span class="text-slate-400">/</span>
        <a href="{{ route('items.index') }}" class="text-slate-500 hover:text-[#0d47a1] transition-all duration-200">Semua Komponen</a>
        <span class="text-slate-400">/</span>
        <span class="text-[#0d47a1] font-medium">Input Baru</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

    <div class="lg:col-span-2 bg-white border border-blue-100 shadow-sm rounded-2xl p-6">
        <div class="mb-6">
            <p class="text-sm font-bold text-blue-950">Data Komponen</p>
            <p class="text-xs text-slate-600 mt-1">Kolom bertanda <span class="text-rose-600 font-semibold">*</span> wajib diisi.</p>
        </div>

        <form action="{{ route('items.store') }}" method="POST" class="space-y-5">
            @csrf

            {{-- Kategori --}}
            <div>
                <label for="category_id" class="mb-1.5 block text-xs font-semibold text-blue-950 uppercase tracking-wider">
                    Kategori <span class="text-rose-600">*</span>
                </label>
                <select name="category_id" id="category_id"
                        class="w-full bg-white border border-blue-200 rounded-xl px-3.5 py-2.5 text-sm text-blue-950 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#2196f3]/20
                               {{ $errors->has('category_id') ? 'border-rose-400 focus:border-rose-500' : 'focus:border-[#2196f3]' }}">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ old('category_id', request('category_id')) == $category->id ? 'selected' : '' }}>
                            {{ $category->nama_kategori }} ({{ $category->kode_rak }})
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                {{-- Kode SKU --}}
                <div>
                    <label for="kode_sku" class="mb-1.5 block text-xs font-semibold text-blue-950 uppercase tracking-wider">
                        Kode SKU <span class="text-rose-600">*</span>
                    </label>
                    <input type="text" name="kode_sku" id="kode_sku" value="{{ old('kode_sku') }}"
                           placeholder="CPU-INT-13400F" autocomplete="off" data-uppercase
                           class="w-full bg-white border border-blue-200 rounded-xl px-3.5 py-2.5 text-sm font-mono text-blue-950 placeholder-slate-400 uppercase focus:outline-none focus:ring-2 focus:ring-[#2196f3]/20
                                  {{ $errors->has('kode_sku') ? 'border-rose-400 focus:border-rose-500' : 'focus:border-[#2196f3]' }}">
                    <p class="mt-1.5 text-xs text-slate-500">Format: KATEGORI-MERK-MODEL</p>
                    @error('kode_sku')
                        <p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Merk --}}
                <div>
                    <label for="merk" class="mb-1.5 block text-xs font-semibold text-blue-950 uppercase tracking-wider">
                        Merk <span class="text-rose-600">*</span>
                    </label>
                    <input type="text" name="merk" id="merk" value="{{ old('merk') }}"
                           placeholder="Intel" autocomplete="off"
                           class="w-full bg-white border border-blue-200 rounded-xl px-3.5 py-2.5 text-sm text-blue-950 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#2196f3]/20
                                  {{ $errors->has('merk') ? 'border-rose-400 focus:border-rose-500' : 'focus:border-[#2196f3]' }}">
                    @error('merk')
                        <p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Nama Barang --}}
            <div>
                <label for="nama_barang" class="mb-1.5 block text-xs font-semibold text-blue-950 uppercase tracking-wider">
                    Nama Komponen <span class="text-rose-600">*</span>
                </label>
                <input type="text" name="nama_barang" id="nama_barang" value="{{ old('nama_barang') }}"
                       placeholder="Intel Core i5-13400F" autocomplete="off"
                       class="w-full bg-white border border-blue-200 rounded-xl px-3.5 py-2.5 text-sm text-blue-950 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#2196f3]/20
                              {{ $errors->has('nama_barang') ? 'border-rose-400 focus:border-rose-500' : 'focus:border-[#2196f3]' }}">
                @error('nama_barang')
                    <p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                {{-- Stok --}}
                <div>
                    <label for="stok" class="mb-1.5 block text-xs font-semibold text-blue-950 uppercase tracking-wider">
                        Stok <span class="text-rose-600">*</span>
                    </label>
                    <input type="number" name="stok" id="stok" min="0" step="1" value="{{ old('stok', 0) }}"
                           class="w-full bg-white border border-blue-200 rounded-xl px-3.5 py-2.5 text-sm font-mono text-blue-950 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#2196f3]/20
                                  {{ $errors->has('stok') ? 'border-rose-400 focus:border-rose-500' : 'focus:border-[#2196f3]' }}">
                    <p class="mt-1.5 text-xs text-slate-500">Batas minimum stok aman: 6 unit</p>
                    @error('stok')
                        <p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Harga --}}
                <div>
                    <label for="harga" class="mb-1.5 block text-xs font-semibold text-blue-950 uppercase tracking-wider">
                        Harga Satuan <span class="text-rose-600">*</span>
                    </label>
                    <div class="relative">
                        <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center rounded-l-xl border-r border-blue-200 bg-blue-50 px-3 font-mono text-xs text-blue-950">Rp</span>
                        <input type="number" name="harga" id="harga" min="0" step="1" value="{{ old('harga') }}"
                               placeholder="2850000"
                               class="w-full bg-white border border-blue-200 rounded-xl pl-12 pr-3.5 py-2.5 text-sm font-mono text-blue-950 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#2196f3]/20
                                      {{ $errors->has('harga') ? 'border-rose-400 focus:border-rose-500' : 'focus:border-[#2196f3]' }}">
                    </div>
                    <p class="mt-1.5 text-xs text-slate-500">Tanpa titik atau koma</p>
                    <p id="harga-preview" class="mt-1 text-xs font-mono text-[#0d47a1] hidden"></p>
                    @error('harga')
                        <p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-3 border-t border-blue-100 pt-5">
                <button type="submit"
                        class="bg-[#2196f3] hover:bg-blue-600 active:scale-[0.98] text-white font-semibold px-5 py-2.5 rounded-xl shadow-sm transition-all duration-200 flex items-center gap-2">
                    <svg class="h-4 w-4" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2.4"
                         stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M4 10.5l4 4 8-9"/>
                    </svg>
                    Simpan Barang
                </button>
                <a href="{{ route('items.index') }}"
                   class="bg-white hover:bg-blue-50 active:scale-[0.98] text-slate-700 border border-blue-200 font-medium px-4 py-2.5 rounded-xl transition-all duration-200">
                    Batal
                </a>
            </div>
        </form>
    </div>

    {{-- Panel pendamping: panduan pengisian, alur kerja, dan tips penomoran SKU. --}}
    <aside class="space-y-5">

        {{-- Panduan pengisian field --}}
        <div class="bg-white border border-blue-100 shadow-sm rounded-2xl p-5">
            <div class="flex items-center gap-2">
                <span class="w-8 h-8 shrink-0 rounded-lg bg-blue-50 text-[#1976d2] flex items-center justify-center">
                    <svg class="h-4 w-4" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8"
                         stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <circle cx="10" cy="10" r="7"/>
                        <path d="M10 9v4.5M10 6.5h.01"/>
                    </svg>
                </span>
                <p class="text-sm font-bold text-blue-950">Panduan Pengisian</p>
            </div>

            <dl class="mt-4 space-y-3.5 text-xs">
                <div>
                    <dt class="font-semibold text-blue-950">Kategori</dt>
                    <dd class="text-slate-500 mt-0.5 leading-relaxed">Rak tujuan penyimpanan. Menentukan lokasi fisik komponen di gudang.</dd>
                </div>
                <div>
                    <dt class="font-semibold text-blue-950">Kode SKU</dt>
                    <dd class="text-slate-500 mt-0.5 leading-relaxed">Identitas unik yang tidak boleh sama antar komponen. Otomatis jadi huruf kapital.</dd>
                </div>
                <div>
                    <dt class="font-semibold text-blue-950">Merk</dt>
                    <dd class="text-slate-500 mt-0.5 leading-relaxed">Nama pabrikan, misalnya Intel, AMD, ASUS, atau Logitech.</dd>
                </div>
                <div>
                    <dt class="font-semibold text-blue-950">Nama Komponen</dt>
                    <dd class="text-slate-500 mt-0.5 leading-relaxed">Nama lengkap beserta seri, supaya mudah dicari saat pencarian stok.</dd>
                </div>
                <div>
                    <dt class="font-semibold text-blue-950">Stok</dt>
                    <dd class="text-slate-500 mt-0.5 leading-relaxed">Jumlah unit fisik yang masuk. Di bawah 6 unit akan ditandai stok menipis.</dd>
                </div>
                <div>
                    <dt class="font-semibold text-blue-950">Harga Satuan</dt>
                    <dd class="text-slate-500 mt-0.5 leading-relaxed">Harga per unit dalam Rupiah. Isi angka saja tanpa titik atau koma.</dd>
                </div>
            </dl>
        </div>

        {{-- Alur penomoran SKU --}}
        <div class="bg-white border border-blue-100 shadow-sm rounded-2xl p-5">
            <p class="text-sm font-bold text-blue-950">Pola Kode SKU</p>
            <p class="text-xs text-slate-500 mt-1">Tiga bagian dipisah tanda hubung.</p>

            <div class="mt-3.5 flex items-center gap-1.5 font-mono text-[11px]">
                <span class="bg-blue-50 text-[#1565c0] font-semibold px-2 py-1 rounded-md border border-blue-100">KATEGORI</span>
                <span class="text-slate-300">-</span>
                <span class="bg-indigo-50 text-indigo-700 font-semibold px-2 py-1 rounded-md border border-indigo-100">MERK</span>
                <span class="text-slate-300">-</span>
                <span class="bg-teal-50 text-teal-700 font-semibold px-2 py-1 rounded-md border border-teal-100">MODEL</span>
            </div>

            <div class="mt-3.5 space-y-1.5">
                @foreach (['CPU-INT-13400F', 'VGA-ASU-4060', 'RAM-KNG-FURY16'] as $contoh)
                    <p class="font-mono text-[11px] text-slate-600 bg-slate-50 border border-slate-100 rounded-md px-2.5 py-1.5">{{ $contoh }}</p>
                @endforeach
            </div>
        </div>

        {{-- Tips operasional --}}
        <div class="bg-amber-50/60 border border-amber-200/70 rounded-2xl p-5">
            <div class="flex items-center gap-2">
                <span class="w-7 h-7 shrink-0 rounded-lg bg-amber-100 text-amber-700 flex items-center justify-center">
                    <svg class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.9"
                         stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M10 3v9M6.5 8.5L10 12l3.5-3.5M4 15.5h12"/>
                    </svg>
                </span>
                <p class="text-sm font-bold text-amber-900">Tips Cepat</p>
            </div>
            <ul class="mt-3 space-y-2 text-xs text-amber-900/80">
                <li class="flex gap-2"><span class="text-amber-500">•</span> Ganti nama komponen bila serinya berbeda, meski mereknya sama.</li>
                <li class="flex gap-2"><span class="text-amber-500">•</span> Komponen dengan stok menipis muncul otomatis di menu Cek Stok Menipis.</li>
                <li class="flex gap-2"><span class="text-amber-500">•</span> Cek dulu kode SKU di halaman Data Komponen agar tidak duplikat.</li>
            </ul>
        </div>

    </aside>

    </div>

    @if ($categories->isEmpty())
        <div class="mt-4 max-w-2xl bg-white border border-amber-300 text-amber-700 text-xs px-4 py-3 rounded-xl shadow-sm">
            Belum ada kategori. Jalankan <code class="font-mono">php artisan migrate:fresh --seed</code> agar dropdown terisi.
        </div>
    @endif

    <script>
        (function () {
            // Input SKU: paksa huruf kapital pada NILAI, bukan hanya tampilan CSS,
            // supaya yang tersimpan di database benar-benar huruf besar.
            var sku = document.querySelector('[data-uppercase]');
            if (sku) {
                sku.addEventListener('input', function () {
                    var start = sku.selectionStart;
                    sku.value = sku.value.toUpperCase();
                    sku.setSelectionRange(start, start);
                });
            }

            // Preview Rupiah real-time. Elemen terpisah, nilai input tetap integer murni.
            var harga = document.getElementById('harga');
            var preview = document.getElementById('harga-preview');
            if (harga && preview) {
                var render = function () {
                    var n = parseInt(harga.value, 10);
                    if (!harga.value || isNaN(n) || n <= 0) {
                        preview.classList.add('hidden');
                        preview.textContent = '';
                        return;
                    }
                    preview.textContent = 'Preview: Rp ' + new Intl.NumberFormat('id-ID').format(n);
                    preview.classList.remove('hidden');
                };
                harga.addEventListener('input', render);
                render();
            }
        })();
    </script>
@endsection
