<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'CyberRig Inventory')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#ecfeff',
                            100: '#cffafe',
                            500: '#06b6d4',
                            600: '#0891b2',
                            700: '#0e7490',
                            900: '#164e63',
                        },
                    },
                },
            },
        };
    </script>
</head>
<body class="min-h-screen bg-slate-100 text-slate-800 antialiased">

    @include('partials.navbar')

    <main class="mx-auto max-w-6xl px-4 py-8">

        <header class="mb-6">
            <h1 class="text-2xl font-bold text-slate-900">@yield('heading', 'CyberRig Inventory')</h1>
            <p class="text-sm text-slate-500">@yield('subheading', 'Sistem Manajemen Inventaris & Kategori Toko Komputer')</p>
        </header>

        @if (session('success'))
            <div class="mb-6 rounded-lg border border-emerald-300 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')

    </main>

    <footer class="mx-auto max-w-6xl px-4 pb-10 text-center text-xs text-slate-400">
        CyberRig Inventory &mdash; UTS Pemrograman Web Tingkat Mahir (PG184)
    </footer>

</body>
</html>
