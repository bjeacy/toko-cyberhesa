<aside class="w-60 shrink-0 border-r border-blue-200/80 shadow-[2px_0_12px_rgba(33,150,243,0.04)] min-h-screen flex flex-col justify-between bg-[#f8fbff]">

    <div>
        {{-- Brand Header --}}
        <div class="h-14 px-5 flex items-center justify-between border-b border-blue-100 bg-white">
            <a href="{{ route('categories.index') }}" class="flex items-center gap-2.5">
                <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-50 text-[#1976d2] p-1.5">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                         stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <rect x="7" y="7" width="10" height="10" rx="2"/>
                        <path d="M10 2v3M14 2v3M10 19v3M14 19v3M2 10h3M2 14h3M19 10h3M19 14h3"/>
                    </svg>
                </span>
                <span class="font-bold text-lg tracking-tight text-blue-950">cyberhesa</span>
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
            // Clean Ice-White Enterprise: latar terang, teks slate, aksen biru saat aktif.
            $idle = 'group flex items-center gap-2.5 px-3 py-2 rounded-lg text-slate-700 font-medium transition hover:bg-blue-50/80 hover:text-[#1565c0]';
            $active = 'flex items-center gap-2.5 px-3 py-2 bg-[#1976d2] text-white font-semibold rounded-lg shadow-sm shadow-blue-500/20 transition';
            $groupLabel = 'text-[11px] font-bold uppercase tracking-wider text-slate-400 px-3 mt-5 mb-2';
        @endphp

        <nav class="px-3 pb-4 text-sm">

            {{-- Grup: MAIN --}}
            <p class="{{ $groupLabel }}">Main</p>
            <div class="space-y-1">
                <a href="{{ route('categories.index') }}"
                   class="{{ request()->routeIs('categories.index') ? $active : $idle }}">
                    <svg class="h-4 w-4 shrink-0 {{ request()->routeIs('categories.index') ? 'text-white' : 'text-slate-500 group-hover:text-[#1565c0]' }}" viewBox="0 0 20 20" fill="none" stroke="currentColor"
                         stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <rect x="2.5" y="2.5" width="6" height="6" rx="1.5"/>
                        <rect x="11.5" y="2.5" width="6" height="6" rx="1.5"/>
                        <rect x="2.5" y="11.5" width="6" height="6" rx="1.5"/>
                        <rect x="11.5" y="11.5" width="6" height="6" rx="1.5"/>
                    </svg>
                    Dashboard
                </a>
            </div>

            {{-- Grup: DATA MASTER --}}
            <p class="{{ $groupLabel }}">Data Master</p>
            <div class="space-y-1">

                {{-- Dropdown Kategori Rak. Terbuka otomatis saat halaman detail rak dibuka. --}}
                <div data-nav-dropdown="{{ request()->routeIs('categories.show') ? 'open' : 'closed' }}">
                    <button type="button" data-nav-toggle aria-expanded="false"
                            class="w-full {{ $idle }} {{ request()->routeIs('categories.show') ? 'bg-blue-50 text-[#1565c0]' : '' }}">
                        <svg class="h-4 w-4 shrink-0 {{ request()->routeIs('categories.show') ? 'text-[#1565c0]' : 'text-slate-500 group-hover:text-[#1565c0]' }}" viewBox="0 0 20 20" fill="none" stroke="currentColor"
                             stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <rect x="2.5" y="2.5" width="15" height="15" rx="2"/>
                            <path d="M2.5 7.5h15M2.5 12.5h15M7.5 2.5v15"/>
                        </svg>
                        <span class="truncate text-left">Kategori Rak</span>
                        <svg data-nav-chevron class="ml-auto h-3.5 w-3.5 shrink-0 text-slate-400 transition-transform duration-200"
                             viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M5.5 7.5L10 12l4.5-4.5"/>
                        </svg>
                    </button>

                    <div data-nav-panel class="overflow-hidden transition-all duration-200 ease-out">
                        <div class="ml-4 mt-1 space-y-0.5 border-l border-blue-100 pl-2">
                            @forelse ($navCategories as $navCategory)
                                @php $navAktif = request()->routeIs('categories.show') && (int) request()->route('id') === $navCategory->id; @endphp
                                <a href="{{ route('categories.show', $navCategory->id) }}"
                                   class="flex items-center gap-2 px-2 py-1.5 rounded-md text-[13px] text-slate-600 font-medium transition hover:bg-blue-50/80 hover:text-[#1565c0] {{ $navAktif ? 'bg-blue-50 text-[#1565c0] font-semibold' : '' }}">
                                    <span class="w-1.5 h-1.5 rounded-full shrink-0 {{ $navAktif ? 'bg-[#1976d2]' : 'bg-slate-300' }}"></span>
                                    <span class="truncate">{{ $navCategory->nama_kategori }}</span>
                                    <span class="ml-auto shrink-0 rounded px-1.5 py-0.5 font-mono text-[10px] {{ $navAktif ? 'bg-blue-100 text-[#1565c0]' : 'bg-slate-100 text-slate-500' }}">
                                        {{ $navCategory->items_count }}
                                    </span>
                                </a>
                            @empty
                                <p class="px-2 py-1.5 text-[11px] text-slate-400">Belum ada kategori.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <a href="{{ route('items.index') }}"
                   class="{{ request()->routeIs('items.index') && request('fokus') !== 'menipis' ? $active : $idle }}">
                    <svg class="h-4 w-4 shrink-0 {{ request()->routeIs('items.index') && request('fokus') !== 'menipis' ? 'text-white' : 'text-slate-500 group-hover:text-[#1565c0]' }}" viewBox="0 0 20 20" fill="none" stroke="currentColor"
                         stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <rect x="2.5" y="3.5" width="15" height="5" rx="1.5"/>
                        <rect x="2.5" y="11.5" width="15" height="5" rx="1.5"/>
                        <path d="M6 6h.01M6 14h.01"/>
                    </svg>
                    Data Komponen
                </a>
            </div>

            {{-- Grup: MAIN MENU --}}
            <p class="{{ $groupLabel }}">Main Menu</p>
            <div class="space-y-1">
                <a href="{{ route('items.create') }}"
                   class="{{ request()->routeIs('items.create') ? $active : $idle }}">
                    <svg class="h-4 w-4 shrink-0 {{ request()->routeIs('items.create') ? 'text-white' : 'text-slate-500 group-hover:text-[#1565c0]' }}" viewBox="0 0 20 20" fill="none" stroke="currentColor"
                         stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M10 3v9"/>
                        <path d="M6.5 8.5L10 12l3.5-3.5"/>
                        <path d="M4 15.5h12"/>
                    </svg>
                    Input Barang Masuk
                </a>

                <a href="{{ route('items.index', ['fokus' => 'menipis']) }}"
                   class="{{ request()->routeIs('items.index') && request('fokus') === 'menipis' ? $active : $idle }}">
                    <svg class="h-4 w-4 shrink-0 {{ request()->routeIs('items.index') && request('fokus') === 'menipis' ? 'text-white' : 'text-slate-500 group-hover:text-[#1565c0]' }}" viewBox="0 0 20 20" fill="none" stroke="currentColor"
                         stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M3 16.5V3.5"/>
                        <path d="M3 16.5h14"/>
                        <rect x="6" y="10.5" width="2.5" height="3.5" rx="0.5"/>
                        <rect x="10.5" y="7" width="2.5" height="7" rx="0.5"/>
                    </svg>
                    Cek Stok Menipis
                </a>
            </div>
        </nav>
    </div>

    {{-- User Profile Footer --}}
    <div class="p-4 border-t border-blue-100 bg-blue-50/50 flex items-center gap-3">
        <span class="w-8 h-8 shrink-0 rounded-full bg-[#1976d2] text-white font-semibold text-xs flex items-center justify-center">R</span>
        <span class="min-w-0">
            <span class="block text-xs font-semibold text-blue-950 truncate">Rakha Fernandes</span>
            <span class="block text-[11px] text-slate-500 truncate">Admin Inventaris</span>
        </span>
    </div>

    <script>
        // Dropdown data master: buka/tutup manual, animasi tinggi via max-height.
        (function () {
            var wrap = document.querySelector('[data-nav-dropdown]');
            if (!wrap) return;

            var btn     = wrap.querySelector('[data-nav-toggle]');
            var panel   = wrap.querySelector('[data-nav-panel]');
            var chevron = wrap.querySelector('[data-nav-chevron]');
            var open    = wrap.dataset.navDropdown === 'open';

            function render(animate) {
                panel.style.maxHeight = open ? panel.scrollHeight + 'px' : '0px';
                panel.style.opacity = open ? '1' : '0';
                chevron.style.transform = open ? 'rotate(180deg)' : '';
                btn.setAttribute('aria-expanded', open ? 'true' : 'false');
                if (!animate) panel.style.transition = 'none';
            }

            render(false);
            // Lepas transition-none setelah frame pertama supaya toggle tetap mulus.
            requestAnimationFrame(function () { panel.style.transition = ''; });

            btn.addEventListener('click', function () {
                open = !open;
                render(true);
            });
        })();
    </script>

</aside>
