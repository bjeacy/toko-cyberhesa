<aside class="w-60 shrink-0 border-r border-slate-700/70 min-h-screen flex flex-col justify-between bg-[#0d1526]">

    <div>
        {{-- Brand Header --}}
        <div class="h-14 px-5 flex items-center justify-between border-b border-slate-700/70">
            <a href="{{ route('categories.index') }}" class="flex items-center gap-2">
                <span class="flex h-6 w-6 items-center justify-center text-white">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                         stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <rect x="7" y="7" width="10" height="10" rx="2"/>
                        <path d="M10 2v3M14 2v3M10 19v3M14 19v3M2 10h3M2 14h3M19 10h3M19 14h3"/>
                    </svg>
                </span>
                <span class="font-bold text-lg tracking-tight text-white">cyberhesa</span>
            </a>
            <span class="text-slate-400">
                <svg class="h-4 w-4" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8"
                     stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <rect x="2.5" y="3.5" width="15" height="13" rx="2"/>
                    <path d="M7.5 3.5v13"/>
                </svg>
            </span>
        </div>

        @php
            $idle = 'flex items-center gap-2.5 px-3 py-2 rounded-lg text-slate-400 hover:text-white hover:bg-slate-700/50 transition';
            $active = 'flex items-center gap-2.5 px-3 py-2 bg-[#253551] border border-blue-400/30 text-white font-medium rounded-lg transition';
            $groupLabel = 'text-[10px] font-mono uppercase tracking-wider text-slate-400 px-3 mt-5 mb-2';
        @endphp

        <nav class="px-3 pb-4 text-sm">

            {{-- Grup: UTAMA --}}
            <p class="{{ $groupLabel }}">Utama</p>
            <div class="space-y-1">
                <a href="{{ route('categories.index') }}"
                   class="{{ request()->routeIs('categories.index') ? $active : $idle }}">
                    <svg class="h-4 w-4 shrink-0 text-indigo-400" viewBox="0 0 20 20" fill="none" stroke="currentColor"
                         stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <rect x="2.5" y="2.5" width="6" height="6" rx="1.5"/>
                        <rect x="11.5" y="2.5" width="6" height="6" rx="1.5"/>
                        <rect x="2.5" y="11.5" width="6" height="6" rx="1.5"/>
                        <rect x="11.5" y="11.5" width="6" height="6" rx="1.5"/>
                    </svg>
                    Dashboard
                </a>

                <a href="{{ route('items.index') }}"
                   class="{{ request()->routeIs('items.index') ? $active : $idle }}">
                    <svg class="h-4 w-4 shrink-0 text-cyan-400" viewBox="0 0 20 20" fill="none" stroke="currentColor"
                         stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <ellipse cx="10" cy="5" rx="6" ry="2.5"/>
                        <path d="M4 5v10c0 1.38 2.69 2.5 6 2.5s6-1.12 6-2.5V5"/>
                        <path d="M4 10c0 1.38 2.69 2.5 6 2.5s6-1.12 6-2.5"/>
                    </svg>
                    Semua Komponen PC
                </a>

                <a href="{{ route('items.create') }}"
                   class="{{ request()->routeIs('items.create') ? $active : $idle }}">
                    <svg class="h-4 w-4 shrink-0 text-emerald-400" viewBox="0 0 20 20" fill="none" stroke="currentColor"
                         stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M10 3v9"/>
                        <path d="M6.5 8.5L10 12l3.5-3.5"/>
                        <path d="M4 15.5h12"/>
                    </svg>
                    Input Barang Masuk
                </a>
            </div>

            {{-- Grup: MASTER RAK KATEGORI --}}
            <p class="{{ $groupLabel }}">Master Rak Kategori</p>
            <div class="space-y-1">
                <a href="{{ route('categories.show', 1) }}" class="{{ $idle }}">
                    <span class="w-1.5 h-1.5 rounded-full bg-sky-400/80 shrink-0"></span>
                    <span class="truncate">Processor</span>
                </a>
                <a href="{{ route('categories.show', 2) }}" class="{{ $idle }}">
                    <span class="w-1.5 h-1.5 rounded-full bg-violet-400/80 shrink-0"></span>
                    <span class="truncate">VGA / GPU</span>
                </a>
                <a href="{{ route('categories.show', 3) }}" class="{{ $idle }}">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400/80 shrink-0"></span>
                    <span class="truncate">RAM &amp; Storage</span>
                </a>
                <a href="{{ route('categories.show', 4) }}" class="{{ $idle }}">
                    <span class="w-1.5 h-1.5 rounded-full bg-amber-400/80 shrink-0"></span>
                    <span class="truncate">Gaming Gear</span>
                </a>
            </div>

            {{-- Info statis --}}
            <p class="{{ $groupLabel }}">Sistem</p>
            <div class="space-y-1.5">
                <p class="flex items-center justify-between px-3 py-1 font-mono text-[10px] text-slate-400">
                    <span>Database</span><span class="text-slate-200">MySQL</span>
                </p>
                <p class="flex items-center justify-between px-3 py-1 font-mono text-[10px] text-slate-400">
                    <span>API Status</span>
                    <span class="inline-flex items-center gap-1.5 text-emerald-400">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>Active
                    </span>
                </p>
            </div>
        </nav>
    </div>

    {{-- User Profile Footer --}}
    <div class="p-4 border-t border-slate-700/70 flex items-center gap-3">
        <span class="w-8 h-8 shrink-0 rounded-full bg-rose-500 text-white font-semibold text-xs flex items-center justify-center">R</span>
        <span class="min-w-0">
            <span class="block text-xs font-medium text-slate-200 truncate">Rakha Fernandes</span>
            <span class="block text-[11px] text-slate-400 truncate">Admin Inventaris</span>
        </span>
    </div>

</aside>
