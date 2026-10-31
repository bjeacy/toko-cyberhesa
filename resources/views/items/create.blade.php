@extends('layouts.app')

@section('title', 'Tambah Barang - CyberRig Inventory')
@section('heading', 'Form Tambah Barang')
@section('subheading', 'Lengkapi data barang, lalu simpan untuk menambahkannya ke kategori.')

@section('content')
    <form action="{{ route('items.store') }}" method="POST"
          class="max-w-2xl rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
        @csrf

        <div class="grid gap-5 sm:grid-cols-2">

            <div class="sm:col-span-2">
                <label for="category_id" class="mb-1 block text-sm font-medium text-slate-700">Kategori</label>
                <select name="category_id" id="category_id"
                        class="w-full rounded-md border px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-brand-500
                               {{ $errors->has('category_id') ? 'border-red-400 bg-red-50' : 'border-slate-300' }}">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ old('category_id', request('category_id')) == $category->id ? 'selected' : '' }}>
                            {{ $category->nama_kategori }} ({{ $category->kode_rak }})
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="kode_sku" class="mb-1 block text-sm font-medium text-slate-700">Kode SKU</label>
                <input type="text" name="kode_sku" id="kode_sku" value="{{ old('kode_sku') }}"
                       placeholder="Contoh: CPU-INT-13400F"
                       class="w-full rounded-md border px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-brand-500
                              {{ $errors->has('kode_sku') ? 'border-red-400 bg-red-50' : 'border-slate-300' }}">
                @error('kode_sku')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="merk" class="mb-1 block text-sm font-medium text-slate-700">Merk</label>
                <input type="text" name="merk" id="merk" value="{{ old('merk') }}"
                       placeholder="Contoh: Intel"
                       class="w-full rounded-md border px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-brand-500
                              {{ $errors->has('merk') ? 'border-red-400 bg-red-50' : 'border-slate-300' }}">
                @error('merk')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="sm:col-span-2">
                <label for="nama_barang" class="mb-1 block text-sm font-medium text-slate-700">Nama Barang</label>
                <input type="text" name="nama_barang" id="nama_barang" value="{{ old('nama_barang') }}"
                       placeholder="Contoh: Intel Core i5-13400F"
                       class="w-full rounded-md border px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-brand-500
                              {{ $errors->has('nama_barang') ? 'border-red-400 bg-red-50' : 'border-slate-300' }}">
                @error('nama_barang')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="stok" class="mb-1 block text-sm font-medium text-slate-700">Stok</label>
                <input type="number" name="stok" id="stok" min="0" value="{{ old('stok', 0) }}"
                       class="w-full rounded-md border px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-brand-500
                              {{ $errors->has('stok') ? 'border-red-400 bg-red-50' : 'border-slate-300' }}">
                @error('stok')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="harga" class="mb-1 block text-sm font-medium text-slate-700">Harga (Rupiah)</label>
                <input type="number" name="harga" id="harga" min="0" value="{{ old('harga') }}"
                       placeholder="Contoh: 2850000"
                       class="w-full rounded-md border px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-brand-500
                              {{ $errors->has('harga') ? 'border-red-400 bg-red-50' : 'border-slate-300' }}">
                @error('harga')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

        </div>

        <div class="mt-6 flex flex-wrap gap-3 border-t border-slate-100 pt-5">
            <button type="submit"
                    class="rounded-md bg-brand-600 px-4 py-2 text-sm font-semibold text-white hover:bg-brand-700">
                Simpan Barang
            </button>
            <a href="{{ route('items.index') }}"
               class="rounded-md border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100">
                Batal
            </a>
        </div>
    </form>
@endsection
