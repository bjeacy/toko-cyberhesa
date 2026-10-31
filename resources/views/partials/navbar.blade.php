<nav class="border-b border-slate-200 bg-white shadow-sm">
    <div class="mx-auto flex max-w-6xl flex-wrap items-center justify-between gap-4 px-4 py-3">

        <a href="{{ route('categories.index') }}" class="flex items-center gap-2 font-bold text-slate-900">
            <span class="rounded bg-brand-600 px-2 py-1 text-sm text-white">CR</span>
            CyberRig Inventory
        </a>

        <div class="flex flex-wrap items-center gap-2 text-sm">
            <a href="{{ route('categories.index') }}"
               class="rounded-md px-3 py-2 font-medium text-slate-600 hover:bg-slate-100 hover:text-brand-700 {{ request()->routeIs('categories.index') ? 'bg-slate-100 text-brand-700' : '' }}">
                Daftar Kategori
            </a>

            <a href="{{ route('items.index') }}"
               class="rounded-md px-3 py-2 font-medium text-slate-600 hover:bg-slate-100 hover:text-brand-700 {{ request()->routeIs('items.index') ? 'bg-slate-100 text-brand-700' : '' }}">
                Semua Barang
            </a>

            <a href="{{ route('items.create') }}"
               class="rounded-md bg-brand-600 px-3 py-2 font-semibold text-white hover:bg-brand-700">
                + Tambah Barang
            </a>
        </div>

    </div>
</nav>
