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
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0', transform: 'translateY(0.5rem)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                    },
                    animation: {
                        fadeIn: 'fadeIn 300ms ease-out both',
                    },
                },
            },
        };
    </script>
</head>
<body class="antialiased bg-[#e3f2fd]">
    <div class="min-h-screen bg-[#e3f2fd] text-slate-700 flex">

        {{-- Left Sidebar --}}
        @include('partials.navbar')

        {{-- Main Content --}}
        <div class="flex-1 flex flex-col min-w-0">

            {{-- Top Header --}}
            <header class="shrink-0 bg-white border-b border-blue-200 px-8 py-3 flex flex-wrap items-center justify-between gap-3">
                <div class="min-w-0">
                    <h1 class="text-sm font-semibold text-[#0d47a1]">@yield('header_title', 'Overview')</h1>
                    <p class="text-[11px] text-slate-600 mt-0.5">@yield('header_subtitle', 'Ringkasan real-time pergerakan inventaris dan status stok komponen PC')</p>
                </div>
            </header>

            <main class="p-8 max-w-6xl w-full animate-fadeIn">

                @if (session('success'))
                    <div id="flash-success"
                         role="status"
                         class="bg-white border border-emerald-300 text-emerald-700 text-xs px-4 py-3 rounded-xl shadow-sm mb-6 flex items-center justify-between gap-4 transition-opacity duration-300">
                        <p class="min-w-0 truncate">
                            <span class="font-semibold">Berhasil.</span>
                            {{ session('success') }}
                        </p>
                        <button type="button" onclick="document.getElementById('flash-success').remove()"
                                aria-label="Tutup notifikasi"
                                class="shrink-0 rounded p-0.5 text-emerald-600/70 transition-all duration-200 hover:bg-emerald-50 hover:text-emerald-700 active:scale-[0.98]">
                            <svg class="w-3.5 h-3.5" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2"
                                 stroke-linecap="round" aria-hidden="true">
                                <path d="M5 5l10 10M15 5L5 15"/>
                            </svg>
                        </button>
                    </div>

                    <script>
                        (function () {
                            var el = document.getElementById('flash-success');
                            if (!el) return;

                            window.setTimeout(function () {
                                el.classList.add('opacity-0');
                                window.setTimeout(function () { el.remove(); }, 300);
                            }, 5000);
                        })();
                    </script>
                @endif

                @yield('content')

            </main>
        </div>

    </div>

    <script>
        (function () {
            var table = document.querySelector('[data-table]');
            if (!table) return;

            var input    = document.getElementById('table-search');
            var emptyRow = document.getElementById('no-result-row');
            var counter  = document.getElementById('row-count');
            var tbody    = table.querySelector('tbody');
            var csvBtn   = document.getElementById('csv-export');

            var fokusMenipis = new URLSearchParams(location.search).get('fokus') === 'menipis';
            var filterBadge  = document.getElementById('fokus-menipis');

            function rows() {
                return Array.prototype.slice.call(tbody.querySelectorAll('[data-search-row]'));
            }

            function visibleRows() {
                return rows().filter(function (r) { return !r.classList.contains('hidden'); });
            }

            function applySearch() {
                var q = input ? input.value.trim().toLowerCase() : '';
                var list = rows();
                var shown = 0;

                list.forEach(function (row) {
                    var match = row.textContent.toLowerCase().indexOf(q) !== -1;
                    if (match && fokusMenipis) {
                        match = parseFloat(row.dataset.sortstok || '0') <= 5;
                    }
                    row.classList.toggle('hidden', !match);
                    if (match) shown++;
                });

                if (counter) counter.textContent = shown;
                if (emptyRow) emptyRow.classList.toggle('hidden', !(shown === 0 && list.length > 0));
            }

            if (filterBadge) {
                filterBadge.classList.toggle('hidden', !fokusMenipis);
                filterBadge.classList.toggle('flex', fokusMenipis);
            }

           
            var resetBtn = document.getElementById('fokus-reset');
            if (resetBtn) {
                resetBtn.addEventListener('click', function () {
                    fokusMenipis = false;
                    if (filterBadge) {
                        filterBadge.classList.add('hidden');
                        filterBadge.classList.remove('flex');
                    }
                   
                    if (window.history.replaceState) {
                        window.history.replaceState({}, '', location.pathname);
                    }
                    applySearch();
                });
            }

            if (input) input.addEventListener('input', applySearch);

            
            var headers = table.querySelectorAll('th[data-sort]');
            headers.forEach(function (th) {
                th.addEventListener('click', function () {
                    var key  = th.dataset.sort;
                    var asc  = th.dataset.dir !== 'asc';

                    headers.forEach(function (other) {
                        delete other.dataset.dir;
                        var mark = other.querySelector('[data-arrow]');
                        if (mark) mark.textContent = '';
                    });

                    th.dataset.dir = asc ? 'asc' : 'desc';
                    var arrow = th.querySelector('[data-arrow]');
                    if (arrow) arrow.textContent = asc ? '\u25B2' : '\u25BC';

                    var sorted = rows().sort(function (a, b) {
                        var x = parseFloat(a.dataset['sort' + key] || 0);
                        var y = parseFloat(b.dataset['sort' + key] || 0);
                        return asc ? x - y : y - x;
                    });

                    sorted.forEach(function (row) { tbody.appendChild(row); });
                    applySearch();
                });
            });

            
            if (csvBtn) {
                csvBtn.addEventListener('click', function () {
                    var list = visibleRows();
                    if (!list.length) return;

                    var headCells = table.querySelectorAll('thead th');
                    var lines = [];
                    var head = [];
                    headCells.forEach(function (th) {
                        var label = (th.dataset.label || th.textContent).replace(/[\u25B2\u25BC]/g, '').trim();
                        head.push(csvCell(label));
                    });
                    lines.push(head.join(';'));

                    list.forEach(function (row) {
                        var cells = [];
                        row.querySelectorAll('td').forEach(function (td) {
                            cells.push(csvCell(td.innerText.replace(/\s+/g, ' ').trim()));
                        });
                        lines.push(cells.join(';'));
                    });

                    
                    var blob = new Blob(['\uFEFF' + lines.join('\r\n')], { type: 'text/csv;charset=utf-8;' });
                    var url  = URL.createObjectURL(blob);
                    var a    = document.createElement('a');
                    a.href = url;
                    a.download = (csvBtn.dataset.filename || 'laporan-stok') + '.csv';
                    document.body.appendChild(a);
                    a.click();
                    document.body.removeChild(a);
                    URL.revokeObjectURL(url);
                });
            }

            
            function csvCell(v) {
                return '"' + String(v).replace(/"/g, '""') + '"';
            }

            applySearch();
        })();
    </script>
</body>
</html>
