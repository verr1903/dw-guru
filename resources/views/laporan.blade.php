{{-- resources/views/laporan.blade.php --}}
<x-app title="Unduh Laporan | SMA Cendana Pekanbaru">

    {{-- ── Page Header ────────────────────────────────────────────────── --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Unduh Laporan</h1>
            <p class="text-sm text-gray-500 mt-1">Ekspor data kinerja guru ke PDF atau Excel</p>
        </div>
        <form method="GET" action="{{ route('laporan') }}">
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

    {{-- ── Flash Success ───────────────────────────────────────────────── --}}
    @if(session('success'))
    <div class="mb-6 flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl px-5 py-3.5 text-sm font-medium">
        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        {{ session('success') }}
    </div>
    @endif

    {{-- ── Stat Cards ─────────────────────────────────────────────────── --}}
    <div class="grid grid-cols-2 xl:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <p class="text-xs font-medium text-gray-400 uppercase tracking-wide">Total Jam Mengajar</p>
            <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($totalJamMengajar) }}</p>
            <p class="text-xs text-gray-400 mt-1">jam · tahun {{ $tahun }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <p class="text-xs font-medium text-gray-400 uppercase tracking-wide">Tingkat Kehadiran</p>
            <p class="text-3xl font-bold text-emerald-500 mt-2">{{ $kehadiranRataRata }}<span class="text-lg font-semibold text-emerald-300">%</span></p>
            <div class="mt-2 w-full bg-gray-100 rounded-full h-1.5">
                <div class="bg-emerald-500 h-1.5 rounded-full transition-all" style="width: {{ min($kehadiranRataRata, 100) }}%"></div>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <p class="text-xs font-medium text-gray-400 uppercase tracking-wide">Guru Aktif</p>
            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalGuru }}</p>
            <p class="text-xs text-gray-400 mt-1">pengajar aktif</p>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <p class="text-xs font-medium text-gray-400 uppercase tracking-wide">Total Prestasi</p>
            <p class="text-3xl font-bold text-amber-500 mt-2">{{ $totalPrestasi }}</p>
            <p class="text-xs text-gray-400 mt-1">pencapaian tercatat</p>
        </div>
    </div>

    {{-- ── Download Cards ──────────────────────────────────────────────── --}}
    <h2 class="text-sm font-semibold text-gray-500 uppercase tracking-widest mb-4">Pilih Laporan</h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-10">

        {{-- ── Laporan 1: Rekap Kinerja (Dashboard) ── --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden flex flex-col">
            {{-- Header strip --}}
            <div class="h-1.5 bg-gradient-to-r from-gray-700 to-gray-500"></div>
            <div class="p-6 flex flex-col flex-1 gap-4">
                <div class="flex items-start gap-4">
                    <div class="w-11 h-11 rounded-xl bg-gray-100 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-900 text-sm">Rekap Kinerja Guru</p>
                        <p class="text-xs text-gray-400 mt-0.5 leading-relaxed">Total jam, kehadiran, dan ringkasan kinerja seluruh guru tahun {{ $tahun }}</p>
                    </div>
                </div>

                {{-- Preview mini --}}
                <div class="bg-gray-50 rounded-xl p-3 flex-1">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-2.5">Preview — Top 5 Jam</p>
                    <div class="space-y-1.5">
                        @foreach($previewJam as $guru)
                        <div class="flex items-center justify-between gap-2">
                            <span class="text-xs text-gray-700 truncate">{{ $guru->nama_guru }}</span>
                            <span class="text-xs font-semibold text-gray-900 shrink-0">{{ number_format($guru->total_jam) }} jam</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Download buttons --}}
                <div class="flex gap-2">
                    <a href="{{ route('laporan.export.dashboard.pdf', ['tahun' => $tahun]) }}"
                        class="flex-1 flex items-center justify-center gap-1.5 bg-gray-900 hover:bg-gray-700 text-white text-xs font-semibold py-2.5 rounded-xl transition-all">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        PDF
                    </a>
                    <a href="{{ route('laporan.export.dashboard.excel', ['tahun' => $tahun]) }}"
                        class="flex-1 flex items-center justify-center gap-1.5 bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-semibold py-2.5 rounded-xl transition-all">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        Excel
                    </a>
                </div>
            </div>
        </div>

        {{-- ── Laporan 2: Jam Mengajar ── --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden flex flex-col">
            <div class="h-1.5 bg-gradient-to-r from-emerald-500 to-teal-400"></div>
            <div class="p-6 flex flex-col flex-1 gap-4">
                <div class="flex items-start gap-4">
                    <div class="w-11 h-11 rounded-xl bg-emerald-50 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-900 text-sm">Jam Mengajar</p>
                        <p class="text-xs text-gray-400 mt-0.5 leading-relaxed">Detail beban jam mengajar per guru dan per mata pelajaran tahun {{ $tahun }}</p>
                    </div>
                </div>

                {{-- Preview: bar chart sederhana --}}
                <div class="bg-gray-50 rounded-xl p-3 flex-1">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-3">Preview — Distribusi Jam</p>
                    @php $maxJam = $previewJam->max('total_jam') ?: 1; @endphp
                    <div class="space-y-2">
                        @foreach($previewJam as $guru)
                        <div>
                            <div class="flex justify-between mb-0.5">
                                <span class="text-xs text-gray-600 truncate pr-2">{{ Str::limit($guru->nama_guru, 20) }}</span>
                                <span class="text-xs font-semibold text-emerald-600 shrink-0">{{ number_format($guru->total_jam) }}</span>
                            </div>
                            <div class="h-1.5 bg-gray-200 rounded-full overflow-hidden">
                                <div class="h-full bg-emerald-500 rounded-full" style="width: {{ round(($guru->total_jam / $maxJam) * 100) }}%"></div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="flex gap-2">
                    <a href="{{ route('laporan.export.jam.pdf', ['tahun' => $tahun]) }}"
                        class="flex-1 flex items-center justify-center gap-1.5 bg-gray-900 hover:bg-gray-700 text-white text-xs font-semibold py-2.5 rounded-xl transition-all">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        PDF
                    </a>
                    <a href="{{ route('laporan.export.jam.excel', ['tahun' => $tahun]) }}"
                        class="flex-1 flex items-center justify-center gap-1.5 bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-semibold py-2.5 rounded-xl transition-all">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        Excel
                    </a>
                </div>
            </div>
        </div>

        {{-- ── Laporan 3: Kehadiran Guru ── --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden flex flex-col">
            <div class="h-1.5 bg-gradient-to-r from-blue-500 to-indigo-400"></div>
            <div class="p-6 flex flex-col flex-1 gap-4">
                <div class="flex items-start gap-4">
                    <div class="w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-900 text-sm">Kehadiran Guru</p>
                        <p class="text-xs text-gray-400 mt-0.5 leading-relaxed">Data hadir, izin & alpa seluruh guru per bulan tahun {{ $tahun }}</p>
                    </div>
                </div>

                {{-- Preview: persentase kehadiran --}}
                <div class="bg-gray-50 rounded-xl p-3 flex-1">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-2.5">Preview — % Kehadiran</p>
                    <div class="space-y-2">
                        @foreach($previewKehadiran as $guru)
                        <div>
                            <div class="flex justify-between mb-0.5">
                                <span class="text-xs text-gray-600 truncate pr-2">{{ Str::limit($guru->nama_guru, 20) }}</span>
                                <span class="text-xs font-semibold {{ $guru->persen_kehadiran >= 90 ? 'text-emerald-600' : ($guru->persen_kehadiran >= 75 ? 'text-amber-500' : 'text-red-500') }} shrink-0">
                                    {{ $guru->persen_kehadiran }}%
                                </span>
                            </div>
                            <div class="h-1.5 bg-gray-200 rounded-full overflow-hidden">
                                <div class="h-full rounded-full {{ $guru->persen_kehadiran >= 90 ? 'bg-emerald-500' : ($guru->persen_kehadiran >= 75 ? 'bg-amber-400' : 'bg-red-400') }}"
                                    style="width: {{ min($guru->persen_kehadiran, 100) }}%"></div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="flex gap-2">
                    <a href="{{ route('laporan.export.kehadiran.pdf', ['tahun' => $tahun]) }}"
                        class="flex-1 flex items-center justify-center gap-1.5 bg-gray-900 hover:bg-gray-700 text-white text-xs font-semibold py-2.5 rounded-xl transition-all">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        PDF
                    </a>
                    <a href="{{ route('laporan.export.kehadiran.excel', ['tahun' => $tahun]) }}"
                        class="flex-1 flex items-center justify-center gap-1.5 bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-semibold py-2.5 rounded-xl transition-all">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        Excel
                    </a>
                </div>
            </div>
        </div>

    </div>

    {{-- ── Tren Bulanan (mini chart + tabel) ─────────────────────────── --}}
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">

        {{-- Chart --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 lg:col-span-3">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h2 class="text-base font-semibold text-gray-900">Tren Bulanan {{ $tahun }}</h2>
                    <p class="text-xs text-gray-400 mt-0.5">Jam mengajar & kehadiran per bulan</p>
                </div>
                <div class="flex items-center gap-4 text-xs text-gray-500">
                    <span class="flex items-center gap-1.5">
                        <span class="w-3 h-0.5 bg-gray-800 inline-block rounded"></span> Jam
                    </span>
                    <span class="flex items-center gap-1.5">
                        <span class="w-3 h-0.5 bg-emerald-500 inline-block rounded"></span> Hadir
                    </span>
                </div>
            </div>
            <div class="relative h-52">
                <canvas id="trenChart"></canvas>
            </div>
        </div>

        {{-- Tabel ringkasan bulanan --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden lg:col-span-2">
            <div class="px-5 py-4 border-b border-gray-100">
                <h2 class="text-base font-semibold text-gray-900">Ringkasan per Bulan</h2>
                <p class="text-xs text-gray-400 mt-0.5">Tahun {{ $tahun }}</p>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-xs">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-4 py-2.5 text-left font-semibold text-gray-400 uppercase tracking-wider">Bln</th>
                            <th class="px-4 py-2.5 text-right font-semibold text-gray-400 uppercase tracking-wider">Jam</th>
                            <th class="px-4 py-2.5 text-right font-semibold text-gray-400 uppercase tracking-wider">Hadir</th>
                            <th class="px-4 py-2.5 text-right font-semibold text-gray-400 uppercase tracking-wider">Izin</th>
                            <th class="px-4 py-2.5 text-right font-semibold text-gray-400 uppercase tracking-wider">Alpa</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($trenBulan as $row)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-4 py-2.5 font-medium text-gray-700">{{ $namaBulan[$row->bulan] ?? $row->bulan }}</td>
                            <td class="px-4 py-2.5 text-right text-gray-700">{{ number_format($row->total_jam) }}</td>
                            <td class="px-4 py-2.5 text-right text-emerald-600 font-medium">{{ number_format($row->total_hadir) }}</td>
                            <td class="px-4 py-2.5 text-right text-amber-500">{{ number_format($row->total_izin) }}</td>
                            <td class="px-4 py-2.5 text-right text-red-400">{{ number_format($row->total_alpha) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-4 py-6 text-center text-gray-400">Tidak ada data.</td>
                        </tr>
                        @endforelse
                    </tbody>
                    @if($trenBulan->isNotEmpty())
                    <tfoot>
                        <tr class="bg-gray-50 font-semibold">
                            <td class="px-4 py-2.5 text-gray-700">Total</td>
                            <td class="px-4 py-2.5 text-right text-gray-900">{{ number_format($trenBulan->sum('total_jam')) }}</td>
                            <td class="px-4 py-2.5 text-right text-emerald-600">{{ number_format($trenBulan->sum('total_hadir')) }}</td>
                            <td class="px-4 py-2.5 text-right text-amber-500">{{ number_format($trenBulan->sum('total_izin')) }}</td>
                            <td class="px-4 py-2.5 text-right text-red-400">{{ number_format($trenBulan->sum('total_alpha')) }}</td>
                        </tr>
                    </tfoot>
                    @endif
                </table>
            </div>
        </div>

    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tren = @json($trenBulan);
            const bNames = @json($namaBulan);
            const labels = tren.map(t => bNames[t.bulan] ?? t.bulan);

            const ctx = document.getElementById('trenChart').getContext('2d');

            const gradJam = ctx.createLinearGradient(0, 0, 0, 200);
            gradJam.addColorStop(0, 'rgba(17,24,39,0.15)');
            gradJam.addColorStop(1, 'rgba(17,24,39,0)');

            const gradHadir = ctx.createLinearGradient(0, 0, 0, 200);
            gradHadir.addColorStop(0, 'rgba(16,185,129,0.15)');
            gradHadir.addColorStop(1, 'rgba(16,185,129,0)');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels,
                    datasets: [{
                            label: 'Jam Mengajar',
                            data: tren.map(t => parseInt(t.total_jam)),
                            borderColor: '#111827',
                            borderWidth: 2.5,
                            backgroundColor: gradJam,
                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: '#111827',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            yAxisID: 'y',
                        },
                        {
                            label: 'Kehadiran',
                            data: tren.map(t => parseInt(t.total_hadir)),
                            borderColor: '#10b981',
                            borderWidth: 2,
                            backgroundColor: gradHadir,
                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: '#10b981',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            yAxisID: 'y1',
                        },
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
                            bodyColor: '#fff',
                            titleColor: '#94a3b8',
                            padding: 10,
                            callbacks: {
                                label: ctx => ` ${ctx.dataset.label}: ${ctx.parsed.y.toLocaleString()}`
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
                            position: 'left',
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
                                }
                            }
                        },
                        y1: {
                            position: 'right',
                            grid: {
                                drawOnChartArea: false
                            },
                            border: {
                                display: false
                            },
                            ticks: {
                                color: '#10b981',
                                font: {
                                    size: 11
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