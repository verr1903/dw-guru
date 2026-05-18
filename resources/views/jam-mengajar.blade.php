<x-app title="Jam Mengajar | SMA Cendana Pekanbaru">

    {{-- ===== PAGE HEADER ===== --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Jam Mengajar</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola dan pantau distribusi jam mengajar tenaga pengajar</p>
        </div>
        <div class="flex items-center gap-3">
            <form method="GET" action="{{ route('jam-mengajar') }}" class="flex items-center gap-3">
                {{-- HAPUS baris ini: --}}
                {{-- <input type="hidden" name="tahun" value="{{ $tahun }}"> --}}
                <div class="relative">
                    <select name="tahun" onchange="this.form.submit()"
                        class="appearance-none bg-white border border-gray-200 rounded-xl px-4 py-2.5 pr-9 text-sm font-medium text-gray-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-amber-400 cursor-pointer">
                        <option value="all" {{ $tahun === 'all' ? 'selected' : '' }}>Semua Tahun</option>
                        @foreach($daftarTahun as $t)
                        <option value="{{ $t }}" {{ $tahun == $t ? 'selected' : '' }}>Tahun {{ $t }}</option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- ===== ROW 1: DONUT + BAR ===== --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 mb-5">


        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            {{-- Line Chart --}}
            <div class="flex items-center justify-between mb-0.5">
                <h2 class="text-sm font-semibold text-gray-800">Total Jam Mengajar Per Bulan</h2>
                <div class="flex items-center gap-4 text-xs text-gray-500">
                    <span class="flex items-center gap-1.5">
                        <span class="inline-block w-5 h-0.5 bg-green-500 rounded"></span> Jam Mengajar
                    </span>
                    <span class="flex items-center gap-1.5">
                        <span class="inline-block w-5 h-0.5 bg-red-400 rounded"></span> Kehadiran
                    </span>
                </div>
            </div>
            <p class="text-xs text-gray-400 mb-4">Perbandingan jam mengajar dan kehadiran per bulan</p>
            <div class="relative" style="height:240px;">
                <canvas id="lineChart"></canvas>
            </div>
        </div>

        {{-- Beban Per Mata Pelajaran (Bar vertikal, warna-warni) --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <h2 class="text-sm font-semibold text-gray-800 mb-0.5">Beban Per Mata Pelajaran</h2>
            <p class="text-xs text-gray-400 mb-4">
                Total jam mengajar per mata pelajaran
                {{ $isAll ? 'semua tahun' : 'tahun '.$tahun }}
            </p>
            <div class="relative" style="height:220px;">
                <canvas id="barChart"></canvas>
            </div>
        </div>
    </div>

    {{-- ===== ROW 2: LINE CHART + TABLE (side by side, like Power BI) ===== --}}
    <div class="grid grid-cols-1 lg:grid-cols-1 gap-5 mb-5">

        {{-- Distribusi Jam Mengajar Per Guru (Donut) --}}
        {{-- Distribusi Jam Mengajar Per Guru (Horizontal Bar) --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <h2 class="text-sm font-semibold text-gray-800 mb-0.5">Distribusi Jam Mengajar Per Guru</h2>
            <p class="text-xs text-gray-400 mb-4">
                Perbandingan jam mengajar tiap guru
                {{ $isAll ? 'semua tahun' : 'tahun '.$tahun }}
            </p>

            {{-- Metric summary --}}
            <div class="grid grid-cols-3 gap-3 mb-5">
                <div class="bg-gray-50 rounded-xl px-3 py-2.5">
                    <p class="text-xs text-gray-400">Total jam</p>
                    <p class="text-base font-semibold text-gray-800" id="distTotal">—</p>
                </div>
                <div class="bg-gray-50 rounded-xl px-3 py-2.5">
                    <p class="text-xs text-gray-400">Terbanyak</p>
                    <p class="text-base font-semibold text-gray-800" id="distTopJam">—</p>
                    <p class="text-xs text-gray-400 truncate" id="distTopName">—</p>
                </div>
                <div class="bg-gray-50 rounded-xl px-3 py-2.5">
                    <p class="text-xs text-gray-400">Rata-rata</p>
                    <p class="text-base font-semibold text-gray-800" id="distAvg">—</p>
                </div>
            </div>

            {{-- Bar chart container --}}
            <div id="distribusiChart" class="space-y-2"></div>

            
        </div>

        {{-- Detail Table (scrollable, compact) --}}
        <div id="detail-jam" class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden flex flex-col">

            {{-- Table Header + Search --}}
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 px-5 py-4 border-b border-gray-100">
                <div>
                    <h2 class="text-sm font-semibold text-gray-900">Detail Data Mengajar</h2>
                    <p class="text-xs text-gray-400 mt-0.5">Rincian jam mengajar per guru per bulan</p>
                </div>
                <div class="relative">
                    <input type="text" id="searchGuru" value="{{ $search }}"
                        placeholder="Cari nama guru..."
                        class="bg-gray-50 border border-gray-200 rounded-xl pl-9 pr-4 py-2 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-amber-400 w-44">
                    <svg class="w-4 h-4 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>

            {{-- Scrollable Table --}}
            <div class="">
                <table class="w-full text-sm">
                    <thead class="sticky top-0 z-10">
                        {{-- thead --}}
                        <tr class="bg-gray-50 border-b border-gray-100">
                            <th class="px-4 py-2.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Guru</th>
                            <th class="px-4 py-2.5 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Jam</th>
                            <th class="px-4 py-2.5 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Detail</th>
                            <th class="px-4 py-2.5 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50" id="tableBody">
                        {{-- tbody --}}
                        @forelse($tableData as $row)
                        @php
                        $persen = $row->total_hari_mengajar > 0
                        ? round(($row->jumlah_kehadiran / $row->total_hari_mengajar) * 100)
                        : 0;
                        $statusLabel = $persen >= 90 ? 'Memenuhi' : ($persen >= 75 ? 'Cukup' : 'Kurang');
                        $statusColor = $persen >= 90 ? 'bg-green-100 text-green-700'
                        : ($persen >= 75 ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700');
                        @endphp
                        <tr class="hover:bg-gray-50 transition-colors" data-nama="{{ strtolower($row->nama_guru) }}">
                            <td class="px-4 py-2.5 font-medium text-gray-800 text-xs">{{ $row->nama_guru }}</td>
                            <td class="px-4 py-2.5 text-right text-xs font-semibold text-gray-800">{{ $row->jumlah_jam_mengajar }}</td>
                            <td class="px-4 py-2.5 text-center">
                                <button
                                    onclick="bukaDetail({{ $row->id_guru }}, '{{ addslashes($row->nama_guru) }}', '{{ $tahun }}')"
                                    class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium bg-amber-50 text-amber-700 hover:bg-amber-100 transition-colors">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Lihat
                                </button>
                            </td>
                            <td class="px-4 py-2.5 text-center">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $statusColor }}">
                                    {{ $statusLabel }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-400 text-sm">Tidak ada data.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="px-5 py-3 border-t border-gray-100 flex items-center justify-between bg-white">
                <p class="text-xs text-gray-500">
                    {{ $tableData->firstItem() }}–{{ $tableData->lastItem() }} dari {{ $tableData->total() }}
                </p>
                <div class="flex items-center gap-1">
                    @if ($tableData->onFirstPage())
                    <span class="w-7 h-7 flex items-center justify-center rounded-lg text-gray-300 cursor-not-allowed">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </span>
                    @else
                    <a href="{{ $tableData->previousPageUrl() }}#detail-jam"
                        class="w-7 h-7 flex items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </a>
                    @endif

                    @foreach($tableData->getUrlRange(max(1, $tableData->currentPage()-2), min($tableData->lastPage(), $tableData->currentPage()+2)) as $page => $url)
                    <a href="{{ $url }}#detail-jam"
                        class="w-7 h-7 flex items-center justify-center rounded-lg text-xs font-medium
                            {{ $tableData->currentPage() == $page ? 'bg-gray-900 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                        {{ $page }}
                    </a>
                    @endforeach

                    @if ($tableData->hasMorePages())
                    <a href="{{ $tableData->nextPageUrl() }}#detail-jam"
                        class="w-7 h-7 flex items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                    @else
                    <span class="w-7 h-7 flex items-center justify-center rounded-lg text-gray-300 cursor-not-allowed">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- ===== MODAL DETAIL PER BULAN ===== --}}
    <div id="modalDetail"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm hidden">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl mx-4 overflow-hidden">
            {{-- Modal header --}}
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                <div>
                    <h3 class="text-sm font-bold text-gray-900" id="modalNamaGuru">—</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Detail jam mengajar per bulan</p>
                </div>
                <button onclick="tutupModal()"
                    class="w-7 h-7 flex items-center justify-center rounded-lg hover:bg-gray-100 text-gray-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            {{-- Modal body --}}
            <div class="px-6 py-4 max-h-96 overflow-y-auto">
                <div id="modalLoading" class="flex items-center justify-center py-10 text-gray-400 text-sm gap-2">
                    <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8v8z" />
                    </svg>
                    Memuat data...
                </div>
                <table class="w-full text-sm hidden" id="modalTable">
                    <thead>
                        <tr class="border-b border-gray-100">
                            <th class="pb-2 text-left text-xs font-semibold text-gray-500 uppercase">Bulan</th>
                            <th class="pb-2 text-left text-xs font-semibold text-gray-500 uppercase">Mata Pelajaran</th>
                            <th class="pb-2 text-right text-xs font-semibold text-gray-500 uppercase">Jam</th>
                        </tr>
                    </thead>
                    <tbody id="modalBody" class="divide-y divide-gray-50"></tbody>
                    <tfoot>
                        <tr class="border-t border-gray-200 bg-gray-50">
                            <td colspan="2" class="py-2 px-0 text-xs font-bold text-gray-700">Total</td>
                            <td class="py-2 text-right text-xs font-bold text-gray-800" id="modalTotalJam">—</td>

                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // ── Fungsi modal — HARUS global (di luar DOMContentLoaded) ──────
        const DETAIL_URL = "{{ route('jam-mengajar.detail-guru') }}";
        const NAMA_BULAN = ['', 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

        function bukaDetail(idGuru, namaGuru, tahun) {
            document.getElementById('modalNamaGuru').textContent = namaGuru;
            document.getElementById('modalLoading').classList.remove('hidden');
            document.getElementById('modalTable').classList.add('hidden');
            document.getElementById('modalDetail').classList.remove('hidden');

            const params = new URLSearchParams({
                id_guru: idGuru
            });
            if (tahun) params.append('tahun', tahun);

            fetch(`${DETAIL_URL}?${params}`)
                .then(r => r.json())
                .then(rows => {
                    const tbody = document.getElementById('modalBody');
                    tbody.innerHTML = '';
                    let totalJam = 0,
                        totalHadir = 0;

                    rows.forEach(row => {
                        const persen = row.jumlah_jam_mengajar > 0 ?
                            Math.round((row.jumlah_kehadiran / row.jumlah_jam_mengajar) * 100) :
                            0;
                        const color = persen >= 90 ? 'text-green-600' : persen >= 75 ? 'text-yellow-600' : 'text-red-500';
                        totalJam += row.jumlah_jam_mengajar;

                        tbody.insertAdjacentHTML('beforeend', `
                        <tr class="hover:bg-gray-50">
                            <td class="py-2 text-xs text-gray-600">${NAMA_BULAN[row.bulan]} ${row.tahun}</td>
                            <td class="py-2 text-xs text-gray-600">${row.nama_mata_pelajaran}</td>
                            <td class="py-2 text-right text-xs font-semibold text-gray-800">${row.jumlah_jam_mengajar}</td>
                        </tr>
                    `);
                    });

                    document.getElementById('modalTotalJam').textContent = totalJam;
                    document.getElementById('modalLoading').classList.add('hidden');
                    document.getElementById('modalTable').classList.remove('hidden');
                })
                .catch(() => {
                    document.getElementById('modalLoading').textContent = 'Gagal memuat data.';
                });
        }

        function tutupModal() {
            document.getElementById('modalDetail').classList.add('hidden');
        }

        // Klik backdrop untuk menutup modal
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('modalDetail').addEventListener('click', function(e) {
                if (e.target === this) tutupModal();
            });
        });

        document.addEventListener('DOMContentLoaded', function() {

            // ── Warna palette ───────────────────────────────────────────
            const PALETTE = [
                '#4e79a7', '#f28e2b', '#e15759', '#76b7b2',
                '#59a14f', '#b07aa1', '#ff9da7', '#9c755f', '#bab0ac',
            ];

            // ── DATA dari Blade ─────────────────────────────────────────────
            const distribusiGuru = @json($distribusiPerGuru);
            const bebanMapel = @json($bebanPerMapel);
            const trenBulan = @json($trenPerBulan);

            // ============================================================
            // CHART 1 — Line: Tren Per Bulan (2 garis — mirip Power BI)
            // ============================================================
            (function() {
                if (!trenBulan.length) return;

                const ctx = document.getElementById('lineChart').getContext('2d');
                const labels = trenBulan.map(t => t.nama_bulan);
                const jamData = trenBulan.map(t => t.total_jam);
                const hadirData = trenBulan.map(t => t.total_kehadiran);

                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels,
                        datasets: [{
                                label: 'Jumlah Jam Mengajar',
                                data: jamData,
                                borderColor: '#22c55e',
                                backgroundColor: 'rgba(34,197,94,0.08)',
                                borderWidth: 2,
                                fill: false,
                                tension: 0.3,
                                pointBackgroundColor: '#22c55e',
                                pointBorderColor: '#fff',
                                pointBorderWidth: 2,
                                pointRadius: 4,
                                pointHoverRadius: 6,
                            },
                            {
                                label: 'Jumlah Kehadiran',
                                data: hadirData,
                                borderColor: '#f87171',
                                backgroundColor: 'rgba(248,113,113,0.08)',
                                borderWidth: 2,
                                fill: false,
                                tension: 0.3,
                                pointBackgroundColor: '#f87171',
                                pointBorderColor: '#fff',
                                pointBorderWidth: 2,
                                pointRadius: 4,
                                pointHoverRadius: 6,
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: {
                            mode: 'index',
                            intersect: false
                        },
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: '#1e293b',
                                padding: 10,
                                callbacks: {
                                    label: ctx => ` ${ctx.dataset.label}: ${ctx.parsed.y.toLocaleString('id-ID')}`
                                }
                            }
                        },
                        scales: {
                            x: {
                                grid: {
                                    display: false
                                },
                                border: {
                                    display: false
                                },
                                ticks: {
                                    color: '#94a3b8',
                                    font: {
                                        size: 10
                                    }
                                },
                                title: {
                                    display: true,
                                    text: 'Bulan',
                                    color: '#94a3b8',
                                    font: {
                                        size: 10
                                    }
                                }
                            },
                            y: {
                                grid: {
                                    color: '#f1f5f9'
                                },
                                border: {
                                    display: false
                                },
                                ticks: {
                                    color: '#94a3b8',
                                    font: {
                                        size: 10
                                    }
                                },
                                min: 0,
                            }
                        }
                    }
                });
            })();

            // ============================================================
            // CHART 2 — Bar: Beban Per Mata Pelajaran (warna-warni)
            // ============================================================
            (function() {
                if (!bebanMapel.length) return;

                const ctx = document.getElementById('barChart').getContext('2d');
                const labels = bebanMapel.map(m => {
                    const l = m.nama_mata_pelajaran || 'Tidak Diketahui';
                    return l.length > 14 ? l.substring(0, 14) + '…' : l;
                });
                const data = bebanMapel.map(m => m.total_jam);

                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels,
                        datasets: [{
                            data,
                            backgroundColor: labels.map((_, i) => PALETTE[i % PALETTE.length]),
                            borderRadius: 3,
                            borderSkipped: false,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: '#1e293b',
                                padding: 10,
                                callbacks: {
                                    title: items => bebanMapel[items[0].dataIndex]?.nama_mata_pelajaran ?? '',
                                    label: ctx => ` ${ctx.parsed.y.toLocaleString('id-ID')} jam`,
                                }
                            }
                        },
                        scales: {
                            x: {
                                grid: {
                                    display: false
                                },
                                border: {
                                    display: false
                                },
                                ticks: {
                                    color: '#94a3b8',
                                    font: {
                                        size: 8
                                    },
                                    maxRotation: 45
                                }
                            },
                            y: {
                                grid: {
                                    color: '#f1f5f9'
                                },
                                border: {
                                    display: false
                                },
                                ticks: {
                                    color: '#94a3b8',
                                    font: {
                                        size: 10
                                    }
                                },
                                title: {
                                    display: true,
                                    text: 'Jumlah Jam Mengajar',
                                    color: '#94a3b8',
                                    font: {
                                        size: 10
                                    }
                                },
                                min: 0,
                            }
                        }
                    }
                });
            })();

            // ============================================================
            // CHART 3 — Horizontal Bar: Distribusi Per Guru
            (function() {
                if (!distribusiGuru.length) return;

                const total = distribusiGuru.reduce((s, d) => s + d.total_jam, 0);
                const avg = Math.round(total / distribusiGuru.length);
                const maxJam = distribusiGuru[0].total_jam;

                document.getElementById('distTotal').textContent = total.toLocaleString('id-ID');
                document.getElementById('distTopJam').textContent = distribusiGuru[0].total_jam + ' jam';
                document.getElementById('distTopName').textContent = distribusiGuru[0].nama_guru;
                document.getElementById('distAvg').textContent = avg.toLocaleString('id-ID') + ' jam';

                const container = document.getElementById('distribusiChart');

                distribusiGuru.forEach((d, i) => {
                    const isAbove = d.total_jam >= avg;
                    const color = PALETTE[i % PALETTE.length]; 
                    const pct = Math.round((d.total_jam / maxJam) * 100);
                    const avgPct = Math.round((avg / maxJam) * 100);

                    const row = document.createElement('div');
                    row.className = 'flex items-center gap-2';
                    row.innerHTML = `
            <span class="text-xs text-gray-500 w-32 text-right truncate shrink-0" title="${d.nama_guru}">${d.nama_guru}</span>
            <div class="flex-1 relative bg-gray-100 rounded h-7">
                <div class="bar-fill h-full rounded flex items-center justify-end pr-2 transition-all duration-700"
                     style="width:0%; background:${color};" data-width="${pct}">
                    <span class="text-xs font-semibold text-white">${d.total_jam}</span>
                </div>
                <div class="absolute top-0 bottom-0 w-px bg-amber-400 opacity-60 pointer-events-none"
                     style="left:${avgPct}%"></div>
                ${i === 0 ? `<span class="absolute -top-4 text-[10px] text-amber-600" style="left:${avgPct}%; transform:translateX(-50%)">⌀ rata-rata</span>` : ''}
            </div>
            <span class="text-xs font-semibold w-8 text-right" style="color:${color}">${d.persentase}%</span>
        `;
                    container.appendChild(row);

                    // Animate
                    setTimeout(() => {
                        row.querySelector('.bar-fill').style.width = pct + '%';
                    }, 80 + i * 60);
                });
            })();

            // ============================================================
            // Realtime client-side search pada tabel
            // ============================================================
            const searchInput = document.getElementById('searchGuru');
            const tableRows = document.querySelectorAll('#tableBody tr[data-nama]');
            const emptyRow = document.getElementById('emptyRow');

            function filterTable() {
                const keyword = searchInput ? searchInput.value.toLowerCase().trim() : '';
                let visibleCount = 0;
                tableRows.forEach(row => {
                    const show = row.dataset.nama.includes(keyword);
                    row.style.display = show ? '' : 'none';
                    if (show) visibleCount++;
                });
                if (emptyRow) emptyRow.style.display = visibleCount === 0 ? '' : 'none';
            }

            if (searchInput) searchInput.addEventListener('input', filterTable);
        });
    </script>
    @endpush

</x-app>