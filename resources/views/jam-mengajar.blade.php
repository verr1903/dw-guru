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
        <div class="flex flex-wrap items-end gap-4">
            {{-- Mata Pelajaran --}}
            <div class="flex flex-col gap-1.5 min-w-0 flex-1" style="min-width:160px">
                <label class="text-xs font-semibold text-gray-500">Mata Pelajaran</label>
                <div class="relative">
                    <select id="filterMapel"
                        class="w-full appearance-none bg-white border border-gray-200 rounded-xl px-3 py-2.5 pr-8 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-amber-400">
                        <option value="">Semua Mata Pelajaran</option>
                        <option>Matematika</option>
                        <option>IPA</option>
                        <option>IPS</option>
                        <option>Bahasa Indonesia</option>
                        <option>Bahasa Inggris</option>
                        <option>Seni Budaya</option>
                        <option>Penjaskes</option>
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
                    <select id="filterGuru"
                        class="w-full appearance-none bg-white border border-gray-200 rounded-xl px-3 py-2.5 pr-8 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-amber-400">
                        <option value="">Semua Guru</option>
                        <option>Andi Susanto</option>
                        <option>Budi Raharjo</option>
                        <option>Citra Dewi</option>
                        <option>Dian Pratama</option>
                        <option>Eko Wibowo</option>
                        <option>Fitri Handayani</option>
                        <option>Gilang Ramadhan</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-2.5 flex items-center">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Periode --}}
            <div class="flex flex-col gap-1.5 min-w-0 flex-1" style="min-width:180px">
                <label class="text-xs font-semibold text-gray-500">Periode</label>
                <input type="month" id="filterPeriode"
                    class="w-full bg-white border border-gray-200 rounded-xl px-3 py-2.5 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-amber-400">
            </div>

            {{-- Button --}}
            <div class="flex gap-2">
                <button onclick="terapkanFilter()"
                    class="bg-gray-900 hover:bg-gray-700 text-white text-sm font-semibold px-5 py-2.5 rounded-xl shadow transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z" />
                    </svg>
                    Terapkan Filter
                </button>
                <button onclick="resetFilter()"
                    class="bg-white hover:bg-gray-50 text-gray-600 text-sm font-medium px-4 py-2.5 rounded-xl border border-gray-200 transition-all">
                    Reset
                </button>
            </div>
        </div>
    </div>

    {{-- ===== CHARTS ROW ===== --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mb-6">

        {{-- Total Jam Mengajar (Line) --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <div class="flex items-center justify-between mb-1">
                <h2 class="text-sm font-semibold text-gray-800">Total Jam Mengajar</h2>
                <span class="text-xs text-gray-400 bg-gray-50 border border-gray-100 rounded-full px-2.5 py-0.5">2024</span>
            </div>
            <p class="text-xs text-gray-400 mb-4">Tren realisasi jam per bulan</p>
            <div class="relative h-44">
                <canvas id="lineChart"></canvas>
            </div>
        </div>

        {{-- Distribusi per Guru (Donut) --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <h2 class="text-sm font-semibold text-gray-800 mb-1">Distribusi per Guru</h2>
            <p class="text-xs text-gray-400 mb-3">Proporsi jam mengajar tiap guru</p>
            <div class="relative h-44 flex items-center justify-center">
                <canvas id="donutChart"></canvas>
            </div>
        </div>

        {{-- Beban per Mata Pelajaran (Bar) --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <h2 class="text-sm font-semibold text-gray-800 mb-1">Beban per Mata Pelajaran</h2>
            <p class="text-xs text-gray-400 mb-3">Rata-rata jam per mapel (Jan–Jun)</p>
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
            <div class="flex items-center gap-2">
                <div class="relative">
                    <input type="text" id="searchTable" placeholder="Cari nama guru..."
                        class="bg-gray-50 border border-gray-200 rounded-xl pl-9 pr-4 py-2 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-amber-400 w-44">
                    <svg class="w-4 h-4 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <button onclick="exportData()"
                    class="flex items-center gap-1.5 bg-white hover:bg-gray-50 text-gray-600 text-sm font-medium px-4 py-2 rounded-xl border border-gray-200 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Export
                </button>
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm" id="dataTable">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Guru</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Mata Pelajaran</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Jumlah Jam</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Target Jam</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Periode</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50" id="tableBody">
                    @php
                    $dataJam = [
                    ['nama'=>'Andi Susanto', 'inisial'=>'AS', 'mapel'=>'Matematika', 'jam'=>24, 'target'=>24, 'periode'=>'Jan 2024'],
                    ['nama'=>'Budi Raharjo', 'inisial'=>'BR', 'mapel'=>'Bahasa Indonesia', 'jam'=>22, 'target'=>24, 'periode'=>'Jan 2024'],
                    ['nama'=>'Citra Dewi', 'inisial'=>'CD', 'mapel'=>'IPA', 'jam'=>26, 'target'=>24, 'periode'=>'Jan 2024'],
                    ['nama'=>'Dian Pratama', 'inisial'=>'DP', 'mapel'=>'IPS', 'jam'=>20, 'target'=>24, 'periode'=>'Feb 2024'],
                    ['nama'=>'Eko Wibowo', 'inisial'=>'EW', 'mapel'=>'Bahasa Inggris', 'jam'=>18, 'target'=>24, 'periode'=>'Feb 2024'],
                    ['nama'=>'Fitri Handayani', 'inisial'=>'FH', 'mapel'=>'Seni Budaya', 'jam'=>24, 'target'=>20, 'periode'=>'Feb 2024'],
                    ['nama'=>'Gilang Ramadhan', 'inisial'=>'GR', 'mapel'=>'Penjaskes', 'jam'=>16, 'target'=>24, 'periode'=>'Mar 2024'],
                    ['nama'=>'Andi Susanto', 'inisial'=>'AS', 'mapel'=>'Matematika', 'jam'=>25, 'target'=>24, 'periode'=>'Mar 2024'],
                    ['nama'=>'Budi Raharjo', 'inisial'=>'BR', 'mapel'=>'Bahasa Indonesia', 'jam'=>24, 'target'=>24, 'periode'=>'Apr 2024'],
                    ['nama'=>'Citra Dewi', 'inisial'=>'CD', 'mapel'=>'IPA', 'jam'=>23, 'target'=>24, 'periode'=>'Apr 2024'],
                    ];
                    @endphp

                    @foreach($dataJam as $row)
                    @php $memenuhi = $row['jam'] >= $row['target']; @endphp
                    <tr class="hover:bg-gray-50 transition-colors table-row">
                        <td class="px-6 py-3.5">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center text-xs font-bold shrink-0">
                                    {{ $row['inisial'] }}
                                </div>
                                <span class="font-medium text-gray-800 guru-nama">{{ $row['nama'] }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-3.5 text-gray-600">{{ $row['mapel'] }}</td>
                        <td class="px-6 py-3.5">
                            <span class="font-semibold {{ $memenuhi ? 'text-gray-800' : 'text-red-500' }}">{{ $row['jam'] }}</span>
                            <span class="text-gray-400 text-xs"> jam</span>
                        </td>
                        <td class="px-6 py-3.5 text-gray-500 text-sm">{{ $row['target'] }} jam</td>
                        <td class="px-6 py-3.5 text-gray-600">{{ $row['periode'] }}</td>
                        <td class="px-6 py-3.5">
                            @if($memenuhi)
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                                Memenuhi Target
                            </span>
                            @else
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-100">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                                Kurang Target
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-3.5">
                            <div class="flex items-center gap-1">
                                <button class="w-7 h-7 rounded-lg hover:bg-blue-50 text-gray-400 hover:text-blue-600 flex items-center justify-center transition-colors" title="Detail">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                                <button class="w-7 h-7 rounded-lg hover:bg-amber-50 text-gray-400 hover:text-amber-600 flex items-center justify-center transition-colors" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                                <button class="w-7 h-7 rounded-lg hover:bg-red-50 text-gray-400 hover:text-red-500 flex items-center justify-center transition-colors" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination + summary --}}
        <div class="px-6 py-4 border-t border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div class="flex items-center gap-3">
                <p class="text-xs text-gray-500">Menampilkan <span class="font-semibold text-gray-700">10</span> dari <span class="font-semibold text-gray-700">48</span> entri</p>
                <select class="bg-gray-50 border border-gray-200 rounded-lg px-2 py-1 text-xs text-gray-600 focus:outline-none">
                    <option>10</option>
                    <option>25</option>
                    <option>50</option>
                </select>
                <span class="text-xs text-gray-400">per halaman</span>
            </div>
            <div class="flex items-center gap-1">
                <button class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:bg-gray-100">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button class="w-8 h-8 flex items-center justify-center rounded-lg bg-gray-900 text-white text-xs font-medium">1</button>
                <button class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-600 hover:bg-gray-100 text-xs">2</button>
                <button class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-600 hover:bg-gray-100 text-xs">3</button>
                <span class="text-gray-400 text-xs px-1">...</span>
                <button class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-600 hover:bg-gray-100 text-xs">5</button>
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
            const gradient = lineCtx.createLinearGradient(0, 0, 0, 180);
            gradient.addColorStop(0, 'rgba(99,102,241,0.2)');
            gradient.addColorStop(1, 'rgba(99,102,241,0)');

            new Chart(lineCtx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
                    datasets: [{
                        data: [148, 152, 160, 155, 168, 172],
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
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: '#1e293b',
                            bodyColor: '#fff',
                            padding: 8,
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
                                },
                                stepSize: 30
                            },
                            min: 0,
                            max: 210
                        }
                    }
                }
            });

            // ---- Donut Chart ----
            const donutCtx = document.getElementById('donutChart').getContext('2d');
            new Chart(donutCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Budi Raharjo', 'Citra Dewi', 'Andi Susanto', 'Dian Pratama', 'Lainnya'],
                    datasets: [{
                        data: [22, 26, 24, 20, 36],
                        backgroundColor: ['#6366f1', '#34d399', '#fbbf24', '#60a5fa', '#e5e7eb'],
                        borderWidth: 2,
                        borderColor: '#fff',
                        hoverOffset: 5,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '62%',
                    plugins: {
                        legend: {
                            position: 'right',
                            labels: {
                                boxWidth: 10,
                                boxHeight: 10,
                                borderRadius: 3,
                                font: {
                                    size: 10
                                },
                                color: '#6b7280',
                                padding: 8,
                            }
                        },
                        tooltip: {
                            backgroundColor: '#1e293b',
                            bodyColor: '#fff',
                            padding: 8,
                            callbacks: {
                                label: ctx => ` ${ctx.label}: ${ctx.parsed} jam`
                            }
                        }
                    }
                }
            });

            // ---- Bar Chart ----
            const barCtx = document.getElementById('barChart').getContext('2d');
            new Chart(barCtx, {
                type: 'bar',
                data: {
                    labels: ['MTK', 'IPA', 'IPS', 'B.Indo', 'B.Ing', 'Senbu'],
                    datasets: [{
                        data: [24, 26, 20, 22, 18, 24],
                        backgroundColor: '#6366f1',
                        borderRadius: 5,
                        borderSkipped: false,
                        hoverBackgroundColor: '#4f46e5',
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
                            bodyColor: '#fff',
                            padding: 8,
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
                            max: 30
                        }
                    }
                }
            });

        });

        function terapkanFilter() {
            const mapel = document.getElementById('filterMapel').value;
            const guru = document.getElementById('filterGuru').value;
            const periode = document.getElementById('filterPeriode').value;
            // Implementasi: kirim ke controller Laravel
            // window.location.href = `/jam-mengajar?mapel=${mapel}&guru=${guru}&periode=${periode}`;
            alert(`Filter diterapkan:\nMapel: ${mapel || 'Semua'}\nGuru: ${guru || 'Semua'}\nPeriode: ${periode || 'Semua'}`);
        }

        function resetFilter() {
            document.getElementById('filterMapel').value = '';
            document.getElementById('filterGuru').value = '';
            document.getElementById('filterPeriode').value = '';
        }

        function exportData() {
            alert('Export data jam mengajar ke Excel/PDF...');
            // Implementasi: window.location.href = '/jam-mengajar/export';
        }
    </script>
    @endpush

</x-app>