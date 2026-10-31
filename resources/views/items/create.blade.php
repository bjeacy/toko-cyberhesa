@extends('layouts.app')

@section('title', 'Input Komponen Baru - cyberhesa')
@section('header_title', 'Input Komponen Baru')
@section('header_subtitle', 'Catat barang masuk ke dalam rak kategori inventaris')

@section('content')
    {{-- Breadcrumb --}}
    <nav class="mb-6 flex items-center gap-2 text-xs" aria-label="Breadcrumb">
        <a href="{{ route('categories.index') }}" class="text-slate-400 hover:text-slate-200 transition">Overview</a>
        <span class="text-slate-400">/</span>
        <a href="{{ route('items.index') }}" class="text-slate-400 hover:text-slate-200 transition">Semua Komponen</a>
        <span class="text-slate-400">/</span>
        <span class="text-slate-200">Input Baru</span>
    </nav>

    <div class="bg-[#1e293b] border border-slate-700/80 rounded-xl p-6 max-w-2xl shadow-sm">
        <div class="mb-6">
            <p class="text-sm font-semibold text-white">Data Komponen</p>
            <p class="text-xs text-slate-300 mt-1">Kolom bertanda <span class="text-white">*</span> wajib diisi.</p>
        </div>

        <form action="{{ route('items.store') }}" method="POST" class="space-y-5">
            @csrf

            {{-- Kategori --}}
            <div>
                <label for="category_id" class="mb-1.5 block text-xs font-medium text-slate-300">
                    Kategori <span class="text-slate-400">*</span>
                </label>
                <select name="category_id" id="category_id"
                        class="w-full bg-[#0f172a] border rounded-lg px-3.5 py-2 text-xs text-slate-100 focus:outline-none
                               {{ $errors->has('category_id') ? 'border-rose-500/60 focus:border-rose-500' : 'border-slate-600/80 focus:border-[#a5c4ff]' }}">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ old('category_id', request('category_id')) == $category->id ? 'selected' : '' }}>
                            {{ $category->nama_kategori }} ({{ $category->kode_rak }})
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="mt-1.5 text-[11px] text-rose-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                {{-- Kode SKU --}}
                <div>
                    <label for="kode_sku" class="mb-1.5 block text-xs font-medium text-slate-300">
                        Kode SKU <span class="text-slate-400">*</span>
                    </label>
                    <input type="text" name="kode_sku" id="kode_sku" value="{{ old('kode_sku') }}"
                           placeholder="CPU-INT-13400F" autocomplete="off"
                           class="w-full bg-[#0f172a] border rounded-lg px-3.5 py-2 text-xs font-mono text-slate-100 placeholder-slate-400 focus:outline-none
                                  {{ $errors->has('kode_sku') ? 'border-rose-500/60 focus:border-rose-500' : 'border-slate-600/80 focus:border-[#a5c4ff]' }}">
                    <p class="mt-1.5 text-[11px] text-slate-400">Format: KATEGORI-MERK-MODEL</p>
                    @error('kode_sku')
                        <p class="mt-1.5 text-[11px] text-rose-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Merk --}}
                <div>
                    <label for="merk" class="mb-1.5 block text-xs font-medium text-slate-300">
                        Merk <span class="text-slate-400">*</span>
                    </label>
                    <input type="text" name="merk" id="merk" value="{{ old('merk') }}"
                           placeholder="Intel" autocomplete="off"
                           class="w-full bg-[#0f172a] border rounded-lg px-3.5 py-2 text-xs text-slate-100 placeholder-slate-400 focus:outline-none
                                  {{ $errors->has('merk') ? 'border-rose-500/60 focus:border-rose-500' : 'border-slate-600/80 focus:border-[#a5c4ff]' }}">
                    @error('merk')
                        <p class="mt-1.5 text-[11px] text-rose-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Nama Barang --}}
            <div>
                <label for="nama_barang" class="mb-1.5 block text-xs font-medium text-slate-300">
                    Nama Komponen <span class="text-slate-400">*</span>
                </label>
                <input type="text" name="nama_barang" id="nama_barang" value="{{ old('nama_barang') }}"
                       placeholder="Intel Core i5-13400F" autocomplete="off"
                       class="w-full bg-[#0f172a] border rounded-lg px-3.5 py-2 text-xs text-slate-100 placeholder-slate-400 focus:outline-none
                              {{ $errors->has('nama_barang') ? 'border-rose-500/60 focus:border-rose-500' : 'border-slate-600/80 focus:border-[#a5c4ff]' }}">
                @error('nama_barang')
                    <p class="mt-1.5 text-[11px] text-rose-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                {{-- Stok --}}
                <div>
                    <label for="stok" class="mb-1.5 block text-xs font-medium text-slate-300">
                        Stok <span class="text-slate-400">*</span>
                    </label>
                    <input type="number" name="stok" id="stok" min="0" step="1" value="{{ old('stok', 0) }}"
                           class="w-full bg-[#0f172a] border rounded-lg px-3.5 py-2 text-xs font-mono text-slate-100 focus:outline-none
                                  {{ $errors->has('stok') ? 'border-rose-500/60 focus:border-rose-500' : 'border-slate-600/80 focus:border-[#a5c4ff]' }}">
                    <p class="mt-1.5 text-[11px] text-slate-400">Nilai &le; 5 ditandai menipis</p>
                    @error('stok')
                        <p class="mt-1.5 text-[11px] text-rose-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Harga --}}
                <div>
                    <label for="harga" class="mb-1.5 block text-xs font-medium text-slate-300">
                        Harga Satuan <span class="text-slate-400">*</span>
                    </label>
                    <div class="relative">
                        <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center rounded-l-lg border-r border-slate-600/80 bg-[#0f172a] px-3 font-mono text-[11px] text-slate-400">Rp</span>
                        <input type="number" name="harga" id="harga" min="0" step="1" value="{{ old('harga') }}"
                               placeholder="2850000"
                               class="w-full bg-[#0f172a] border rounded-lg pl-12 pr-3.5 py-2 text-xs font-mono text-slate-100 placeholder-slate-400 focus:outline-none
                                      {{ $errors->has('harga') ? 'border-rose-500/60 focus:border-rose-500' : 'border-slate-600/80 focus:border-[#a5c4ff]' }}">
                    </div>
                    <p class="mt-1.5 text-[11px] text-slate-400">Tanpa titik atau koma</p>
                    @error('harga')
                        <p class="mt-1.5 text-[11px] text-rose-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-3 border-t border-slate-700/70 pt-5">
                <button type="submit"
                        class="bg-[#a5c4ff] hover:bg-[#8eb4ff] text-[#0f172a] font-semibold text-xs px-5 py-2.5 rounded-lg transition inline-flex items-center gap-1.5">
                    <svg class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2.4"
                         stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M4 10.5l4 4 8-9"/>
                    </svg>
                    Simpan Barang
                </button>
                <a href="{{ route('items.index') }}"
                   class="bg-transparent hover:bg-slate-700/60 text-slate-200 border border-slate-600/80 font-medium text-xs px-3.5 py-2 rounded-lg transition">
                    Batal
                </a>
            </div>
        </form>
    </div>

    @if ($categories->isEmpty())
        <div class="mt-4 max-w-2xl bg-[#1e293b] border border-amber-500/40 text-amber-300 text-xs px-4 py-3 rounded-lg shadow-sm">
            Belum ada kategori. Jalankan <code class="font-mono">php artisan migrate:fresh --seed</code> agar dropdown terisi.
        </div>
    @endif
@endsection
