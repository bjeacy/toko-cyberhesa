<aside class="w-60 shrink-0 border-r border-blue-200 min-h-screen flex flex-col justify-between bg-[#90caf9]">

    <div>
        {{-- Brand Header --}}
        <div class="h-14 px-5 flex items-center justify-between border-b border-blue-200">
            <a href="{{ route('categories.index') }}" class="flex items-center gap-2">
                <span class="flex h-6 w-6 items-center justify-center text-blue-950">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                         stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <rect x="7" y="7" width="10" height="10" rx="2"/>
                        <path d="M10 2v3M14 2v3M10 19v3M14 19v3M2 10h3M2 14h3M19 10h3M19 14h3"/>
                    </svg>
                </span>
                <span class="font-bold text-lg tracking-tight text-blue-950">cyberhesa</span>
            </a>
            <span class="text-blue-800/70">
                <svg class="h-4 w-4" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8"
                     stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <rect x="2.5" y="3.5" width="15" height="13" rx="2"/>
                    <path d="M7.5 3.5v13"/>
                </svg>
            </span>
        </div>

        @php
            // Sidebar biru cerah: teks biru sangat tua agar kontras tinggi.
            $idle = 'flex items-center gap-2.5 px-3 py-2 rounded-lg text-blue-950 font-medium transition hover:text-blue-900 hover:bg-blue-500/20';
            $active = 'flex items-center gap-2.5 px-3 py-2 bg-[#0d47a1] text-white font-semibold rounded-lg shadow-sm transition';
            $groupLabel = 'text-[10px] font-mono uppercase tracking-wider text-blue-950 font-bold px-3 mt-5 mb-2';
        @endphp

        <nav class="px-3 pb-4 text-sm">

            {{-- Grup: UTAMA --}}
            <p class="{{ $groupLabel }}">Utama</p>
            <div class="space-y-1">
                <a href="{{ route('categories.index') }}"
                   class="{{ request()->routeIs('categories.index') ? $active : $idle }}">
                    <svg class="h-4 w-4 shrink-0 {{ request()->routeIs('categories.index') ? 'text-white' : 'text-blue-950' }}" viewBox="0 0 20 20" fill="none" stroke="currentColor"
                         stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <rect x="2.5" y="2.5" width="6" height="6" rx="1.5"/>
                        <rect x="11.5" y="2.5" width="6" height="6" rx="1.5"/>
                        <rect x="2.5" y="11.5" width="6" height="6" rx="1.5"/>
                        <rect x="11.5" y="11.5" width="6" height="6" rx="1.5"/>
                    </svg>
                    Dashboard
                </a>

                <a href="{{ route('items.create') }}"
                   class="{{ request()->routeIs('items.create') ? $active : $idle }}">
                    <svg class="h-4 w-4 shrink-0 {{ request()->routeIs('items.create') ? 'text-white' : 'text-blue-950' }}" viewBox="0 0 20 20" fill="none" stroke="currentColor"
                         stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M10 3v9"/>
                        <path d="M6.5 8.5L10 12l3.5-3.5"/>
                        <path d="M4 15.5h12"/>
                    </svg>
                    Input Barang Masuk
                </a>
            </div>

            {{-- Grup: KOMPONEN KOMPUTER --}}
            <p class="{{ $groupLabel }}">Komponen Komputer</p>
            <div class="space-y-1">
                <a href="{{ route('categories.show', 1) }}" class="{{ $idle }}">
                    <span class="w-1.5 h-1.5 rounded-full bg-blue-700 shrink-0"></span>
                    <span class="truncate">Processor</span>
                </a>
                <a href="{{ route('categories.show', 2) }}" class="{{ $idle }}">
                    <span class="w-1.5 h-1.5 rounded-full bg-indigo-600 shrink-0"></span>
                    <span class="truncate">VGA / GPU</span>
                </a>
                <a href="{{ route('categories.show', 3) }}" class="{{ $idle }}">
                    <span class="w-1.5 h-1.5 rounded-full bg-cyan-700 shrink-0"></span>
                    <span class="truncate">RAM &amp; Storage</span>
                </a>
                <a href="{{ route('categories.show', 4) }}" class="{{ $idle }}">
                    <span class="w-1.5 h-1.5 rounded-full bg-sky-700 shrink-0"></span>
                    <span class="truncate">Gaming Gear</span>
                </a>
            </div>
        </nav>
    </div>

    {{-- User Profile Footer --}}
    <div class="p-4 border-t border-blue-200 flex items-center gap-3">
        <span class="w-8 h-8 shrink-0 rounded-full bg-[#0d47a1] text-white font-semibold text-xs flex items-center justify-center">R</span>
        <span class="min-w-0">
            <span class="block text-xs font-bold text-blue-950 truncate">Rakha Fernandes</span>
            <span class="block text-[11px] text-blue-900 truncate">Admin Inventaris</span>
        </span>
    </div>

</aside>
