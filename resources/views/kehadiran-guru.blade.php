<x-app title="Kehadiran Guru | SMA Cendana Pekanbaru">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Kehadiran Guru</h1>
            <p class="text-sm text-gray-500 mt-1">Pantau kehadiran tenaga pengajar secara real-time</p>
        </div>
        <div class="flex items-center gap-3">
            <form method="GET" action="{{ route('kehadiran-guru') }}" class="flex items-center gap-3">
                {{-- Filter Tahun --}}
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
                {{-- Filter Bulan --}}
                <div class="relative">
                    <select name="bulan" onchange="this.form.submit()"
                        class="appearance-none bg-white border border-gray-200 rounded-xl px-4 py-2.5 pr-9 text-sm font-medium text-gray-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-amber-400 cursor-pointer">
                        <option value="">Semua Bulan</option>
                        @foreach($daftarBulan as $b)
                            <option value="{{ $b }}" {{ $bulan == $b ? 'selected' : '' }}>{{ $namaBulan[$b] ?? $b }}</option>
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

    {{-- Stat Cards --}}
    @php
        $totalSakit = $ringkasanGuru->sum('total_sakit');
        $totalIzin = $ringkasanGuru->sum('total_izin');
        $totalAlpaAll = $ringkasanGuru->sum('total_alpa');
    @endphp
    <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-5 gap-4 mb-8">

        {{-- Total Guru --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Total Guru</p>
            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $guruAktif }}</p>
            <p class="text-xs text-gray-400 mt-1">Tenaga Pengajar</p>
        </div>

        {{-- Kehadiran --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Tingkat Kehadiran</p>
            <p class="text-3xl font-bold text-emerald-500 mt-2">{{ number_format($kehadiranRataRata, 2) }}%</p>
            <div class="mt-2 w-full bg-gray-100 rounded-full h-1.5">
                <div class="bg-emerald-500 h-1.5 rounded-full" style="width: {{ $persenKehadiran }}%"></div>
            </div>
        </div>

        {{-- Guru Sakit --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Total Sakit</p>
            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalSakit }}</p>
            <p class="text-xs text-blue-600 font-medium mt-1 flex items-center gap-1">
                <span class="w-2 h-2 rounded-full bg-blue-500 inline-block"></span>
                Hari sakit
            </p>
        </div>

        {{-- Guru Izin --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Total Izin</p>
            <p class="text-3xl font-bold text-amber-500 mt-2">{{ $totalIzinSakit }}</p>
            <p class="text-xs text-amber-600 font-medium mt-1 flex items-center gap-1">
                <span class="w-2 h-2 rounded-full bg-amber-400 inline-block"></span>
                Hari izin
            </p>
        </div>

        {{-- Guru Alfa --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Total Alpa</p>
            <p class="text-3xl font-bold text-red-500 mt-2">{{ $totalAlpa }}</p>
            <p class="text-xs text-red-500 font-medium mt-1 flex items-center gap-1">
                <span class="w-2 h-2 rounded-full bg-red-400 inline-block"></span>
                Tanpa Keterangan
            </p>
        </div>

    </div>

    {{-- Charts --}}
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6 mb-8">

        {{-- Line Chart: Tren Kehadiran --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 lg:col-span-3">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-base font-semibold text-gray-900">Tren Absensi per Bulan</h2>
                    <p class="text-xs text-gray-400 mt-0.5">Total sakit, izin, dan alpa per bulan</p>
                </div>
                <div class="flex items-center gap-3 text-xs text-gray-500">
                    <span class="flex items-center gap-1.5"><span class="w-3 h-0.5 bg-blue-500 inline-block rounded"></span> Sakit</span>
                    <span class="flex items-center gap-1.5"><span class="w-3 h-0.5 bg-amber-400 inline-block rounded"></span> Izin</span>
                    <span class="flex items-center gap-1.5"><span class="w-3 h-0.5 bg-red-400 inline-block rounded"></span> Alpa</span>
                </div>
            </div>
            <div class="relative h-56">
                <canvas id="lineChart"></canvas>
            </div>
        </div>

        {{-- Pie Chart: Distribusi Status --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 lg:col-span-2">
            <div class="mb-4">
                <h2 class="text-base font-semibold text-gray-900">Distribusi Absensi</h2>
                <p class="text-xs text-gray-400 mt-0.5">Tahun {{ $tahun }}</p>
            </div>
            <div class="relative h-44 flex items-center justify-center">
                <canvas id="pieChart"></canvas>
            </div>
            <div class="grid grid-cols-3 gap-2 mt-5">
                <div class="flex flex-col items-center gap-1">
                    <span class="w-3 h-3 rounded-full bg-blue-500 shrink-0"></span>
                    <span class="text-xs text-gray-500">Sakit</span>
                    <span class="text-sm font-bold text-gray-800">{{ $totalSakit }}</span>
                </div>
                <div class="flex flex-col items-center gap-1">
                    <span class="w-3 h-3 rounded-full bg-amber-400 shrink-0"></span>
                    <span class="text-xs text-gray-500">Izin</span>
                    <span class="text-sm font-bold text-gray-800">{{ $totalIzin }}</span>
                </div>
                <div class="flex flex-col items-center gap-1">
                    <span class="w-3 h-3 rounded-full bg-red-400 shrink-0"></span>
                    <span class="text-xs text-gray-500">Alpa</span>
                    <span class="text-sm font-bold text-gray-800">{{ $totalAlpaAll }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Table: Detail Kehadiran Guru --}}
    <div id="detail-kehadiran" class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 px-6 py-4 border-b border-gray-100">
            <h2 class="text-base font-semibold text-gray-900">Detail Kehadiran Guru</h2>
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
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 text-left">
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Guru</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Jabatan</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Sakit</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Izin</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Alpa</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Absen</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($ringkasanGuru as $guru)
                    @php
                        $totalAbsenGuru = $guru->total_sakit + $guru->total_izin + $guru->total_alpa;
                    @endphp
                    <tr class="hover:bg-gray-50 transition-colors"
                        data-nama="{{ strtolower($guru->nama_guru) }}">
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
                        <td class="px-6 py-4 text-gray-600">{{ $guru->jabatan }}</td>
                        <td class="px-6 py-4">
                            @if($guru->total_sakit > 0)
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">{{ $guru->total_sakit }}</span>
                            @else
                            <span class="text-gray-400 font-medium">—</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($guru->total_izin > 0)
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-amber-50 text-amber-700 border border-amber-100">{{ $guru->total_izin }}</span>
                            @else
                            <span class="text-gray-400 font-medium">—</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($guru->total_alpa > 0)
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-50 text-red-700 border border-red-100">{{ $guru->total_alpa }}</span>
                            @else
                            <span class="text-gray-400 font-medium">—</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($totalAbsenGuru > 0)
                            <span class="font-semibold {{ $totalAbsenGuru > 5 ? 'text-red-500' : 'text-amber-600' }}">{{ $totalAbsenGuru }} hari</span>
                            @else
                            <span class="text-emerald-600 font-semibold">Hadir Penuh</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr id="emptyRow">
                        <td colspan="6" class="px-6 py-8 text-center text-gray-400">Tidak ada data kehadiran.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between">
            <p class="text-xs text-gray-500">
                Menampilkan {{ $ringkasanGuru->count() }} dari {{ $ringkasanGuru->total() }} guru
            </p>

            <div class="flex items-center gap-1">

                {{-- Previous --}}
                @if ($ringkasanGuru->onFirstPage())
                <span class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-300 cursor-not-allowed">...</span>
                @else
                <a href="{{ $ringkasanGuru->previousPageUrl() }}#detail-kehadiran"
                    class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100">...</a>
                @endif

                {{-- Page Numbers --}}
                @for ($i = 1; $i <= $ringkasanGuru->lastPage(); $i++)
                <a href="{{ $ringkasanGuru->url($i) }}#detail-kehadiran"
                    class="w-8 h-8 flex items-center justify-center rounded-lg text-xs font-medium
                    {{ $ringkasanGuru->currentPage() == $i ? 'bg-gray-900 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                    {{ $i }}
                </a>
                @endfor

                {{-- Next --}}
                @if ($ringkasanGuru->hasMorePages())
                <a href="{{ $ringkasanGuru->nextPageUrl() }}#detail-kehadiran"
                    class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100">...</a>
                @else
                <span class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-300 cursor-not-allowed">...</span>
                @endif

            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ---- Line Chart: Tren Kehadiran ----
            const lineCtx = document.getElementById('lineChart').getContext('2d');
            const gradientHadir = lineCtx.createLinearGradient(0, 0, 0, 220);
            gradientHadir.addColorStop(0, 'rgba(59, 130, 246, 0.18)');
            gradientHadir.addColorStop(1, 'rgba(59, 130, 246, 0.0)');

            const trenData = @json($trenKehadiran);
            const bulanNames = @json($namaBulan);
            const labels = trenData.map(t => bulanNames[t.periode_bulan] ? bulanNames[t.periode_bulan].substring(0, 3) : t.periode_bulan);
            const sakitData = trenData.map(t => parseInt(t.total_sakit));
            const izinData = trenData.map(t => parseInt(t.total_izin));
            const alpaData = trenData.map(t => parseInt(t.total_alpa));

            new Chart(lineCtx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                            label: 'Sakit',
                            data: sakitData,
                            borderColor: '#3b82f6',
                            borderWidth: 2.5,
                            backgroundColor: gradientHadir,
                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: '#3b82f6',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            pointHoverRadius: 6,
                        },
                        {
                            label: 'Izin',
                            data: izinData,
                            borderColor: '#fbbf24',
                            borderWidth: 2,
                            backgroundColor: 'transparent',
                            fill: false,
                            tension: 0.4,
                            pointBackgroundColor: '#fbbf24',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            pointHoverRadius: 6,
                        },
                        {
                            label: 'Alpa',
                            data: alpaData,
                            borderColor: '#f87171',
                            borderWidth: 2,
                            backgroundColor: 'transparent',
                            fill: false,
                            tension: 0.4,
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
                    plugins: {
                        legend: { display: false },
                        tooltip: { backgroundColor: '#1e293b', titleColor: '#94a3b8', bodyColor: '#fff', padding: 10, callbacks: { label: ctx => ` ${ctx.dataset.label}: ${ctx.parsed.y}` } }
                    },
                    scales: {
                        x: { grid: { display: false }, border: { display: false }, ticks: { color: '#94a3b8', font: { size: 11 } } },
                        y: { min: 0, grid: { color: '#f1f5f9', lineWidth: 1 }, border: { display: false }, ticks: { color: '#94a3b8', font: { size: 11 }, stepSize: 5 } }
                    }
                }
            });

            // ---- Pie Chart: Distribusi Kehadiran ----
            const pieCtx = document.getElementById('pieChart').getContext('2d');
            new Chart(pieCtx, {
                type: 'pie',
                data: {
                    labels: ['Sakit', 'Izin', 'Alpa'],
                    datasets: [{
                        data: [{{ $totalSakit }}, {{ $totalIzin }}, {{ $totalAlpaAll }}],
                        backgroundColor: ['#3b82f6', '#fbbf24', '#f87171'],
                        borderWidth: 2,
                        borderColor: '#fff',
                        hoverOffset: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: { backgroundColor: '#1e293b', titleColor: '#94a3b8', bodyColor: '#fff', padding: 10, callbacks: { label: ctx => ` ${ctx.label}: ${ctx.parsed} hari` } }
                    }
                }
            });
        });


        // tabel
        const searchGuru = document.getElementById('searchGuru');
        const tableRows  = document.querySelectorAll('tbody tr[data-nama]');
        const emptyRow   = document.getElementById('emptyRow');

        function filterTable() {
            const keyword = searchGuru.value.toLowerCase().trim();
            let visibleCount = 0;

            tableRows.forEach(row => {
                const nama = row.dataset.nama.toLowerCase();
                if (nama.includes(keyword)) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            if (emptyRow) {
                emptyRow.style.display = visibleCount === 0 ? '' : 'none';
            }
        }

        searchGuru.addEventListener('input', filterTable);
    </script>
    @endpush

</x-app>