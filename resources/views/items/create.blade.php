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

    <div class="bg-white border border-blue-100 shadow-sm rounded-2xl p-6 max-w-2xl">
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
                           placeholder="CPU-INT-13400F" autocomplete="off"
                           class="w-full bg-white border border-blue-200 rounded-xl px-3.5 py-2.5 text-sm font-mono text-blue-950 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#2196f3]/20
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
                    <p class="mt-1.5 text-xs text-slate-500">Nilai &le; 5 ditandai menipis</p>
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

    @if ($categories->isEmpty())
        <div class="mt-4 max-w-2xl bg-white border border-amber-300 text-amber-700 text-xs px-4 py-3 rounded-xl shadow-sm">
            Belum ada kategori. Jalankan <code class="font-mono">php artisan migrate:fresh --seed</code> agar dropdown terisi.
        </div>
    @endif
@endsection
