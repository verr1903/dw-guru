<x-app title="Dashboard | SMA Cendana Pekanbaru">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Dashboard Kinerja Mengajar Guru</h1>
            <p class="text-sm text-gray-500 mt-1">Pantau performa dan kehadiran tenaga pengajar</p>
        </div>
        <div class="flex items-center gap-3">
            <form method="GET" action="{{ route('dashboard') }}" class="flex items-center gap-3">
                <input type="hidden" name="tahun" value="{{ $tahun }}">
                <div class="relative">
                    <select name="tahun" onchange="this.form.submit()"
                        class="appearance-none bg-white border border-gray-200 rounded-xl px-4 py-2.5 pr-9 text-sm font-medium text-gray-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-amber-400 cursor-pointer">
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
            <button onclick="unduhLaporan()"
                class="bg-gray-900 hover:bg-gray-700 text-white text-sm font-semibold px-5 py-2.5 rounded-xl shadow transition-all duration-150 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                Unduh Laporan
            </button>
        </div>
    </div>

    {{-- Stat Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 mb-8">

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex items-start gap-4">
            <div class="w-11 h-11 rounded-xl bg-gray-900 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Total Jam Mengajar ({{ $tahun }})</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">
                    {{ number_format($totalJamMengajar) }}
                    <span class="text-base font-semibold text-gray-600">Jam</span>
                </p>
                <p class="text-xs {{ $persenPerubahanJam >= 0 ? 'text-emerald-600' : 'text-red-500' }} font-medium mt-1 flex items-center gap-1">
                    @if($persenPerubahanJam >= 0)
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                    @else
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M14.707 10.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 12.586V5a1 1 0 012 0v7.586l2.293-2.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                    @endif
                    {{ $persenPerubahanJam >= 0 ? '+' : '' }}{{ $persenPerubahanJam }}% dari tahun lalu
                </p>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex items-start gap-4">
            <div class="w-11 h-11 rounded-xl bg-emerald-500 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </div>
            <div>
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Kehadiran Rata-rata</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">
                    {{ number_format($kehadiranRataRata, 2) }}<span class="text-base font-semibold text-gray-600">%</span>
                </p>
                <p class="text-xs {{ $persenPerubahanKehadiran >= 0 ? 'text-emerald-600' : 'text-red-500' }} font-medium mt-1 flex items-center gap-1">
                    @if($persenPerubahanKehadiran >= 0)
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                    @else
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M14.707 10.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 12.586V5a1 1 0 012 0v7.586l2.293-2.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                    @endif
                    {{ $persenPerubahanKehadiran >= 0 ? '+' : '' }}{{ $persenPerubahanKehadiran }}% dari tahun lalu
                </p>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex items-start gap-4">
            <div class="w-11 h-11 rounded-xl bg-blue-500 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <div>
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Guru Aktif</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">
                    {{ $guruAktif }} <span class="text-base font-semibold text-gray-600">Guru</span>
                </p>
                <p class="text-xs {{ $selisihGuruAktif >= 0 ? 'text-emerald-600' : 'text-red-500' }} font-medium mt-1 flex items-center gap-1">
                    @if($selisihGuruAktif >= 0)
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                    @else
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M14.707 10.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 12.586V5a1 1 0 012 0v7.586l2.293-2.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                    @endif
                    {{ $selisihGuruAktif >= 0 ? '+' : '' }}{{ $selisihGuruAktif }} dari tahun lalu
                </p>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex items-start gap-4">
            <div class="w-11 h-11 rounded-xl bg-amber-500 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
            </div>
            <div>
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Total Prestasi ({{ $tahun }})</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">
                    {{ $totalPrestasi }}<span class="text-base font-semibold text-gray-600"> Prestasi</span>
                </p>
                <p class="text-xs {{ $selisihPrestasi >= 0 ? 'text-emerald-600' : 'text-red-500' }} font-medium mt-1 flex items-center gap-1">
                    @if($selisihPrestasi >= 0)
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                    @else
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M14.707 10.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 12.586V5a1 1 0 012 0v7.586l2.293-2.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                    @endif
                    {{ $selisihPrestasi >= 0 ? '+' : '' }}{{ $selisihPrestasi }} dari tahun lalu
                </p>
            </div>
        </div>

    </div>

    {{-- Charts --}}
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6 mb-8">

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 lg:col-span-3">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-base font-semibold text-gray-900">Tren Guru Aktif per Bulan</h2>
                    <p class="text-xs text-gray-400 mt-0.5">Jumlah guru yang tercatat aktif setiap bulan</p>
                </div>
                <span class="bg-gray-100 text-gray-600 text-xs font-medium px-3 py-1 rounded-full">{{ $tahun }}</span>
            </div>
            <div class="relative h-56">
                <canvas id="lineChart"></canvas>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 lg:col-span-2">
            <div class="mb-4">
                <h2 class="text-base font-semibold text-gray-900">Top Guru berdasarkan Jam Mengajar</h2>
                <p class="text-xs text-gray-400 mt-0.5">Distribusi jam mengajar tertinggi</p>
            </div>
            <div class="flex flex-col gap-3" id="topGuruList">
                {{-- diisi oleh JS --}}
            </div>
        </div>

    </div>

    {{-- Table --}}
    <div id="rekap-guru" class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 px-6 py-4 border-b border-gray-100">
            <h2 class="text-base font-semibold text-gray-900">Rekap Kinerja Guru</h2>
            <form method="GET" action="{{ route('dashboard') }}" class="flex items-center gap-3">
                <input type="hidden" name="tahun" value="{{ $tahun }}">

                <div class="flex items-center gap-3">
                    <div class="relative">
                        <input
                            type="text"
                            id="searchGuru"
                            value="{{ $search }}"
                            placeholder="Cari guru..."
                            class="bg-gray-50 border border-gray-200 rounded-xl pl-9 pr-4 py-2 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-amber-400 w-44">
                        <svg class="w-4 h-4 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>

                    <select id="filterMapel"
                        class="bg-gray-50 border border-gray-200 rounded-xl px-3 py-2 text-sm text-gray-700 focus:outline-none">
                        <option value="">Semua Mapel</option>
                        @foreach($daftarMapel as $m)
                        <option value="{{ $m }}" {{ $mapel == $m ? 'selected' : '' }}>{{ $m }}</option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 text-left">
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Guru</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Mata Pelajaran</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Jam Mengajar</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Kehadiran</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($guruData as $guru)
                    @php
                    $absenInfo = $kehadiranPerGuru[$guru->nama_guru] ?? null;
                    $totalAbsen = $absenInfo ? $absenInfo->total_absen : 0;
                    $records = $absenInfo ? $absenInfo->records : 1;
                    $totalHK = $records * 31;
                    $persen = $totalHK > 0 ? round((($totalHK - $totalAbsen) / $totalHK) * 100) : 100;
                    @endphp
                    <tr class="hover:bg-gray-50 transition-colors"
                        data-nama="{{ strtolower($guru->nama_guru) }}"
                        data-mapel="{{ strtolower($guru->bidang_studi) }}">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center text-xs font-bold shrink-0">
                                    {{ strtoupper(substr($guru->nama_guru, 0, 2)) }}
                                </div>
                                <span class="font-medium text-gray-800">{{ $guru->nama_guru }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-gray-600">{{ $guru->bidang_studi }}</td>
                        <td class="px-6 py-4 font-medium text-gray-800">{{ $guru->jam_total  }} jam</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <div class="w-20 bg-gray-100 rounded-full h-1.5">
                                    <div class="h-1.5 rounded-full {{ $persen >= 95 ? 'bg-emerald-500' : ($persen >= 90 ? 'bg-amber-400' : 'bg-red-400') }}"
                                        style="width: {{ $persen }}%"></div>
                                </div>
                                <span class="text-gray-700 font-medium">{{ $persen }}%</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($persen >= 95)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-100">Sangat Baik</span>
                            @elseif($persen >= 90)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">Baik</span>
                            @elseif($persen >= 80)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-50 text-amber-700 border border-amber-100">Cukup</span>
                            @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-50 text-red-700 border border-red-100">Perlu Perhatian</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr id="emptyRow">
                        <td colspan="5" class="px-6 py-8 text-center text-gray-400">
                            Tidak ada data guru untuk tahun {{ $tahun }}.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{-- Pagination --}}
        <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between">

            <p class="text-xs text-gray-500">
                Menampilkan {{ $guruData->count() }} dari {{ $guruData->total() }} guru
            </p>

            <div class="flex items-center gap-1">

                {{-- Previous --}}
                @if ($guruData->onFirstPage())
                <span class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-300 cursor-not-allowed">
                    ...
                </span>
                @else
                <a href="{{ $guruData->previousPageUrl() }}#rekap-guru"
                    class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100">
                    ...
                </a>
                @endif

                {{-- Page Number --}}
                @for ($i = 1; $i <= $guruData->lastPage(); $i++)
                    <a href="{{ $guruData->url($i) }}#rekap-guru"
                        class="w-8 h-8 flex items-center justify-center rounded-lg text-xs font-medium
               {{ $guruData->currentPage() == $i
                    ? 'bg-gray-900 text-white'
                    : 'text-gray-600 hover:bg-gray-100' }}">
                        {{ $i }}
                    </a>
                    @endfor

                    {{-- Next --}}
                    @if ($guruData->hasMorePages())
                    <a href="{{ $guruData->nextPageUrl() }}#rekap-guru"
                        class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100">
                        ...
                    </a>
                    @else
                    <span class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-300 cursor-not-allowed">
                        ...
                    </span>
                    @endif

            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // ---- Line Chart: Tren Guru Aktif per Bulan ----
            const lineCtx = document.getElementById('lineChart').getContext('2d');
            const gradient = lineCtx.createLinearGradient(0, 0, 0, 220);
            gradient.addColorStop(0, 'rgba(99, 102, 241, 0.25)');
            gradient.addColorStop(1, 'rgba(99, 102, 241, 0.0)');

            const trenData = @json($trenJamPerBulan);
            const bulanLabels = @json($namaBulan);
            const chartLabels = [];
            const chartValues = [];

            for (let i = 1; i <= 12; i++) {
                if (trenData[i] !== undefined) {
                    chartLabels.push(bulanLabels[i].substring(0, 3));
                    chartValues.push(trenData[i]);
                }
            }

            new Chart(lineCtx, {
                type: 'line',
                data: {
                    labels: chartLabels,
                    datasets: [{
                        label: 'Guru Aktif',
                        data: chartValues,
                        borderColor: '#6366f1',
                        borderWidth: 2.5,
                        backgroundColor: gradient,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#6366f1',
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
                                label: ctx => ` ${ctx.parsed.y} guru`
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
                                    size: 11
                                }
                            }
                        },
                        y: {
                            min: 0,
                            grid: {
                                color: '#f1f5f9',
                                lineWidth: 1
                            },
                            border: {
                                display: false
                            },
                            ticks: {
                                color: '#94a3b8',
                                font: {
                                    size: 11
                                },
                                stepSize: 5
                            }
                        }
                    }
                }
            });

            // ---- Leaderboard: Top Guru Jam Mengajar ----
            const topGuru = @json($topGuruJam);
            const guruColors = [{
                    bg: '#fef9ec',
                    bar: '#f59e0b',
                    text: '#92400e'
                },
                {
                    bg: '#f1f5f9',
                    bar: '#94a3b8',
                    text: '#334155'
                },
                {
                    bg: '#fdf3ee',
                    bar: '#f97316',
                    text: '#7c2d12'
                },
                {
                    bg: '#eef2ff',
                    bar: '#6366f1',
                    text: '#3730a3'
                },
                {
                    bg: '#f0fdf4',
                    bar: '#22c55e',
                    text: '#14532d'
                },
            ];

            const maxJam = topGuru.length > 0 ? parseInt(topGuru[0].total_jam) : 1;
            const listEl = document.getElementById('topGuruList');

            topGuru.forEach((g, i) => {
                const c = guruColors[i] || guruColors[4];
                const pct = Math.round((parseInt(g.total_jam) / maxJam) * 100);
                const initials = g.nama_guru.split(' ').slice(0, 2).map(w => w[0]).join('').toUpperCase();

                listEl.innerHTML += `
                    <div style="display:flex;align-items:center;gap:12px;padding:10px 12px;background:${c.bg};border-radius:10px;">
                        <div style="width:32px;height:32px;border-radius:50%;background:${c.bar}33;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:600;color:${c.text};flex-shrink:0;">
                            ${initials}
                        </div>
                        <div style="flex:1;min-width:0;">
                            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:4px;">
                                <span style="font-size:13px;font-weight:500;color:#1e293b;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:160px;">${g.nama_guru}</span>
                                <span style="font-size:13px;font-weight:600;color:${c.text};flex-shrink:0;margin-left:8px;">${g.total_jam} jam</span>
                            </div>
                            <div style="height:4px;background:rgba(0,0,0,0.08);border-radius:99px;overflow:hidden;">
                                <div style="height:4px;width:${pct}%;background:${c.bar};border-radius:99px;"></div>
                            </div>
                        </div>
                    </div>`;
            });

        });

        function unduhLaporan() {
            alert('Laporan sedang diunduh...');
        }

        // ---- Realtime Search & Filter Tabel ----
        const searchInput = document.getElementById('searchGuru');
        const mapelSelect = document.getElementById('filterMapel');
        const tableRows = document.querySelectorAll('tbody tr[data-nama]');
        const emptyRow = document.getElementById('emptyRow');

        function filterTable() {
            const keyword = searchInput.value.toLowerCase().trim();
            const mapel = mapelSelect.value.toLowerCase().trim();
            let visibleCount = 0;

            tableRows.forEach(row => {
                const nama = row.dataset.nama.toLowerCase();
                const mapelRow = row.dataset.mapel.toLowerCase();

                const matchNama = nama.includes(keyword);
                const matchMapel = mapel === '' || mapelRow === mapel;

                if (matchNama && matchMapel) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            // Tampilkan baris kosong jika tidak ada hasil
            if (emptyRow) {
                emptyRow.style.display = visibleCount === 0 ? '' : 'none';
            }
        }

        searchInput.addEventListener('input', filterTable);
        mapelSelect.addEventListener('change', filterTable);
    </script>
    @endpush

</x-app>