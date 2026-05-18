<x-app title="Kehadiran Guru | SMA Cendana Pekanbaru">

    {{-- ── Header ──────────────────────────────────────────────────────────── --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Kehadiran Guru</h1>
            <p class="text-sm text-gray-500 mt-1">Pantau kehadiran tenaga pengajar secara real-time</p>
        </div>

        <form method="GET" action="{{ route('kehadiran-guru') }}" class="flex items-center gap-3 flex-wrap">
            {{-- Filter Tahun --}}
            <div class="relative">
                <select name="tahun" onchange="this.form.submit()"
                    class="appearance-none bg-white border border-gray-200 rounded-xl px-4 py-2.5 pr-9 text-sm font-medium text-gray-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-amber-400 cursor-pointer">
                    <option value="all" {{ $tahun === 'all' ? 'selected' : '' }}>Semua Tahun</option>
                    @foreach ($daftarTahun as $t)
                    <option value="{{ $t }}" {{ $tahun == $t ? 'selected' : '' }}>{{ $t }}</option>
                    @endforeach
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>
            </div>

            {{-- Filter Bulan --}}
            <div class="relative">
                <select name="bulan" onchange="this.form.submit()"
                    class="appearance-none bg-white border border-gray-200 rounded-xl px-4 py-2.5 pr-9 text-sm font-medium text-gray-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-amber-400 cursor-pointer">
                    <option value="">Semua Bulan</option>
                    @foreach ($daftarBulan as $b)
                    <option value="{{ $b }}" {{ $bulan == $b ? 'selected' : '' }}>{{ $namaBulan[$b] ?? $b }}</option>
                    @endforeach
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>
            </div>

            {{-- Pencarian tersembunyi agar tidak hilang saat ganti filter --}}
            @if ($search)
            <input type="hidden" name="search" value="{{ $search }}">
            @endif
        </form>
    </div>

    {{-- ── Stat Cards ──────────────────────────────────────────────────────── --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-5 gap-4 mb-8">

        {{-- Total Guru --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Total Guru</p>
            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalGuru }}</p>
            <p class="text-xs text-gray-400 mt-0.5">
               Total Guru — {{ $isAll ? 'Semua Tahun' : $tahun }}
                </p>
        </div>

        {{-- Guru Hadir --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Guru Hadir</p>
            <p class="text-3xl font-bold text-emerald-600 mt-2">{{ $guruHadir }}</p>
            <p class="text-xs text-emerald-500 font-medium mt-1 flex items-center gap-1">
                <span class="w-2 h-2 rounded-full bg-emerald-500 inline-block"></span>
                Guru hadir
            </p>
        </div>

        {{-- Guru Izin --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Guru Izin</p>
            <p class="text-3xl font-bold text-amber-500 mt-2">{{ $guruIzin }}</p>
            <p class="text-xs text-amber-500 font-medium mt-1 flex items-center gap-1">
                <span class="w-2 h-2 rounded-full bg-amber-400 inline-block"></span>
                Guru izin
            </p>
        </div>

        {{-- Guru Alfa --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Guru Alfa</p>
            <p class="text-3xl font-bold text-red-500 mt-2">{{ $guruAlfa }}</p>
            <p class="text-xs text-red-500 font-medium mt-1 flex items-center gap-1">
                <span class="w-2 h-2 rounded-full bg-red-400 inline-block"></span>
                Tanpa keterangan
            </p>
        </div>

        {{-- Persentase Kehadiran --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Persentase Kehadiran</p>
            <p class="text-3xl font-bold text-blue-600 mt-2">{{ number_format($persenKehadiran, 1) }}%</p>
            <div class="mt-2 w-full bg-gray-100 rounded-full h-1.5">
                <div class="bg-blue-500 h-1.5 rounded-full transition-all duration-700"
                    style="width: {{ min($persenKehadiran, 100) }}%"></div>
            </div>
        </div>

    </div>

    {{-- ── Charts ───────────────────────────────────────────────────────────── --}}
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6 mb-8">

        {{-- Line Chart: Tren Kehadiran (%) --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 lg:col-span-3">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h2 class="text-base font-semibold text-gray-900">Tren Kehadiran</h2>
                    <p class="text-xs text-gray-400 mt-0.5">Persentase kehadiran guru per bulan — {{ $isAll ? 'Semua Tahun' : $tahun }}</p>
                </div>
                <span class="text-xs text-gray-400">% Kehadiran</span>
            </div>
            <div class="relative h-60">
                <canvas id="lineChart"></canvas>
            </div>
        </div>

        {{-- Donut Chart: Distribusi Status Kehadiran --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 lg:col-span-2">
            <div class="mb-4">
                <h2 class="text-base font-semibold text-gray-900">Distribusi Status Kehadiran</h2>
                <p class="text-xs text-gray-400 mt-0.5">
                    {{ $isAll ? 'Semua Tahun' : 'Tahun '.$tahun }}{{ $bulan ? ' — ' . ($namaBulan[$bulan] ?? $bulan) : '' }}
                </p>
            </div>
            <div class="relative h-44 flex items-center justify-center">
                <canvas id="donutChart"></canvas>
            </div>
            {{-- Legend --}}
            <div class="grid grid-cols-3 gap-2 mt-5 text-center">
                @php
                $grandTotal = $totalHadir + $totalIzin + $totalAlpha;

                $pHadir = $grandTotal > 0
                ? round(($totalHadir / $grandTotal) * 100, 1)
                : 0;

                $pIzin = $grandTotal > 0
                ? round(($totalIzin / $grandTotal) * 100, 1)
                : 0;

                $pAlfa = $grandTotal > 0
                ? round(($totalAlpha / $grandTotal) * 100, 1)
                : 0;
                @endphp
                <div class="flex flex-col items-center gap-1">
                    <span class="w-3 h-3 rounded-full bg-blue-500 shrink-0"></span>
                    <span class="text-xs text-gray-500">Hadir</span>
                    <span class="text-sm font-bold text-gray-800">{{ $pHadir }}%</span>
                </div>
                <div class="flex flex-col items-center gap-1">
                    <span class="w-3 h-3 rounded-full bg-amber-400 shrink-0"></span>
                    <span class="text-xs text-gray-500">Izin</span>
                    <span class="text-sm font-bold text-gray-800">{{ $pIzin }}%</span>
                </div>
                <div class="flex flex-col items-center gap-1">
                    <span class="w-3 h-3 rounded-full bg-red-400 shrink-0"></span>
                    <span class="text-xs text-gray-500">Alfa</span>
                    <span class="text-sm font-bold text-gray-800">{{ $pAlfa }}%</span>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Table: Ringkasan Kehadiran Per Guru ────────────────────────────── --}}
    <div id="detail-kehadiran" class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 px-6 py-4 border-b border-gray-100">
            <h2 class="text-base font-semibold text-gray-900">Detail Kehadiran Guru</h2>
            <form method="GET" action="{{ route('kehadiran-guru') }}" class="flex items-center gap-2">
                {{-- Preserve filters --}}
                <input type="hidden" name="tahun" value="{{ $tahun }}">
                @if ($bulan)
                <input type="hidden" name="bulan" value="{{ $bulan }}">
                @endif
                <div class="relative">
                    <input type="text" name="search" value="{{ $search }}"
                        placeholder="Cari guru..."
                        class="bg-gray-50 border border-gray-200 rounded-xl pl-9 pr-4 py-2 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-amber-400 w-48">
                    <svg class="w-4 h-4 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <button type="submit"
                    class="bg-gray-900 text-white text-xs font-medium rounded-xl px-4 py-2 hover:bg-gray-700 transition-colors">
                    Cari
                </button>
                @if ($search)
                <a href="{{ route('kehadiran-guru', ['tahun' => $tahun, 'bulan' => $bulan]) }}"
                    class="text-xs text-gray-400 hover:text-gray-600">Reset</a>
                @endif
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 text-left">
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Guru</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right">Total Hari Kerja</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right">Total Hadir</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right">Total Izin</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right">Total Alfa</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right">% Kehadiran</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse ($ringkasanGuru as $guru)
                    <tr class="hover:bg-gray-50 transition-colors">
                        {{-- Nama + NIP --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center text-xs font-bold shrink-0">
                                    {{ strtoupper(substr($guru->nama_guru, 0, 2)) }}
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800">{{ $guru->nama_guru }}</p>
                                    <p class="text-xs text-gray-400">{{ $guru->nip ?? '-' }}</p>
                                </div>
                            </div>
                        </td>

                        {{-- Total Hari Kerja --}}
                        <td class="px-6 py-4 text-right text-gray-600 font-medium">
                            {{ number_format($guru->total_hari_kerja) }}
                        </td>

                        {{-- Total Hadir --}}
                        <td class="px-6 py-4 text-right">
                            <span class="inline-flex items-center justify-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100 min-w-[2.5rem]">
                                {{ number_format($guru->total_hadir_kerja) }}
                            </span>
                        </td>

                        {{-- Total Izin --}}
                        <td class="px-6 py-4 text-right">
                            @if ($guru->total_izin > 0)
                            <span class="inline-flex items-center justify-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-100 min-w-[2.5rem]">
                                {{ $guru->total_izin }}
                            </span>
                            @else
                            <span class="text-gray-300 font-medium">—</span>
                            @endif
                        </td>

                        {{-- Total Alfa --}}
                        <td class="px-6 py-4 text-right">
                            @if ($guru->total_alfa > 0)
                            <span class="inline-flex items-center justify-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-50 text-red-700 border border-red-100 min-w-[2.5rem]">
                                {{ $guru->total_alfa }}
                            </span>
                            @else
                            <span class="text-gray-300 font-medium">—</span>
                            @endif
                        </td>

                        {{-- % Kehadiran Guru --}}
                        <td class="px-6 py-4 text-right">
                            @php $persen = $guru->persen_kehadiran_guru ?? 0; @endphp
                            <div class="flex items-center justify-end gap-2">
                                <div class="w-16 bg-gray-100 rounded-full h-1.5 hidden sm:block">
                                    <div class="h-1.5 rounded-full {{ $persen >= 90 ? 'bg-emerald-500' : ($persen >= 75 ? 'bg-amber-400' : 'bg-red-400') }}"
                                        style="width: {{ min($persen, 100) }}%"></div>
                                </div>
                                <span class="text-sm font-bold {{ $persen >= 90 ? 'text-emerald-600' : ($persen >= 75 ? 'text-amber-600' : 'text-red-500') }} min-w-[3rem] text-right">
                                    {{ number_format($persen, 0) }}%
                                </span>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-10 text-center text-gray-400">
                            Tidak ada data kehadiran ditemukan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="px-6 py-4 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-3">
            <p class="text-xs text-gray-500">
                Menampilkan {{ $ringkasanGuru->firstItem() }}–{{ $ringkasanGuru->lastItem() }}
                dari {{ $ringkasanGuru->total() }} guru
            </p>

            <div class="flex items-center gap-1">
                {{-- Prev --}}
                @if ($ringkasanGuru->onFirstPage())
                <span class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-300 cursor-not-allowed text-xs">‹</span>
                @else
                <a href="{{ $ringkasanGuru->previousPageUrl() }}#detail-kehadiran"
                    class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100 text-xs">‹</a>
                @endif

                {{-- Pages --}}
                @for ($i = max(1, $ringkasanGuru->currentPage() - 2); $i <= min($ringkasanGuru->lastPage(), $ringkasanGuru->currentPage() + 2); $i++)
                    <a href="{{ $ringkasanGuru->url($i) }}#detail-kehadiran"
                        class="w-8 h-8 flex items-center justify-center rounded-lg text-xs font-medium
                        {{ $ringkasanGuru->currentPage() == $i ? 'bg-gray-900 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                        {{ $i }}
                    </a>
                    @endfor

                    {{-- Next --}}
                    @if ($ringkasanGuru->hasMorePages())
                    <a href="{{ $ringkasanGuru->nextPageUrl() }}#detail-kehadiran"
                        class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100 text-xs">›</a>
                    @else
                    <span class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-300 cursor-not-allowed text-xs">›</span>
                    @endif
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const trenData = @json($trenKehadiran);
            const bulanNames = @json($namaBulan);

            const isAll = {{ $isAll ? 'true' : 'false' }};
            const labels = trenData.map(t => {
                const namaBln = bulanNames[t.periode_bulan]
                    ? bulanNames[t.periode_bulan].substring(0, 3)
                    : t.periode_bulan;
                return isAll && t.periode_tahun ? `${namaBln} ${t.periode_tahun}` : namaBln;
            });
            const persenData = trenData.map(t => parseFloat(t.persen_kehadiran) || 0);

            // ── Line Chart: Tren Kehadiran (%) ──────────────────────────────
            const lineCtx = document.getElementById('lineChart').getContext('2d');
            const gradBlue = lineCtx.createLinearGradient(0, 0, 0, 240);
            gradBlue.addColorStop(0, 'rgba(59,130,246,0.15)');
            gradBlue.addColorStop(1, 'rgba(59,130,246,0.0)');

            new Chart(lineCtx, {
                type: 'line',
                data: {
                    labels,
                    datasets: [{
                        label: '% Kehadiran',
                        data: persenData,
                        borderColor: '#3b82f6',
                        borderWidth: 2.5,
                        backgroundColor: gradBlue,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#3b82f6',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
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
                            titleColor: '#94a3b8',
                            bodyColor: '#fff',
                            padding: 10,
                            callbacks: {
                                label: ctx => ` Kehadiran: ${ctx.parsed.y.toFixed(2)}%`
                            }
                        },
                        // Tampilkan label nilai di atas titik (seperti Power BI)
                        datalabels: {
                            display: true,
                            align: 'top',
                            color: '#374151',
                            font: {
                                size: 10,
                                weight: '600'
                            },
                            formatter: v => v.toFixed(2) + '%'
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
                                    size: 11
                                }
                            }
                        },
                        y: {
                            min: 0,
                            max: 100,
                            grid: {
                                color: '#f1f5f9'
                            },
                            border: {
                                display: false
                            },
                            ticks: {
                                color: '#94a3b8',
                                font: {
                                    size: 11
                                },
                                callback: v => v + '%'
                            }
                        }
                    }
                }
            });

            // ── Donut Chart: Distribusi Status Kehadiran ─────────────────────
            const donutCtx = document.getElementById('donutChart').getContext('2d');
            new Chart(donutCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Hadir', 'Izin', 'Alfa'],
                    datasets: [{
                        data: [{{ $totalHadir }}, {{ $totalIzin }}, {{ $totalAlpha }}],
                        backgroundColor: ['#3b82f6', '#fbbf24', '#f87171'],
                        borderWidth: 3,
                        borderColor: '#fff',
                        hoverOffset: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '65%',
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: '#1e293b',
                            titleColor: '#94a3b8',
                            bodyColor: '#fff',
                            padding: 10,
                            callbacks: {
                                label: ctx => {
                                    const total = ctx.dataset.data.reduce((a, b) => a + b, 0);
                                    const pct = total > 0 ? ((ctx.parsed / total) * 100).toFixed(1) : 0;
                                    return ` ${ctx.label}: ${ctx.parsed} (${pct}%)`;
                                }
                            }
                        }
                    }
                }
            });

        });
    </script>
    @endpush

</x-app>