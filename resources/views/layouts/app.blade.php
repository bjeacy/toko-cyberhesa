<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'cyberhesa Inventory')</title>

    {{-- Google Fonts: Inter untuk teks UI, JetBrains Mono untuk angka/SKU/harga --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                        mono: ['"JetBrains Mono"', 'ui-monospace', 'SFMono-Regular', 'monospace'],
                    },
                },
            },
        };
    </script>
</head>
<body class="antialiased">
    <div class="min-h-screen bg-[#0f172a] text-slate-200 flex">

        {{-- Left Sidebar --}}
        @include('partials.navbar')

        {{-- Main Content --}}
        <div class="flex-1 flex flex-col min-w-0">

            {{-- Top Header --}}
            <header class="shrink-0 bg-[#0d1526] border-b border-slate-700/70 px-8 py-3 flex flex-wrap items-center justify-between gap-3">
                <div class="min-w-0">
                    <h1 class="text-sm font-semibold text-white">@yield('header_title', 'Overview')</h1>
                    <p class="text-[11px] text-slate-300 mt-0.5">@yield('header_subtitle', 'Ringkasan real-time pergerakan inventaris dan status stok komponen PC')</p>
                </div>
            </header>

            <main class="p-8 max-w-6xl w-full">

                @if (session('success'))
                    <div id="flash-success"
                         role="status"
                         class="bg-[#1e293b] border border-emerald-500/40 text-emerald-300 text-xs px-4 py-3 rounded-lg mb-6 flex items-center justify-between gap-4">
                        <p class="min-w-0 truncate">
                            <span class="font-semibold">Berhasil.</span>
                            {{ session('success') }}
                        </p>
                        <button type="button" onclick="document.getElementById('flash-success').remove()"
                                aria-label="Tutup notifikasi"
                                class="shrink-0 rounded p-0.5 text-emerald-400/70 transition hover:bg-emerald-500/10 hover:text-emerald-300">
                            <svg class="w-3.5 h-3.5" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2"
                                 stroke-linecap="round" aria-hidden="true">
                                <path d="M5 5l10 10M15 5L5 15"/>
                            </svg>
                        </button>
                    </div>
                @endif

                @yield('content')

            </main>
        </div>

    </div>
</body>
</html>
