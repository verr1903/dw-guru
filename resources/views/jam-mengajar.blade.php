<x-app title="Jam Mengajar | SMA Cendana Pekanbaru">

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
    <div id="detail-jam" class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

        {{-- Table Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 px-6 py-4 border-b border-gray-100">
            <div>
                <h2 class="text-base font-semibold text-gray-900">Detail Data Mengajar</h2>
                <p class="text-xs text-gray-400 mt-0.5">Semua entri jam mengajar guru</p>
            </div>
            <div class="flex items-center gap-2">
                <div class="relative">
                    <input
                        type="text"
                        id="searchGuru"
                        value="{{ $search }}"
                        placeholder="Cari nama guru..."
                        class="bg-gray-50 border border-gray-200 rounded-xl pl-9 pr-4 py-2 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-amber-400 w-44">
                    <svg class="w-4 h-4 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <select id="filterMapel"
                    class="bg-gray-50 border border-gray-200 rounded-xl px-3 py-2 text-sm text-gray-700 focus:outline-none">
                    <option value="">Semua Mapel</option>
                    @foreach($daftarMapel as $m)
                    <option value="{{ strtolower($m) }}" {{ strtolower($mapel) == strtolower($m) ? 'selected' : '' }}>{{ $m }}</option>
                    @endforeach
                </select>
            </div>
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
                        $kelasX   = $row->x_1 + $row->x_2 + $row->x_3;
                        $kelasXI  = $row->xi_1 + $row->xi_2 + $row->xi_3;
                        $kelasXII = $row->xii_1 + $row->xii_2 + $row->xii_3;
                    @endphp
                    <tr class="hover:bg-gray-50 transition-colors"
                        data-nama="{{ strtolower($row->nama_guru) }}"
                        data-mapel="{{ strtolower($row->bidang_studi) }}">
                        <td class="px-6 py-3.5">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center text-xs font-bold shrink-0">
                                    {{ strtoupper(substr($row->nama_guru, 0, 2)) }}
                                </div>
                                <span class="font-medium text-gray-800">{{ $row->nama_guru }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-3.5 text-gray-600">{{ $row->bidang_studi?: 'Tidak Diketahui' }}</td>
                        <td class="px-6 py-3.5">
                            <span class="font-semibold text-gray-800">{{ $row->total_jam }}</span>
                            <span class="text-gray-400 text-xs"> jam</span>
                        </td>
                        <td class="px-6 py-3.5 text-gray-600">{{ $kelasX }} <span class="text-gray-400 text-xs"> jam</span></td>
                        <td class="px-6 py-3.5 text-gray-600">{{ $kelasXI }} <span class="text-gray-400 text-xs"> jam</span></td>
                        <td class="px-6 py-3.5 text-gray-600">{{ $kelasXII }} <span class="text-gray-400 text-xs"> jam</span></td>
                        <td class="px-6 py-3.5 text-gray-600">{{ $row->periode_tahun }}</td>
                    </tr>
                    @empty
                    <tr id="emptyRow">
                        <td colspan="7" class="px-6 py-8 text-center text-gray-400">Tidak ada data jam mengajar.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between">
            <p class="text-xs text-gray-500">
                Menampilkan {{ $jamMengajarData->count() }} dari {{ $jamMengajarData->total() }} guru
            </p>
            <div class="flex items-center gap-1">

                {{-- Previous --}}
                @if ($jamMengajarData->onFirstPage())
                <span class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-300 cursor-not-allowed">...</span>
                @else
                <a href="{{ $jamMengajarData->previousPageUrl() }}#detail-jam"
                    class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100">...</a>
                @endif

                {{-- Page Numbers --}}
                @for ($i = 1; $i <= $jamMengajarData->lastPage(); $i++)
                <a href="{{ $jamMengajarData->url($i) }}#detail-jam"
                    class="w-8 h-8 flex items-center justify-center rounded-lg text-xs font-medium
                    {{ $jamMengajarData->currentPage() == $i ? 'bg-gray-900 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                    {{ $i }}
                </a>
                @endfor

                {{-- Next --}}
                @if ($jamMengajarData->hasMorePages())
                <a href="{{ $jamMengajarData->nextPageUrl() }}#detail-jam"
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

    // ---- Line Chart ----
    try {
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
                    borderColor: '#6366f1', borderWidth: 2,
                    backgroundColor: gradient, fill: true, tension: 0.4,
                    pointBackgroundColor: '#6366f1', pointBorderColor: '#fff',
                    pointBorderWidth: 2, pointRadius: 4, pointHoverRadius: 6,
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
    } catch(e) { console.error('Line chart error:', e); }

    // ---- Donut Chart ----
    try {
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
    } catch(e) { console.error('Donut chart error:', e); }

    // ---- Bar Chart ----
    try {
        const barCtx = document.getElementById('barChart').getContext('2d');
        const mapelData = @json($jamPerMapel->take(8));
        new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: mapelData.map(m => {
                    const label = m.bidang_studi || 'Tidak Diketahui';
                    return label.length > 10 ? label.substring(0, 10) + '...' : label;
                }),
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
    } catch(e) { console.error('Bar chart error:', e); }

    // ---- Realtime Search ----
    const searchInput = document.getElementById('searchGuru');
    const mapelSelect = document.getElementById('filterMapel');
    const tableRows   = document.querySelectorAll('tbody tr[data-nama]');
    const emptyRow    = document.getElementById('emptyRow');

    function filterTable() {
        const keyword = searchInput.value.toLowerCase().trim();
        const mapel   = mapelSelect.value.toLowerCase().trim();
        let visibleCount = 0;

        tableRows.forEach(row => {
            const nama     = row.dataset.nama.toLowerCase();
            const mapelRow = row.dataset.mapel.toLowerCase();
            const matchNama  = nama.includes(keyword);
            const matchMapel = mapel === '' || mapelRow === mapel;

            if (matchNama && matchMapel) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        if (emptyRow) emptyRow.style.display = visibleCount === 0 ? '' : 'none';
    }

    if (searchInput) searchInput.addEventListener('input', filterTable);
    if (mapelSelect) mapelSelect.addEventListener('change', filterTable);

});
    </script>
    @endpush

</x-app>