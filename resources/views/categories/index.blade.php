@extends('layouts.app')

@section('title', 'Daftar Kategori - CyberRig Inventory')
@section('heading', 'Daftar Kategori Komponen')
@section('subheading', 'Ringkasan jenis barang dan total stok fisik per rak penyimpanan.')

@section('content')
    <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
        @forelse ($categories as $category)
            <article class="flex flex-col rounded-xl border border-slate-200 bg-white p-5 shadow-sm transition hover:shadow-md">
                <div class="mb-3 flex items-start justify-between gap-3">
                    <h2 class="text-lg font-bold text-slate-900">{{ $category->nama_kategori }}</h2>
                    <span class="shrink-0 rounded-full bg-brand-50 px-3 py-1 text-xs font-semibold text-brand-700">
                        {{ $category->kode_rak }}
                    </span>
                </div>

                <p class="mb-4 grow text-sm text-slate-500">
                    {{ $category->deskripsi ?? 'Belum ada deskripsi untuk kategori ini.' }}
                </p>

                <dl class="mb-4 grid grid-cols-2 gap-3 border-t border-slate-100 pt-4 text-sm">
                    <div>
                        <dt class="text-xs uppercase tracking-wide text-slate-400">Jenis Barang</dt>
                        <dd class="text-lg font-bold text-slate-900">{{ $category->items_count }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs uppercase tracking-wide text-slate-400">Total Stok Fisik</dt>
                        <dd class="text-lg font-bold text-slate-900">{{ $category->items->sum('stok') }}</dd>
                    </div>
                </dl>

                <a href="{{ route('categories.show', $category->id) }}"
                   class="rounded-md border border-brand-600 px-3 py-2 text-center text-sm font-semibold text-brand-700 hover:bg-brand-600 hover:text-white">
                    Lihat Detail Kategori
                </a>
            </article>
        @empty
            <p class="rounded-lg border border-dashed border-slate-300 bg-white px-4 py-6 text-sm text-slate-500 sm:col-span-2 lg:col-span-3">
                Belum ada kategori pada database. Jalankan <code class="rounded bg-slate-100 px-1">php artisan migrate:fresh --seed</code>.
            </p>
        @endforelse
    </div>
@endsection
