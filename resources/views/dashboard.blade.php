<x-app title="Dashboard | SMA Cendana Pekanbaru">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Dashboard Kinerja Mengajar Guru</h1>
            <p class="text-sm text-gray-500 mt-1">Pantau performa dan kehadiran tenaga pengajar</p>
        </div>
        <div class="flex items-center gap-3">
            <div class="relative">
                <select id="bulanSelect"
                    class="appearance-none bg-white border border-gray-200 rounded-xl px-4 py-2.5 pr-9 text-sm font-medium text-gray-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-amber-400 cursor-pointer">
                    <option value="1">Januari 2024</option>
                    <option value="2">Februari 2024</option>
                    <option value="3">Maret 2024</option>
                    <option value="4">April 2024</option>
                    <option value="5">Mei 2024</option>
                    <option value="6" selected>Juni 2024</option>
                    <option value="7">Juli 2024</option>
                    <option value="8">Agustus 2024</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>
            </div>
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
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Total Jam Mengajar (2024)</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">1,440 <span class="text-base font-semibold text-gray-600">Jam</span></p>
                <p class="text-xs text-emerald-600 font-medium mt-1 flex items-center gap-1">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                    +8% dari tahun lalu
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
                <p class="text-2xl font-bold text-gray-900 mt-1">97.5<span class="text-base font-semibold text-gray-600">%</span></p>
                <p class="text-xs text-emerald-600 font-medium mt-1 flex items-center gap-1">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                    +2% dari bulan lalu
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
                <p class="text-2xl font-bold text-gray-900 mt-1">48 <span class="text-base font-semibold text-gray-600">Guru</span></p>
                <p class="text-xs text-emerald-600 font-medium mt-1 flex items-center gap-1">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                    +3 dari bulan lalu
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
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Rata-rata Nilai Kinerja</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">86.4<span class="text-base font-semibold text-gray-600"> / 100</span></p>
                <p class="text-xs text-emerald-600 font-medium mt-1 flex items-center gap-1">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                    +1.2 dari semester lalu
                </p>
            </div>
        </div>
    </div>

    {{-- Charts --}}
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6 mb-8">

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 lg:col-span-3">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-base font-semibold text-gray-900">Tren Jam Mengajar per Bulan</h2>
                    <p class="text-xs text-gray-400 mt-0.5">Total jam terealisasi setiap bulan</p>
                </div>
                <span class="bg-gray-100 text-gray-600 text-xs font-medium px-3 py-1 rounded-full">2024</span>
            </div>
            <div class="relative h-56">
                <canvas id="lineChart"></canvas>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 lg:col-span-2">
            <div class="mb-6">
                <h2 class="text-base font-semibold text-gray-900">Perbandingan Kinerja Antar Semester</h2>
                <p class="text-xs text-gray-400 mt-0.5">Distribusi nilai guru</p>
            </div>
            <div class="relative h-44 flex items-center justify-center">
                <canvas id="donutChart"></canvas>
            </div>
            <div class="grid grid-cols-2 gap-x-4 gap-y-2 mt-4">
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-blue-500 shrink-0"></span>
                    <span class="text-xs text-gray-600">90-100</span>
                    <span class="text-xs font-semibold text-gray-800 ml-auto">35%</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-emerald-400 shrink-0"></span>
                    <span class="text-xs text-gray-600">80-89</span>
                    <span class="text-xs font-semibold text-gray-800 ml-auto">30%</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-amber-400 shrink-0"></span>
                    <span class="text-xs text-gray-600">70-79</span>
                    <span class="text-xs font-semibold text-gray-800 ml-auto">20%</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-red-400 shrink-0"></span>
                    <span class="text-xs text-gray-600">&lt; 70</span>
                    <span class="text-xs font-semibold text-gray-800 ml-auto">15%</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 px-6 py-4 border-b border-gray-100">
            <h2 class="text-base font-semibold text-gray-900">Rekap Kinerja Guru</h2>
            <div class="flex items-center gap-3">
                <div class="relative">
                    <input type="text" placeholder="Cari guru..."
                        class="bg-gray-50 border border-gray-200 rounded-xl pl-9 pr-4 py-2 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-amber-400 w-44">
                    <svg class="w-4 h-4 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <select class="bg-gray-50 border border-gray-200 rounded-xl px-3 py-2 text-sm text-gray-700 focus:outline-none">
                    <option>Semua Mapel</option>
                    <option>Matematika</option>
                    <option>Bahasa Indonesia</option>
                    <option>IPA</option>
                    <option>IPS</option>
                </select>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 text-left">
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Guru</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Mata Pelajaran</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Jam Mengajar</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Kehadiran</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Nilai Kinerja</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @php
                    $guruData = [
                    ['nama' => 'Andi Susanto', 'mapel' => 'Matematika', 'jam' => 128, 'hadir' => 98, 'nilai' => 94],
                    ['nama' => 'Budi Raharjo', 'mapel' => 'Bahasa Indonesia', 'jam' => 112, 'hadir' => 96, 'nilai' => 88],
                    ['nama' => 'Citra Dewi', 'mapel' => 'IPA', 'jam' => 120, 'hadir' => 100, 'nilai' => 96],
                    ['nama' => 'Dian Pratama', 'mapel' => 'IPS', 'jam' => 104, 'hadir' => 94, 'nilai' => 82],
                    ['nama' => 'Eko Wibowo', 'mapel' => 'Bahasa Inggris', 'jam' => 116, 'hadir' => 92, 'nilai' => 78],
                    ['nama' => 'Fitri Handayani', 'mapel' => 'Seni Budaya', 'jam' => 96, 'hadir' => 98, 'nilai' => 91],
                    ['nama' => 'Gilang Ramadhan', 'mapel' => 'Penjaskes', 'jam' => 108, 'hadir' => 88, 'nilai' => 67],
                    ];
                    @endphp

                    @foreach($guruData as $guru)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center text-xs font-bold shrink-0">
                                    {{ substr($guru['nama'], 0, 1) }}{{ substr(strstr($guru['nama'], ' '), 1, 1) }}
                                </div>
                                <span class="font-medium text-gray-800">{{ $guru['nama'] }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-gray-600">{{ $guru['mapel'] }}</td>
                        <td class="px-6 py-4 font-medium text-gray-800">{{ $guru['jam'] }} jam</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <div class="w-20 bg-gray-100 rounded-full h-1.5">
                                    <div class="h-1.5 rounded-full {{ $guru['hadir'] >= 95 ? 'bg-emerald-500' : ($guru['hadir'] >= 90 ? 'bg-amber-400' : 'bg-red-400') }}"
                                        style="width: {{ $guru['hadir'] }}%"></div>
                                </div>
                                <span class="text-gray-700 font-medium">{{ $guru['hadir'] }}%</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-semibold {{ $guru['nilai'] >= 90 ? 'text-blue-600' : ($guru['nilai'] >= 80 ? 'text-emerald-600' : ($guru['nilai'] >= 70 ? 'text-amber-600' : 'text-red-500')) }}">
                                {{ $guru['nilai'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if($guru['nilai'] >= 90)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">Sangat Baik</span>
                            @elseif($guru['nilai'] >= 80)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-100">Baik</span>
                            @elseif($guru['nilai'] >= 70)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-50 text-amber-700 border border-amber-100">Cukup</span>
                            @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-50 text-red-700 border border-red-100">Perlu Bimbingan</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between">
            <p class="text-xs text-gray-500">Menampilkan 7 dari 48 guru</p>
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
            // ---- Line Chart ----
            const lineCtx = document.getElementById('lineChart').getContext('2d');
            const gradient = lineCtx.createLinearGradient(0, 0, 0, 220);
            gradient.addColorStop(0, 'rgba(99, 102, 241, 0.25)');
            gradient.addColorStop(1, 'rgba(99, 102, 241, 0.0)');

            new Chart(lineCtx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu'],
                    datasets: [{
                        label: 'Jam Mengajar',
                        data: [108, 110, 112, 110, 113, 118, 115, 120],
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
                                label: ctx => ` ${ctx.parsed.y} jam`
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
                            max: 140,
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
                                stepSize: 20
                            }
                        }
                    }
                }
            });

            // ---- Donut Chart ----
            const donutCtx = document.getElementById('donutChart').getContext('2d');
            new Chart(donutCtx, {
                type: 'doughnut',
                data: {
                    labels: ['90-100', '80-89', '70-79', '< 70'],
                    datasets: [{
                        data: [35, 30, 20, 15],
                        backgroundColor: ['#3b82f6', '#34d399', '#fbbf24', '#f87171'],
                        borderWidth: 2,
                        borderColor: '#fff',
                        hoverOffset: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '68%',
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
                                label: ctx => ` ${ctx.label}: ${ctx.parsed}%`
                            }
                        }
                    }
                }
            });

        });

        function unduhLaporan() {
            const sel = document.getElementById('bulanSelect');
            const bulan = sel.options[sel.selectedIndex].text;
            alert(`Laporan "${bulan}" sedang diunduh...`);
        }
    </script>
    @endpush

</x-app>