<x-app title="Jam Mengajar | SMA Cendana Pekanbaru">

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Jam Mengajar</h1>
        <nav class="flex items-center gap-1.5 mt-1 text-xs text-gray-400">
            <a href="{{ route('dashboard') }}" class="hover:text-gray-600 transition-colors">Dashboard</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <span class="text-gray-600 font-medium">Jam Mengajar</span>
        </nav>
    </div>

    {{-- ===== FILTER BAR ===== --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 mb-6">
        <form method="GET" action="{{ route('jam-mengajar') }}" class="flex flex-wrap items-end gap-4">
            {{-- Mata Pelajaran --}}
            <div class="flex flex-col gap-1.5 min-w-0 flex-1" style="min-width:160px">
                <label class="text-xs font-semibold text-gray-500">Mata Pelajaran</label>
                <div class="relative">
                    <select name="mapel"
                        class="w-full appearance-none bg-white border border-gray-200 rounded-xl px-3 py-2.5 pr-8 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-amber-400">
                        <option value="">Semua Mata Pelajaran</option>
                        @foreach($daftarMapel as $m)
                            <option value="{{ $m }}" {{ ($mapel ?? '') == $m ? 'selected' : '' }}>{{ $m }}</option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-2.5 flex items-center">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Guru --}}
            <div class="flex flex-col gap-1.5 min-w-0 flex-1" style="min-width:160px">
                <label class="text-xs font-semibold text-gray-500">Guru</label>
                <div class="relative">
                    <select name="guru"
                        class="w-full appearance-none bg-white border border-gray-200 rounded-xl px-3 py-2.5 pr-8 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-amber-400">
                        <option value="">Semua Guru</option>
                        @foreach($daftarGuru as $g)
                            <option value="{{ $g }}" {{ ($guru ?? '') == $g ? 'selected' : '' }}>{{ $g }}</option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-2.5 flex items-center">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Tahun --}}
            <div class="flex flex-col gap-1.5 min-w-0 flex-1" style="min-width:140px">
                <label class="text-xs font-semibold text-gray-500">Tahun</label>
                <div class="relative">
                    <select name="tahun"
                        class="w-full appearance-none bg-white border border-gray-200 rounded-xl px-3 py-2.5 pr-8 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-amber-400">
                        @foreach($daftarTahun as $t)
                            <option value="{{ $t }}" {{ $tahun == $t ? 'selected' : '' }}>{{ $t }}</option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-2.5 flex items-center">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Button --}}
            <div class="flex gap-2">
                <button type="submit"
                    class="bg-gray-900 hover:bg-gray-700 text-white text-sm font-semibold px-5 py-2.5 rounded-xl shadow transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z" />
                    </svg>
                    Terapkan Filter
                </button>
                <a href="{{ route('jam-mengajar') }}"
                    class="bg-white hover:bg-gray-50 text-gray-600 text-sm font-medium px-4 py-2.5 rounded-xl border border-gray-200 transition-all">
                    Reset
                </a>
            </div>
        </form>
    </div>

    {{-- ===== CHARTS ROW ===== --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mb-6">

        {{-- Total Jam Mengajar (Line) --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <div class="flex items-center justify-between mb-1">
                <h2 class="text-sm font-semibold text-gray-800">Tren Jam per Tahun</h2>
                <span class="text-xs text-gray-400 bg-gray-50 border border-gray-100 rounded-full px-2.5 py-0.5">All</span>
            </div>
            <p class="text-xs text-gray-400 mb-4">Total jam per tahun ajaran</p>
            <div class="relative h-44">
                <canvas id="lineChart"></canvas>
            </div>
        </div>

        {{-- Distribusi per Guru (Donut) --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <h2 class="text-sm font-semibold text-gray-800 mb-1">Top 5 Guru</h2>
            <p class="text-xs text-gray-400 mb-3">Guru dengan jam mengajar terbanyak</p>
            <div class="relative h-44 flex items-center justify-center">
                <canvas id="donutChart"></canvas>
            </div>
        </div>

        {{-- Beban per Mata Pelajaran (Bar) --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <h2 class="text-sm font-semibold text-gray-800 mb-1">Jam per Bidang Studi</h2>
            <p class="text-xs text-gray-400 mb-3">Total jam mengajar per mapel</p>
            <div class="relative h-44">
                <canvas id="barChart"></canvas>
            </div>
        </div>
    </div>

    {{-- ===== DETAIL TABLE ===== --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

        {{-- Table Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 px-6 py-4 border-b border-gray-100">
            <div>
                <h2 class="text-base font-semibold text-gray-900">Detail Data Mengajar</h2>
                <p class="text-xs text-gray-400 mt-0.5">Semua entri jam mengajar guru</p>
            </div>
            <form method="GET" action="{{ route('jam-mengajar') }}" class="flex items-center gap-2">
                <input type="hidden" name="tahun" value="{{ $tahun }}">
                <div class="relative">
                    <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama guru..."
                        class="bg-gray-50 border border-gray-200 rounded-xl pl-9 pr-4 py-2 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-amber-400 w-44">
                    <svg class="w-4 h-4 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <button type="submit" class="bg-gray-900 hover:bg-gray-700 text-white text-xs font-semibold px-4 py-2 rounded-xl transition-all">Cari</button>
            </form>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Guru</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Mata Pelajaran</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Jam</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Kelas X</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Kelas XI</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Kelas XII</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Tahun</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($jamMengajarData as $row)
                    @php
                        $totalJam = $row->x_1 + $row->x_2 + $row->x_3 + $row->xi_1 + $row->xi_2 + $row->xi_3 + $row->xii_1 + $row->xii_2 + $row->xii_3 + $row->sd + $row->smp + $row->slb;
                        $kelasX = $row->x_1 + $row->x_2 + $row->x_3;
                        $kelasXI = $row->xi_1 + $row->xi_2 + $row->xi_3;
                        $kelasXII = $row->xii_1 + $row->xii_2 + $row->xii_3;
                    @endphp
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-3.5">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center text-xs font-bold shrink-0">
                                    {{ strtoupper(substr($row->nama_guru, 0, 2)) }}
                                </div>
                                <span class="font-medium text-gray-800">{{ $row->nama_guru }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-3.5 text-gray-600">{{ $row->bidang_studi }}</td>
                        <td class="px-6 py-3.5">
                            <span class="font-semibold text-gray-800">{{ $totalJam }}</span>
                            <span class="text-gray-400 text-xs"> jam</span>
                        </td>
                        <td class="px-6 py-3.5 text-gray-600">{{ $kelasX }} jam</td>
                        <td class="px-6 py-3.5 text-gray-600">{{ $kelasXI }} jam</td>
                        <td class="px-6 py-3.5 text-gray-600">{{ $kelasXII }} jam</td>
                        <td class="px-6 py-3.5 text-gray-600">{{ $row->periode_tahun }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-gray-400">Tidak ada data jam mengajar.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $jamMengajarData->appends(['tahun' => $tahun, 'search' => $search, 'mapel' => $mapel, 'guru' => $guru])->links() }}
        </div>
    </div>


    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ---- Line Chart: Tren per Tahun ----
            const lineCtx = document.getElementById('lineChart').getContext('2d');
            const gradient = lineCtx.createLinearGradient(0, 0, 0, 180);
            gradient.addColorStop(0, 'rgba(99,102,241,0.2)');
            gradient.addColorStop(1, 'rgba(99,102,241,0)');

            const trenData = @json($trenPerTahun);
            new Chart(lineCtx, {
                type: 'line',
                data: {
                    labels: trenData.map(t => t.periode_tahun.toString()),
                    datasets: [{
                        data: trenData.map(t => parseInt(t.total_jam)),
                        borderColor: '#6366f1',
                        borderWidth: 2,
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
                    responsive: true, maintainAspectRatio: false,
                    plugins: { legend: { display: false }, tooltip: { backgroundColor: '#1e293b', bodyColor: '#fff', padding: 8, callbacks: { label: ctx => ` ${ctx.parsed.y} jam` } } },
                    scales: {
                        x: { grid: { display: false }, border: { display: false }, ticks: { color: '#94a3b8', font: { size: 10 } } },
                        y: { grid: { color: '#f1f5f9' }, border: { display: false }, ticks: { color: '#94a3b8', font: { size: 10 } }, min: 0 }
                    }
                }
            });

            // ---- Donut Chart: Top 5 Guru ----
            const donutCtx = document.getElementById('donutChart').getContext('2d');
            const topGuru = @json($jamPerGuru->take(5));
            new Chart(donutCtx, {
                type: 'doughnut',
                data: {
                    labels: topGuru.map(g => g.nama_guru),
                    datasets: [{
                        data: topGuru.map(g => parseInt(g.total_jam)),
                        backgroundColor: ['#6366f1', '#34d399', '#fbbf24', '#60a5fa', '#e5e7eb'],
                        borderWidth: 2, borderColor: '#fff', hoverOffset: 5,
                    }]
                },
                options: {
                    responsive: true, maintainAspectRatio: false, cutout: '62%',
                    plugins: {
                        legend: { position: 'right', labels: { boxWidth: 10, boxHeight: 10, borderRadius: 3, font: { size: 10 }, color: '#6b7280', padding: 8 } },
                        tooltip: { backgroundColor: '#1e293b', bodyColor: '#fff', padding: 8, callbacks: { label: ctx => ` ${ctx.label}: ${ctx.parsed} jam` } }
                    }
                }
            });

            // ---- Bar Chart: Per Bidang Studi ----
            const barCtx = document.getElementById('barChart').getContext('2d');
            const mapelData = @json($jamPerMapel->take(8));
            new Chart(barCtx, {
                type: 'bar',
                data: {
                    labels: mapelData.map(m => m.bidang_studi.length > 10 ? m.bidang_studi.substring(0, 10) + '...' : m.bidang_studi),
                    datasets: [{
                        data: mapelData.map(m => parseInt(m.total_jam)),
                        backgroundColor: '#6366f1',
                        borderRadius: 5, borderSkipped: false, hoverBackgroundColor: '#4f46e5',
                    }]
                },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    plugins: { legend: { display: false }, tooltip: { backgroundColor: '#1e293b', bodyColor: '#fff', padding: 8, callbacks: { label: ctx => ` ${ctx.parsed.y} jam` } } },
                    scales: {
                        x: { grid: { display: false }, border: { display: false }, ticks: { color: '#94a3b8', font: { size: 9 } } },
                        y: { grid: { color: '#f1f5f9' }, border: { display: false }, ticks: { color: '#94a3b8', font: { size: 10 } }, min: 0 }
                    }
                }
            });
        });
    </script>
    @endpush

</x-app>