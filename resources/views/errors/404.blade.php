@extends('layouts.app')

@section('title', 'Halaman Tidak Ditemukan - cyberhesa')
@section('header_title', 'Halaman Tidak Ditemukan')
@section('header_subtitle', 'Data yang Anda cari tidak tersedia di inventaris')

@section('content')
    <div class="bg-white border border-blue-100 shadow-sm rounded-2xl p-8 max-w-xl text-left">
        <span class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"
                 stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <circle cx="11" cy="11" r="7"/>
                <path d="M16.5 16.5L21 21"/>
                <path d="M11 8v4M11 15h.01"/>
            </svg>
        </span>

        <p class="text-xs font-bold uppercase tracking-wider text-slate-400 mt-4">Error 404</p>
        <p class="text-xl font-sans font-extrabold tracking-tight text-blue-950 mt-2">
            Rak atau komponen tidak ditemukan
        </p>
        <p class="text-xs text-slate-500 mt-3">
            Kode rak yang Anda minta tidak terdaftar, atau sudah dihapus dari sistem inventaris.
        </p>

        <div class="flex flex-wrap items-center gap-2 mt-6 pt-5 border-t border-blue-100">
            <a href="{{ route('categories.index') }}"
               class="bg-[#2196f3] hover:bg-blue-600 active:scale-[0.98] text-white font-medium shadow-sm text-xs px-4 py-2 rounded-lg transition-all duration-200 inline-flex items-center gap-1.5">
                Kembali ke Dashboard
            </a>
            <a href="{{ route('items.index') }}"
               class="bg-white hover:bg-blue-50 active:scale-[0.98] text-slate-700 border border-blue-200 font-medium text-xs px-4 py-2 rounded-lg transition-all duration-200">
                Lihat Data Komponen
            </a>
        </div>
    </div>
@endsection
