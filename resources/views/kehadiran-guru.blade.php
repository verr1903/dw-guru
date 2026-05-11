<x-app title="Kehadiran Guru | SMA Cendana Pekanbaru">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Kehadiran Guru</h1>
            <p class="text-sm text-gray-500 mt-1">Pantau kehadiran tenaga pengajar secara real-time</p>
        </div>
        <div class="flex items-center gap-3">
            {{-- Filter Periode --}}
            <div class="relative">
                <select id="periodeSelect"
                    class="appearance-none bg-white border border-gray-200 rounded-xl px-4 py-2.5 pr-9 text-sm font-medium text-gray-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-amber-400 cursor-pointer">
                    <option value="hari_ini" selected>Hari Ini</option>
                    <option value="minggu_ini">Minggu Ini</option>
                    <option value="bulan_ini">Bulan Ini</option>
                    <option value="semester">Semester Ini</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>
            </div>
            {{-- Export Button --}}
            <button onclick="exportExcel()"
                class="bg-gray-900 hover:bg-gray-700 text-white text-sm font-semibold px-5 py-2.5 rounded-xl shadow transition-all duration-150 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                Export Excel
            </button>
        </div>
    </div>

    {{-- Stat Cards --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-5 gap-4 mb-8">

        {{-- Total Guru --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Total Guru</p>
            <p class="text-3xl font-bold text-gray-900 mt-2">50</p>
            <p class="text-xs text-gray-400 mt-1">Tenaga Pengajar</p>
        </div>

        {{-- Kehadiran Hari Ini --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Kehadiran Hari Ini</p>
            <p class="text-3xl font-bold text-emerald-500 mt-2">92%</p>
            <div class="mt-2 w-full bg-gray-100 rounded-full h-1.5">
                <div class="bg-emerald-500 h-1.5 rounded-full" style="width: 92%"></div>
            </div>
        </div>

        {{-- Guru Hadir --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Guru Hadir</p>
            <p class="text-3xl font-bold text-gray-900 mt-2">46</p>
            <p class="text-xs text-emerald-600 font-medium mt-1 flex items-center gap-1">
                <span class="w-2 h-2 rounded-full bg-emerald-500 inline-block"></span>
                Hadir
            </p>
        </div>

        {{-- Guru Izin --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Guru Izin</p>
            <p class="text-3xl font-bold text-amber-500 mt-2">3</p>
            <p class="text-xs text-amber-600 font-medium mt-1 flex items-center gap-1">
                <span class="w-2 h-2 rounded-full bg-amber-400 inline-block"></span>
                Izin
            </p>
        </div>

        {{-- Guru Alfa --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Guru Alfa</p>
            <p class="text-3xl font-bold text-red-500 mt-2">1</p>
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
                    <h2 class="text-base font-semibold text-gray-900">Tren Kehadiran</h2>
                    <p class="text-xs text-gray-400 mt-0.5">Persentase kehadiran per hari dalam seminggu</p>
                </div>
                <div class="flex items-center gap-3 text-xs text-gray-500">
                    <span class="flex items-center gap-1.5"><span class="w-3 h-0.5 bg-emerald-500 inline-block rounded"></span> Hadir</span>
                    <span class="flex items-center gap-1.5"><span class="w-3 h-0.5 bg-amber-400 inline-block rounded"></span> Izin</span>
                    <span class="flex items-center gap-1.5"><span class="w-3 h-0.5 bg-red-400 inline-block rounded"></span> Alfa</span>
                </div>
            </div>
            <div class="relative h-56">
                <canvas id="lineChart"></canvas>
            </div>
        </div>

        {{-- Pie/Donut Chart: Distribusi Status --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 lg:col-span-2">
            <div class="mb-4">
                <h2 class="text-base font-semibold text-gray-900">Distribusi Status Kehadiran</h2>
                <p class="text-xs text-gray-400 mt-0.5">Hari ini</p>
            </div>
            <div class="relative h-44 flex items-center justify-center">
                <canvas id="pieChart"></canvas>
            </div>
            <div class="grid grid-cols-3 gap-2 mt-5">
                <div class="flex flex-col items-center gap-1">
                    <span class="w-3 h-3 rounded-full bg-emerald-500 shrink-0"></span>
                    <span class="text-xs text-gray-500">Hadir</span>
                    <span class="text-sm font-bold text-gray-800">46</span>
                </div>
                <div class="flex flex-col items-center gap-1">
                    <span class="w-3 h-3 rounded-full bg-amber-400 shrink-0"></span>
                    <span class="text-xs text-gray-500">Izin</span>
                    <span class="text-sm font-bold text-gray-800">3</span>
                </div>
                <div class="flex flex-col items-center gap-1">
                    <span class="w-3 h-3 rounded-full bg-red-400 shrink-0"></span>
                    <span class="text-xs text-gray-500">Alfa</span>
                    <span class="text-sm font-bold text-gray-800">1</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Table: Detail Kehadiran Guru --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 px-6 py-4 border-b border-gray-100">
            <h2 class="text-base font-semibold text-gray-900">Detail Kehadiran Guru</h2>
            <div class="flex items-center gap-3">
                {{-- Search --}}
                <div class="relative">
                    <input type="text" placeholder="Cari guru..."
                        class="bg-gray-50 border border-gray-200 rounded-xl pl-9 pr-4 py-2 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-amber-400 w-44">
                    <svg class="w-4 h-4 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                {{-- Filter Departemen --}}
                <select class="bg-gray-50 border border-gray-200 rounded-xl px-3 py-2 text-sm text-gray-700 focus:outline-none">
                    <option>Semua Departemen</option>
                    <option>MIPA</option>
                    <option>IPS</option>
                    <option>Bahasa</option>
                    <option>Olahraga & Seni</option>
                </select>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 text-left">
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Guru</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Hari Kerja</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Kehadiran</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Izin</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Alfa</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Persentase</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @php
                    $guruKehadiran = [
                    ['nama' => 'Budi Santoso', 'mapel' => 'Matematika', 'hari_kerja' => 20, 'hadir' => 19, 'izin' => 1, 'alfa' => 0],
                    ['nama' => 'Siti Rahayu', 'mapel' => 'Bahasa Indonesia', 'hari_kerja' => 20, 'hadir' => 18, 'izin' => 1, 'alfa' => 1],
                    ['nama' => 'Ahmad Fauzi', 'mapel' => 'Fisika', 'hari_kerja' => 20, 'hadir' => 20, 'izin' => 0, 'alfa' => 0],
                    ['nama' => 'Rina Marlina', 'mapel' => 'Kimia', 'hari_kerja' => 20, 'hadir' => 17, 'izin' => 3, 'alfa' => 0],
                    ['nama' => 'Doni Kusuma', 'mapel' => 'Biologi', 'hari_kerja' => 20, 'hadir' => 15, 'izin' => 2, 'alfa' => 3],
                    ['nama' => 'Wulandari', 'mapel' => 'Sejarah', 'hari_kerja' => 20, 'hadir' => 20, 'izin' => 0, 'alfa' => 0],
                    ['nama' => 'Hendra Wijaya', 'mapel' => 'Bahasa Inggris', 'hari_kerja' => 20, 'hadir' => 18, 'izin' => 2, 'alfa' => 0],
                    ['nama' => 'Suci Rahmawati', 'mapel' => 'Ekonomi', 'hari_kerja' => 20, 'hadir' => 19, 'izin' => 0, 'alfa' => 1],
                    ];
                    @endphp

                    @foreach($guruKehadiran as $guru)
                    @php
                    $persen = round(($guru['hadir'] / $guru['hari_kerja']) * 100);
                    $colorBar = $persen >= 90 ? 'bg-emerald-500' : ($persen >= 75 ? 'bg-amber-400' : 'bg-red-400');
                    $colorText = $persen >= 90 ? 'text-emerald-600' : ($persen >= 75 ? 'text-amber-600' : 'text-red-500');
                    @endphp
                    <tr class="hover:bg-gray-50 transition-colors">
                        {{-- Nama --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center text-xs font-bold shrink-0">
                                    {{ substr($guru['nama'], 0, 1) }}{{ substr(strstr($guru['nama'], ' '), 1, 1) }}
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800">{{ $guru['nama'] }}</p>
                                    <p class="text-xs text-gray-400">{{ $guru['mapel'] }}</p>
                                </div>
                            </div>
                        </td>
                        {{-- Total Hari Kerja --}}
                        <td class="px-6 py-4 text-gray-700 font-medium">{{ $guru['hari_kerja'] }}</td>
                        {{-- Kehadiran --}}
                        <td class="px-6 py-4 font-semibold text-gray-800">{{ $guru['hadir'] }}</td>
                        {{-- Izin --}}
                        <td class="px-6 py-4">
                            @if($guru['izin'] > 0)
                            <span class="badge badge-izin">{{ $guru['izin'] }}</span>
                            @else
                            <span class="text-gray-400 font-medium">—</span>
                            @endif
                        </td>
                        {{-- Alfa --}}
                        <td class="px-6 py-4">
                            @if($guru['alfa'] > 0)
                            <span class="badge badge-alfa">{{ $guru['alfa'] }}</span>
                            @else
                            <span class="text-gray-400 font-medium">—</span>
                            @endif
                        </td>
                        {{-- Persentase --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <div class="progress-bar-wrap">
                                    <div class="progress-bar-fill {{ $colorBar }}" style="width: {{ $persen }}%"></div>
                                </div>
                                <span class="font-semibold {{ $colorText }}">{{ $persen }}%</span>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between">
            <p class="text-xs text-gray-500">Menampilkan 8 dari 50 guru</p>
            <div class="flex items-center gap-1">
                <button class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:bg-gray-100">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button class="w-8 h-8 flex items-center justify-center rounded-lg bg-gray-900 text-white text-xs font-medium">1</button>
                <button class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-600 hover:bg-gray-100 text-xs">2</button>
                <button class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-600 hover:bg-gray-100 text-xs">3</button>
                <button class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:bg-gray-100">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ---- Line Chart: Tren Kehadiran ----
            const lineCtx = document.getElementById('lineChart').getContext('2d');

            const gradientHadir = lineCtx.createLinearGradient(0, 0, 0, 220);
            gradientHadir.addColorStop(0, 'rgba(16, 185, 129, 0.18)');
            gradientHadir.addColorStop(1, 'rgba(16, 185, 129, 0.0)');

            new Chart(lineCtx, {
                type: 'line',
                data: {
                    labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'],
                    datasets: [{
                            label: 'Hadir',
                            data: [92, 90, 94, 88, 92],
                            borderColor: '#10b981',
                            borderWidth: 2.5,
                            backgroundColor: gradientHadir,
                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: '#10b981',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            pointHoverRadius: 6,
                        },
                        {
                            label: 'Izin',
                            data: [4, 6, 4, 8, 6],
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
                            label: 'Alfa',
                            data: [4, 4, 2, 4, 2],
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
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: '#1e293b',
                            titleColor: '#94a3b8',
                            bodyColor: '#fff',
                            padding: 10,
                            callbacks: {
                                label: ctx => ` ${ctx.dataset.label}: ${ctx.parsed.y}%`
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
                            max: 100,
                            grid: {
                                color: '#f1f5f9',
                                lineWidth: 1
                            },
                            border: {
                                display: false,
                                dash: [4, 4]
                            },
                            ticks: {
                                color: '#94a3b8',
                                font: {
                                    size: 11
                                },
                                stepSize: 20,
                                callback: val => val + '%'
                            }
                        }
                    }
                }
            });

            // ---- Pie Chart: Distribusi Kehadiran ----
            const pieCtx = document.getElementById('pieChart').getContext('2d');
            new Chart(pieCtx, {
                type: 'pie',
                data: {
                    labels: ['Hadir', 'Izin', 'Alfa'],
                    datasets: [{
                        data: [46, 3, 1],
                        backgroundColor: ['#10b981', '#fbbf24', '#f87171'],
                        borderWidth: 2,
                        borderColor: '#fff',
                        hoverOffset: 6
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
                                label: ctx => ` ${ctx.label}: ${ctx.parsed} guru`
                            }
                        }
                    }
                }
            });
        });

        function exportExcel() {
            const sel = document.getElementById('periodeSelect');
            const periode = sel.options[sel.selectedIndex].text;
            alert(`Data kehadiran "${periode}" sedang diekspor ke Excel...`);
        }
    </script>
    @endpush

</x-app>