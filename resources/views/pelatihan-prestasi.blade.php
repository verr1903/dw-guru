<x-app title="Pelatihan & Prestasi | SMA Cendana Pekanbaru">

    {{-- ===== HEADER ===== --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Pelatihan & Prestasi</h1>
            <p class="text-sm text-gray-500 mt-1">Rekap kegiatan pelatihan dan pencapaian tenaga pengajar</p>
        </div>
        <div class="flex items-center gap-3">
            <form method="GET" action="{{ route('pelatihan-prestasi') }}" class="flex items-center gap-3">
                <input type="hidden" name="tab" value="{{ $tab }}">
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

    {{-- ===== STAT CARDS ===== --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 mb-8">

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex items-start gap-4">
            <div class="w-11 h-11 rounded-xl bg-amber-500 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                </svg>
            </div>
            <div>
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Total Prestasi ({{ $tahun }})</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">
                    {{ $totalPrestasi }} <span class="text-base font-semibold text-gray-600">Prestasi</span>
                </p>
                <p class="text-xs text-gray-400 mt-1">Pencapaian tenaga pengajar</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex items-start gap-4">
            <div class="w-11 h-11 rounded-xl bg-indigo-500 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
            </div>
            <div>
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Total Pelatihan ({{ $tahun }})</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">
                    {{ $totalPelatihanTahunIni }} <span class="text-base font-semibold text-gray-600">Kegiatan</span>
                </p>
                <p class="text-xs text-gray-400 mt-1">Kegiatan pelatihan tercatat</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex items-start gap-4">
            <div class="w-11 h-11 rounded-xl bg-emerald-500 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <div>
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Guru Berprestasi</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">
                    {{ $guruBerprestasi }} <span class="text-base font-semibold text-gray-600">Guru</span>
                </p>
                <p class="text-xs text-gray-400 mt-1">Meraih prestasi tahun ini</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex items-start gap-4">
            <div class="w-11 h-11 rounded-xl bg-blue-500 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </div>
            <div>
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Guru Ikut Pelatihan</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">
                    {{ $guruPelatihan }} <span class="text-base font-semibold text-gray-600">Guru</span>
                </p>
                <p class="text-xs text-gray-400 mt-1">Mengikuti pelatihan tahun ini</p>
            </div>
        </div>

    </div>

    {{-- ===== CHARTS ===== --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">

        {{-- Prestasi per Tingkat --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h2 class="text-base font-semibold text-gray-900">Distribusi Prestasi per Tingkat</h2>
                    <p class="text-xs text-gray-400 mt-0.5">Jumlah prestasi berdasarkan tingkat kegiatan</p>
                </div>
                <span class="bg-amber-50 text-amber-700 text-xs font-medium px-3 py-1 rounded-full border border-amber-100">{{ $tahun }}</span>
            </div>
            <div class="relative h-52">
                <canvas id="prestasiChart"></canvas>
            </div>
        </div>

        {{-- Pelatihan per Bulan --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h2 class="text-base font-semibold text-gray-900">Tren Pelatihan per Bulan</h2>
                    <p class="text-xs text-gray-400 mt-0.5">Jumlah kegiatan pelatihan tiap bulan</p>
                </div>
                <span class="bg-indigo-50 text-indigo-700 text-xs font-medium px-3 py-1 rounded-full border border-indigo-100">{{ $tahun }}</span>
            </div>
            <div class="relative h-52">
                <canvas id="pelatihanChart"></canvas>
            </div>
        </div>

    </div>

    {{-- ===== TABS ===== --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

        {{-- Tab Header --}}
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <div class="flex gap-1 bg-gray-100 rounded-xl p-1">
                <a href="{{ route('pelatihan-prestasi', ['tahun' => $tahun, 'tab' => 'prestasi']) }}#tab-prestasi"
                    class="px-4 py-1.5 rounded-lg text-sm font-medium transition-all
                    {{ $tab === 'prestasi' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                    Prestasi
                </a>
                <a href="{{ route('pelatihan-prestasi', ['tahun' => $tahun, 'tab' => 'pelatihan']) }}#tab-pelatihan"
                    class="px-4 py-1.5 rounded-lg text-sm font-medium transition-all
                    {{ $tab === 'pelatihan' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                    Pelatihan
                </a>
            </div>

            {{-- Search & Filter --}}
            <div class="flex items-center gap-2">
                <div class="relative">
                    <input
                        type="text"
                        id="searchInput"
                        placeholder="{{ $tab === 'prestasi' ? 'Cari guru atau kegiatan...' : 'Cari guru atau pelatihan...' }}"
                        value="{{ $search }}"
                        class="bg-gray-50 border border-gray-200 rounded-xl pl-9 pr-4 py-2 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-amber-400 w-52">
                    <svg class="w-4 h-4 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>

                @if($tab === 'prestasi')
                <select id="filterTingkat"
                    class="bg-gray-50 border border-gray-200 rounded-xl px-3 py-2 text-sm text-gray-700 focus:outline-none">
                    <option value="">Semua Tingkat</option>
                    @foreach($daftarTingkat as $t)
                    <option value="{{ strtolower($t) }}" {{ strtolower($tingkat ?? '') == strtolower($t) ? 'selected' : '' }}>{{ $t }}</option>
                    @endforeach
                </select>
                @endif
            </div>
        </div>

        {{-- ===== TAB PRESTASI ===== --}}
        @if($tab === 'prestasi')
        <div id="tab-prestasi" class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 text-left">
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Guru</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Kegiatan</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Prestasi</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Penyelenggara</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Tingkat</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($prestasiData as $item)
                    <tr class="hover:bg-gray-50 transition-colors"
                        data-nama="{{ strtolower($item->nama_guru) }}"
                        data-kegiatan="{{ strtolower($item->kegiatan) }}"
                        data-tingkat="{{ strtolower($item->tingkat_kegiatan) }}">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-amber-100 text-amber-700 flex items-center justify-center text-xs font-bold shrink-0">
                                    {{ strtoupper(substr($item->nama_guru, 0, 2)) }}
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800">{{ $item->nama_guru }}</p>
                                    <p class="text-xs text-gray-400">{{ $item->nip ?? '-' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-gray-700 max-w-xs">
                            <p class="truncate">{{ $item->kegiatan }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-50 text-amber-700 border border-amber-100">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                {{ $item->prestasi }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-600 text-sm">{{ $item->penyelenggara_kegiatan ?? '-' }}</td>
                        <td class="px-6 py-4">
                            @php
                                $tingkatColor = match(strtolower($item->tingkat_kegiatan ?? '')) {
                                    'internasional' => 'bg-purple-50 text-purple-700 border-purple-100',
                                    'nasional'      => 'bg-blue-50 text-blue-700 border-blue-100',
                                    'provinsi'      => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                                    'kabupaten', 'kota' => 'bg-orange-50 text-orange-700 border-orange-100',
                                    default         => 'bg-gray-50 text-gray-600 border-gray-100',
                                };
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $tingkatColor }}">
                                {{ $item->tingkat_kegiatan ?? '-' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-500 text-sm">
                            {{ $item->tanggal_kegiatan?->format('d M Y') ?? '-' }}
                        </td>
                    </tr>
                    @empty
                    <tr id="emptyRow">
                        <td colspan="6" class="px-6 py-10 text-center text-gray-400">Tidak ada data prestasi untuk tahun {{ $tahun }}.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination Prestasi --}}
        <div id="detail-prestasi" class="px-6 py-4 border-t border-gray-100 flex items-center justify-between">
            <p class="text-xs text-gray-500">Menampilkan {{ $prestasiData->count() }} dari {{ $prestasiData->total() }} prestasi</p>
            <div class="flex items-center gap-1">
                @if ($prestasiData->onFirstPage())
                <span class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-300 cursor-not-allowed">...</span>
                @else
                <a href="{{ $prestasiData->previousPageUrl() }}#detail-prestasi" class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100">...</a>
                @endif

                @for ($i = 1; $i <= $prestasiData->lastPage(); $i++)
                <a href="{{ $prestasiData->url($i) }}#detail-prestasi"
                    class="w-8 h-8 flex items-center justify-center rounded-lg text-xs font-medium {{ $prestasiData->currentPage() == $i ? 'bg-gray-900 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                    {{ $i }}
                </a>
                @endfor

                @if ($prestasiData->hasMorePages())
                <a href="{{ $prestasiData->nextPageUrl() }}#detail-prestasi" class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100">...</a>
                @else
                <span class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-300 cursor-not-allowed">...</span>
                @endif
            </div>
        </div>

        {{-- ===== TAB PELATIHAN ===== --}}
        @else
        <div class="overflow-x-auto">
            <table id="tab-pelatihan" class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 text-left">
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Guru</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Kegiatan</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal Mulai</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal Selesai</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Durasi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($pelatihanData as $item)
                    <tr class="hover:bg-gray-50 transition-colors"
                        data-nama="{{ strtolower($item->nama_guru) }}"
                        data-kegiatan="{{ strtolower($item->nama_kegiatan) }}">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center text-xs font-bold shrink-0">
                                    {{ strtoupper(substr($item->nama_guru, 0, 2)) }}
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800">{{ $item->nama_guru }}</p>
                                    <p class="text-xs text-gray-400">{{ $item->nip ?? '-' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-gray-700 max-w-xs">
                            <p class="truncate">{{ $item->nama_kegiatan }}</p>
                        </td>
                        <td class="px-6 py-4 text-gray-500 text-sm">
                            {{ $item->start_date?->format('d M Y') ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-gray-500 text-sm">
                            {{ $item->end_date?->format('d M Y') ?? '-' }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-50 text-indigo-700 border border-indigo-100">
                                {{ $item->durasi_hari }} hari
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr id="emptyRow">
                        <td colspan="5" class="px-6 py-10 text-center text-gray-400">Tidak ada data pelatihan untuk tahun {{ $tahun }}.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination Pelatihan --}}
        <div id="detail-pelatihan" class="px-6 py-4 border-t border-gray-100 flex items-center justify-between">
            <p class="text-xs text-gray-500">Menampilkan {{ $pelatihanData->count() }} dari {{ $pelatihanData->total() }} kegiatan</p>
            <div class="flex items-center gap-1">
                @if ($pelatihanData->onFirstPage())
                <span class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-300 cursor-not-allowed">...</span>
                @else
                <a href="{{ $pelatihanData->previousPageUrl() }}#detail-pelatihan" class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100">...</a>
                @endif

                @for ($i = 1; $i <= $pelatihanData->lastPage(); $i++)
                <a href="{{ $pelatihanData->url($i) }}#detail-pelatihan"
                    class="w-8 h-8 flex items-center justify-center rounded-lg text-xs font-medium {{ $pelatihanData->currentPage() == $i ? 'bg-gray-900 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                    {{ $i }}
                </a>
                @endfor

                @if ($pelatihanData->hasMorePages())
                <a href="{{ $pelatihanData->nextPageUrl() }}#detail-pelatihan" class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100">...</a>
                @else
                <span class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-300 cursor-not-allowed">...</span>
                @endif
            </div>
        </div>
        @endif

    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            // ---- Chart: Prestasi per Tingkat ----
            try {
                const prestasiCtx = document.getElementById('prestasiChart').getContext('2d');
                const prestasiData = @json($prestasiPerTingkat);
                new Chart(prestasiCtx, {
                    type: 'doughnut',
                    data: {
                        labels: prestasiData.map(d => d.tingkat_kegiatan || 'Lainnya'),
                        datasets: [{
                            data: prestasiData.map(d => d.jumlah),
                            backgroundColor: ['#6366f1', '#f59e0b', '#34d399', '#60a5fa', '#f97316', '#e5e7eb'],
                            borderWidth: 2, borderColor: '#fff', hoverOffset: 5,
                        }]
                    },
                    options: {
                        responsive: true, maintainAspectRatio: false, cutout: '60%',
                        plugins: {
                            legend: { position: 'right', labels: { boxWidth: 10, boxHeight: 10, font: { size: 10 }, color: '#6b7280', padding: 10 } },
                            tooltip: { backgroundColor: '#1e293b', bodyColor: '#fff', padding: 8, callbacks: { label: ctx => ` ${ctx.label}: ${ctx.parsed} prestasi` } }
                        }
                    }
                });
            } catch(e) { console.error('Prestasi chart error:', e); }

            // ---- Chart: Pelatihan per Bulan ----
            try {
                const pelatihanCtx = document.getElementById('pelatihanChart').getContext('2d');
                const gradient = pelatihanCtx.createLinearGradient(0, 0, 0, 200);
                gradient.addColorStop(0, 'rgba(99,102,241,0.2)');
                gradient.addColorStop(1, 'rgba(99,102,241,0)');

                const pelatihanData = @json($pelatihanPerBulan);
                const namaBulan = @json($namaBulan);
                const labels = [], values = [];

                for (let i = 1; i <= 12; i++) {
                    if (pelatihanData[i] !== undefined) {
                        labels.push(namaBulan[i].substring(0, 3));
                        values.push(pelatihanData[i]);
                    }
                }

                new Chart(pelatihanCtx, {
                    type: 'bar',
                    data: {
                        labels,
                        datasets: [{
                            data: values,
                            backgroundColor: '#6366f1',
                            borderRadius: 6, borderSkipped: false,
                            hoverBackgroundColor: '#4f46e5',
                        }]
                    },
                    options: {
                        responsive: true, maintainAspectRatio: false,
                        plugins: { legend: { display: false }, tooltip: { backgroundColor: '#1e293b', bodyColor: '#fff', padding: 8, callbacks: { label: ctx => ` ${ctx.parsed.y} kegiatan` } } },
                        scales: {
                            x: { grid: { display: false }, border: { display: false }, ticks: { color: '#94a3b8', font: { size: 10 } } },
                            y: { grid: { color: '#f1f5f9' }, border: { display: false }, ticks: { color: '#94a3b8', font: { size: 10 }, stepSize: 1 }, min: 0 }
                        }
                    }
                });
            } catch(e) { console.error('Pelatihan chart error:', e); }

            // ---- Realtime Search ----
            const searchInput = document.getElementById('searchInput');
            const filterTingkat = document.getElementById('filterTingkat');
            const tableRows = document.querySelectorAll('tbody tr[data-nama]');
            const emptyRow = document.getElementById('emptyRow');

            function filterTable() {
                const keyword = searchInput ? searchInput.value.toLowerCase().trim() : '';
                const tingkat = filterTingkat ? filterTingkat.value.toLowerCase().trim() : '';
                let visibleCount = 0;

                tableRows.forEach(row => {
                    const nama     = row.dataset.nama || '';
                    const kegiatan = row.dataset.kegiatan || '';
                    const rowTingkat = row.dataset.tingkat || '';

                    const matchKeyword = nama.includes(keyword) || kegiatan.includes(keyword);
                    const matchTingkat = tingkat === '' || rowTingkat === tingkat;

                    if (matchKeyword && matchTingkat) {
                        row.style.display = '';
                        visibleCount++;
                    } else {
                        row.style.display = 'none';
                    }
                });

                if (emptyRow) emptyRow.style.display = visibleCount === 0 ? '' : 'none';
            }

            if (searchInput) searchInput.addEventListener('input', filterTable);
            if (filterTingkat) filterTingkat.addEventListener('change', filterTable);
        });
    </script>
    @endpush

</x-app>