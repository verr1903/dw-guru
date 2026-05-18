{{-- resources/views/dashboard.blade.php --}}
<x-app title="Dashboard | SMA Cendana Pekanbaru">

    {{-- ── Page Header ─────────────────────────────────────────────────── --}}
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
                        <option value="all" {{ $tahun === 'all' ? 'selected' : '' }}>Semua Tahun</option>
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

    {{-- ── Stat Cards — Kinerja ─────────────────────────────────────────── --}}
    <div class="grid grid-cols-2 xl:grid-cols-4 gap-5 mb-6">

        {{-- Total Jam Mengajar --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Total Jam Mengajar</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($totalJamMengajar) }}</p>
                    <p class="text-xs text-gray-400 mt-1">jam · {{ $isAll ? 'semua tahun' : 'tahun '.$tahun }}</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-gray-900 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-1.5">
                @if(!$isAll && $persenPerubahanJam !== null)
                @if($persenPerubahanJam >= 0)
                <span class="inline-flex items-center gap-0.5 text-xs font-semibold text-emerald-600">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                    </svg>
                    {{ $persenPerubahanJam }}%
                </span>
                @else
                <span class="inline-flex items-center gap-0.5 text-xs font-semibold text-red-500">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                    {{ abs($persenPerubahanJam) }}%
                </span>
                @endif
                <span class="text-xs text-gray-400">vs {{ $tahun - 1 }}</span>
                @else
                <span class="text-xs text-gray-400">Akumulasi seluruh tahun</span>
                @endif
            </div>
        </div>

        {{-- Kehadiran Rata-rata --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Kehadiran Rata-rata</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $kehadiranRataRata }}<span class="text-lg font-semibold text-gray-400">%</span></p>
                    <p class="text-xs text-gray-400 mt-1">{{ $isAll ? 'semua tahun' : 'tahun '.$tahun }}</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-emerald-500 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-1.5">
                @if(!$isAll && $persenPerubahanKehadiran !== null)
                @if($persenPerubahanKehadiran >= 0)
                <span class="inline-flex items-center gap-0.5 text-xs font-semibold text-emerald-600">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                    </svg>
                    +{{ $persenPerubahanKehadiran }}pp
                </span>
                @else
                <span class="inline-flex items-center gap-0.5 text-xs font-semibold text-red-500">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                    {{ $persenPerubahanKehadiran }}pp
                </span>
                @endif
                <span class="text-xs text-gray-400">vs {{ $tahun - 1 }} ({{ $kehadiranRataRataTahunLalu }}%)</span>
                @else
                <span class="text-xs text-gray-400">Akumulasi seluruh tahun</span>
                @endif
            </div>
        </div>

        {{-- Guru Aktif --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Guru Aktif</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($guruAktif) }}</p>
                    <p class="text-xs text-gray-400 mt-1">guru · {{ $isAll ? 'semua tahun' : 'tahun '.$tahun }}</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-blue-500 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-1.5">
                @if(!$isAll && $selisihGuruAktif !== null)
                @if($selisihGuruAktif >= 0)
                <span class="text-xs font-semibold text-emerald-600">+{{ $selisihGuruAktif }}</span>
                @else
                <span class="text-xs font-semibold text-red-500">{{ $selisihGuruAktif }}</span>
                @endif
                <span class="text-xs text-gray-400">vs {{ $tahun - 1 }} ({{ $guruAktifTahunLalu }} guru)</span>
                @else
                <span class="text-xs text-gray-400">Akumulasi seluruh tahun</span>
                @endif
            </div>
        </div>

        {{-- Total Prestasi --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Total Prestasi</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($totalPrestasi) }}</p>
                    <p class="text-xs text-gray-400 mt-1">prestasi · {{ $isAll ? 'semua tahun' : 'tahun '.$tahun }}</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-amber-500 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-1.5">
                @if(!$isAll && $selisihPrestasi !== null)
                @if($selisihPrestasi >= 0)
                <span class="text-xs font-semibold text-emerald-600">+{{ $selisihPrestasi }}</span>
                @else
                <span class="text-xs font-semibold text-red-500">{{ $selisihPrestasi }}</span>
                @endif
                <span class="text-xs text-gray-400">vs {{ $tahun - 1 }} ({{ $totalPrestasiTahunLalu }} prestasi)</span>
                @else
                <span class="text-xs text-gray-400">Akumulasi seluruh tahun</span>
                @endif
            </div>
        </div>
    </div>



    {{-- ── Charts Row ───────────────────────────────────────────────────── --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-5 mb-8">

        {{-- ── Top 10 Guru ───────────────────────────────────────────────────── --}}
        <div class="xl:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm p-6 flex flex-col">
            <h2 class="text-base font-semibold text-gray-900 mb-5">Top 10 Guru — Jam Mengajar {{ $tahun }}</h2>
            <div class="space-y-3">
                @php $maxJam = $topGuruJam->max('total_jam') ?: 1; @endphp
                @foreach($topGuruJam as $i => $guru)
                <div class="flex items-center gap-4">
                    <span class="w-6 text-xs font-bold text-gray-400 shrink-0">{{ $i + 1 }}</span>
                    <div class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center text-xs font-bold shrink-0">
                        {{ strtoupper(substr($guru->nama_guru, 0, 2)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-sm font-medium text-gray-800 truncate">{{ $guru->nama_guru }}</span>
                            <span class="text-sm font-bold text-gray-900 shrink-0 ml-2">{{ number_format($guru->total_jam) }} <span class="text-xs font-normal text-gray-400">jam</span></span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-1.5">
                            <div class="h-1.5 rounded-full bg-indigo-500 transition-all duration-500"
                                style="width: {{ round(($guru->total_jam / $maxJam) * 100) }}%"></div>
                        </div>
                        <p class="text-xs text-gray-400 mt-0.5">{{ $guru->bidang_studi ?? '-' }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Semester Chart (ganti donut lama) --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <div class="mb-5">
                <h2 class="text-base font-semibold text-gray-900">Distribusi Semester</h2>
                <p class="text-xs text-gray-400 mt-0.5">Jam mengajar · {{ $tahun }}</p>
            </div>

            {{-- Kartu ringkasan --}}
            <div class="grid grid-cols-2 gap-3 mb-4">
                @php
                $s1 = $trenSemester->firstWhere('semester', 1)->total_jam ?? 0;
                $s2 = $trenSemester->firstWhere('semester', 2)->total_jam ?? 0;
                $tot = $s1 + $s2;
                $s1pct = $tot > 0 ? round($s1 / $tot * 100) : 0;
                $s2pct = 100 - $s1pct;
                @endphp
                <div class="bg-gray-50 rounded-xl px-3 py-2.5 border-l-4 border-indigo-500">
                    <p class="text-xs text-gray-400">Semester 1 <span class="text-gray-300">(Jan–Jun)</span></p>
                    <p class="text-lg font-bold text-gray-900 mt-0.5">{{ number_format($s1) }} <span class="text-xs font-normal text-gray-400">jam</span></p>
                    <p class="text-xs text-indigo-500 mt-0.5">{{ $s1pct }}% dari total</p>
                </div>
                <div class="bg-gray-50 rounded-xl px-3 py-2.5 border-l-4 border-amber-400">
                    <p class="text-xs text-gray-400">Semester 2 <span class="text-gray-300">(Jul–Des)</span></p>
                    <p class="text-lg font-bold text-gray-900 mt-0.5">{{ number_format($s2) }} <span class="text-xs font-normal text-gray-400">jam</span></p>
                    <p class="text-xs text-amber-500 mt-0.5">{{ $s2pct }}% dari total</p>
                </div>
            </div>

            {{-- Ratio bar --}}
            <div class="flex h-2.5 rounded-full overflow-hidden mb-3">
                <div class="bg-indigo-500 transition-all duration-700" style="width: {{ $s1pct }}%"></div>
                <div class="bg-amber-400 flex-1"></div>
            </div>
            <div class="flex gap-4 text-xs text-gray-400 mb-5">
                <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-sm bg-indigo-500 inline-block"></span>Semester 1</span>
                <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-sm bg-amber-400 inline-block"></span>Semester 2</span>
            </div>

            {{-- Bar per bulan --}}
            <p class="text-xs font-medium text-gray-700 mb-3">Jam mengajar per bulan</p>
            <div id="semesterMonthBars" class="space-y-1.5"></div>
        </div>
    </div>

    {{-- Tren Jam per Bulan --}}
    <div class="xl:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-base font-semibold text-gray-900">Tren Jam Mengajar per Bulan</h2>
                <p class="text-xs text-gray-400 mt-0.5">Total jam seluruh guru · {{ $tahun }}</p>
            </div>
            <div class="flex gap-2">
                <button onclick="switchChart('bulan')" id="btnBulan"
                    class="px-3 py-1 text-xs font-medium rounded-lg bg-gray-900 text-white transition-colors">
                    Bulanan
                </button>
                <button onclick="switchChart('tahun')" id="btnTahun"
                    class="px-3 py-1 text-xs font-medium rounded-lg bg-gray-100 text-gray-600 hover:bg-gray-200 transition-colors">
                    Tahunan
                </button>
            </div>
        </div>
        <div class="relative h-56">
            <canvas id="chartTrenJam"></canvas>
        </div>
    </div>


    {{-- ── Tabel Rekap Kinerja Guru — 1 baris per guru ─────────────────── --}}
    <div id="rekap-tabel" class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-3 px-6 py-4 border-b border-gray-100">
            <div>
                <h2 class="text-base font-semibold text-gray-900">Rekap Kinerja Guru</h2>
                <p class="text-xs text-gray-400 mt-0.5">Klik baris guru untuk melihat detail per bulan</p>
            </div>
            <form method="GET" action="{{ route('dashboard') }}" id="filterForm"
                class="flex flex-wrap items-center gap-2">
                <input type="hidden" name="tahun" value="{{ $tahun }}">

                {{-- Bidang Studi --}}
                <div class="relative">
                    <select name="mapel" onchange="document.getElementById('filterForm').submit()"
                        class="appearance-none bg-gray-50 border border-gray-200 rounded-xl px-3 py-2 pr-8 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-400 cursor-pointer">
                        <option value="">Semua Mapel</option>
                        @foreach($daftarMapel as $m)
                        <option value="{{ $m }}" {{ $mapel == $m ? 'selected' : '' }}>{{ $m }}</option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-2 flex items-center">
                        <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>

                {{-- Search --}}
                <div class="relative">
                    <input type="text" name="search" value="{{ $search }}"
                        placeholder="Cari guru..."
                        class="bg-gray-50 border border-gray-200 rounded-xl pl-9 pr-4 py-2 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-400 w-40">
                    <svg class="w-4 h-4 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>

                <button type="submit"
                    class="px-4 py-2 bg-gray-900 hover:bg-gray-700 text-white text-sm font-medium rounded-xl transition-colors">
                    Cari
                </button>

                @if($search || $mapel)
                <a href="{{ route('dashboard', ['tahun' => $tahun]) }}"
                    class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-600 text-sm font-medium rounded-xl transition-colors">
                    Reset
                </a>
                @endif
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 text-left">
                        <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">#</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Guru</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Bidang Studi</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right">Total Jam</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Detail</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">% Kehadiran</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($guruData as $i => $row)
                    @php
                    $totalAbsen = ($row->total_sakit ?? 0) + ($row->total_izin ?? 0);
                    $totalAbsensiAll = ($row->total_hadir ?? 0) + $totalAbsen + ($row->total_alfa ?? 0);
                    $pctHadir = $totalAbsensiAll > 0 ? round(($row->total_hadir / $totalAbsensiAll) * 100) : 0;
                    @endphp
                    <tr class="hover:bg-indigo-50/40 transition-colors cursor-pointer group"
                        onclick="openModal({{ json_encode([
                            'id_guru'      => $row->id_guru,
                            'nama'         => $row->nama_guru,
                            'nip'          => $row->nip ?? '-',
                            'bidang_studi' => $row->bidang_studi ?? '-',
                            'total_jam'    => $row->total_jam_mengajar,
                            'total_hadir'  => $row->total_hadir,
                            'total_sakit'  => $row->total_sakit,
                            'total_izin'   => $row->total_izin,
                            'total_alfa'   => $row->total_alfa,
                            'pct_hadir'    => $pctHadir,
                            'tahun'        => $tahun,
                        ]) }})">

                        <td class="px-5 py-4 text-xs text-gray-400">{{ $guruData->firstItem() + $i }}</td>

                        <td class="px-5 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center text-xs font-bold shrink-0">
                                    {{ strtoupper(substr($row->nama_guru, 0, 2)) }}
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800 whitespace-nowrap group-hover:text-indigo-700 transition-colors">{{ $row->nama_guru }}</p>
                                    <p class="text-xs text-gray-400">{{ $row->nip ?? '-' }}</p>
                                </div>
                            </div>
                        </td>

                        <td class="px-5 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100 whitespace-nowrap">
                                {{ $row->bidang_studi ?? '-' }}
                            </span>
                        </td>

                        <td class="px-5 py-4 text-right font-semibold text-gray-800">
                            {{ number_format($row->total_jam_mengajar ?? 0) }}
                            <span class="text-xs font-normal text-gray-400">jam</span>
                        </td>

                        <td class="px-5 py-4 text-center">
                            <button onclick="event.stopPropagation(); openModal({{ json_encode([
                                'id_guru'      => $row->id_guru,
                                'nama'         => $row->nama_guru,
                                'nip'          => $row->nip ?? '-',
                                'bidang_studi' => $row->bidang_studi ?? '-',
                                'total_jam'    => $row->total_jam_mengajar,
                                'total_hadir'  => $row->total_hadir,
                                'total_sakit'  => $row->total_sakit,
                                'total_izin'   => $row->total_izin,
                                'total_alfa'   => $row->total_alfa,
                                'pct_hadir'    => $pctHadir,
                                'tahun'        => $tahun,
                            ]) }})"
                                class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-indigo-600 hover:text-indigo-800 hover:bg-indigo-100 rounded-lg transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                Detail
                            </button>
                        </td>

                        <td class="px-5 py-4">
                            <div class="flex items-center gap-2 min-w-[100px]">
                                <div class="w-20 bg-gray-100 rounded-full h-1.5">
                                    <div class="h-1.5 rounded-full
                                        {{ $pctHadir >= 90 ? 'bg-emerald-500' : ($pctHadir >= 75 ? 'bg-amber-400' : 'bg-red-400') }}"
                                        style="width: {{ $pctHadir }}%"></div>
                                </div>
                                <span class="text-xs font-bold whitespace-nowrap
                                    {{ $pctHadir >= 90 ? 'text-emerald-600' : ($pctHadir >= 75 ? 'text-amber-600' : 'text-red-500') }}">
                                    {{ $pctHadir }}%
                                </span>
                            </div>
                        </td>

                        <td class="px-5 py-4">
                            @if($pctHadir >= 90)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-100 whitespace-nowrap">Sangat Baik</span>
                            @elseif($pctHadir >= 75)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100 whitespace-nowrap">Baik</span>
                            @elseif($pctHadir >= 60)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-50 text-amber-700 border border-amber-100 whitespace-nowrap">Cukup</span>
                            @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-50 text-red-700 border border-red-100 whitespace-nowrap">Perlu Perhatian</span>
                            @endif
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="px-6 py-12 text-center text-gray-400">
                            Tidak ada data untuk filter yang dipilih.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between">
            <p class="text-xs text-gray-500">
                Menampilkan {{ $guruData->count() }} dari {{ number_format($guruData->total()) }} guru
            </p>
            <div class="flex items-center gap-1">
                @if($guruData->onFirstPage())
                <span class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-300 cursor-not-allowed">‹</span>
                @else
                <a href="{{ $guruData->previousPageUrl() }}#rekap-tabel"
                    class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100">‹</a>
                @endif

                @php
                $currentPage = $guruData->currentPage();
                $lastPage = $guruData->lastPage();
                $window = 2;
                $pages = collect();
                $pages->push(1);
                for ($p = max(2, $currentPage - $window); $p <= min($lastPage - 1, $currentPage + $window); $p++) {
                    $pages->push($p);
                    }
                    if ($lastPage > 1) $pages->push($lastPage);
                    $pages = $pages->unique()->sort()->values();
                    @endphp

                    @php $prev = null; @endphp
                    @foreach($pages as $p)
                    @if($prev !== null && $p - $prev > 1)
                    <span class="w-8 h-8 flex items-center justify-center text-xs text-gray-400">…</span>
                    @endif
                    <a href="{{ $guruData->url($p) }}#rekap-tabel"
                        class="w-8 h-8 flex items-center justify-center rounded-lg text-xs font-medium
                              {{ $currentPage == $p ? 'bg-gray-900 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                        {{ $p }}
                    </a>
                    @php $prev = $p; @endphp
                    @endforeach

                    @if($guruData->hasMorePages())
                    <a href="{{ $guruData->nextPageUrl() }}#rekap-tabel"
                        class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100">›</a>
                    @else
                    <span class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-300 cursor-not-allowed">›</span>
                    @endif
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════════════════ --}}
    {{-- ── MODAL DETAIL PER BULAN ──────────────────────────────────────── --}}
    {{-- ══════════════════════════════════════════════════════════════════ --}}
    <div id="modalOverlay"
        class="fixed inset-0 bg-black/40 backdrop-blur-sm z-50 hidden items-center justify-center p-4"
        onclick="closeModal(event)">

        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-3xl max-h-[90vh] flex flex-col" onclick="event.stopPropagation()">

            {{-- Modal Header --}}
            <div class="flex items-start justify-between px-6 py-5 border-b border-gray-100 shrink-0">
                <div class="flex items-center gap-3">
                    <div id="modalAvatar"
                        class="w-11 h-11 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center text-sm font-bold shrink-0">
                    </div>
                    <div>
                        <h3 id="modalNama" class="text-base font-bold text-gray-900"></h3>
                        <p id="modalSubtitle" class="text-xs text-gray-400 mt-0.5"></p>
                    </div>
                </div>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 transition-colors p-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- Modal Stat Cards (ringkasan tahunan guru) --}}
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 px-6 pt-4 pb-2 shrink-0">
                <div class="bg-gray-50 rounded-xl p-3 text-center">
                    <p class="text-xs text-gray-500">Total Jam</p>
                    <p id="ms_jam" class="text-xl font-bold text-gray-900 mt-0.5">—</p>
                </div>
                <div class="bg-emerald-50 rounded-xl p-3 text-center">
                    <p class="text-xs text-emerald-600">Total Hadir</p>
                    <p id="ms_hadir" class="text-xl font-bold text-emerald-700 mt-0.5">—</p>
                </div>
                <div class="bg-amber-50 rounded-xl p-3 text-center">
                    <p class="text-xs text-amber-600">Sakit / Izin</p>
                    <p id="ms_izin" class="text-xl font-bold text-amber-700 mt-0.5">—</p>
                </div>
                <div class="bg-red-50 rounded-xl p-3 text-center">
                    <p class="text-xs text-red-500">Alfa</p>
                    <p id="ms_alfa" class="text-xl font-bold text-red-600 mt-0.5">—</p>
                </div>
            </div>

            {{-- Modal body: tabel detail per bulan --}}
            <div class="flex-1 overflow-y-auto px-6 pb-6">
                <div id="modalLoading" class="flex items-center justify-center py-12 hidden">
                    <div class="w-7 h-7 border-2 border-indigo-500 border-t-transparent rounded-full animate-spin"></div>
                    <span class="ml-3 text-sm text-gray-500">Memuat data...</span>
                </div>

                <div id="modalError" class="hidden py-8 text-center text-red-500 text-sm"></div>

                <table class="w-full text-sm mt-2" id="modalTable">
                    <thead>
                        <tr class="bg-gray-50 text-left rounded-xl">
                            <th class="px-4 py-2.5 text-xs font-semibold text-gray-500 uppercase tracking-wider rounded-l-xl">Bulan</th>
                            <th class="px-4 py-2.5 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right">Jam Mengajar</th>
                            <th class="px-4 py-2.5 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right">Hadir</th>
                            <th class="px-4 py-2.5 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right">Sakit</th>
                            <th class="px-4 py-2.5 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right">Izin</th>
                            <th class="px-4 py-2.5 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right">Alfa</th>
                            <th class="px-4 py-2.5 text-xs font-semibold text-gray-500 uppercase tracking-wider rounded-r-xl">% Hadir</th>
                        </tr>
                    </thead>
                    <tbody id="modalTableBody" class="divide-y divide-gray-50">
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-gray-400 text-sm">Pilih guru untuk melihat detail</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const namaBulan = {
                1: 'Januari',
                2: 'Februari',
                3: 'Maret',
                4: 'April',
                5: 'Mei',
                6: 'Juni',
                7: 'Juli',
                8: 'Agustus',
                9: 'September',
                10: 'Oktober',
                11: 'November',
                12: 'Desember'
            };
            const namaBulanShort = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
            const bulanKeys = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
            const rawBulan = @json($trenJamPerBulan);
            const rawTahun = @json($trenJamPerTahun);

            const jamPerBulan = bulanKeys.map(b => rawBulan[b] ?? 0);

            // ── Chart Tren Jam ────────────────────────────────────────────
            const ctxJam = document.getElementById('chartTrenJam')?.getContext('2d');
            if (!ctxJam) return;

            const gradJam = ctxJam.createLinearGradient(0, 0, 0, 220);
            gradJam.addColorStop(0, 'rgba(99,102,241,0.25)');
            gradJam.addColorStop(1, 'rgba(99,102,241,0)');

            let chartTren = new Chart(ctxJam, {
                type: 'line',
                data: {
                    labels: namaBulanShort,
                    datasets: [{
                        label: 'Jam Mengajar',
                        data: jamPerBulan,
                        borderColor: '#6366f1',
                        backgroundColor: gradJam,
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
                                label: ctx => ` ${ctx.parsed.y.toLocaleString('id-ID')} jam`
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
                                callback: val => val >= 1000 ? (val / 1000).toFixed(1) + 'K' : val
                            }
                        }
                    }
                }
            });

            window.switchChart = function(mode) {
                const btnBulan = document.getElementById('btnBulan');
                const btnTahun = document.getElementById('btnTahun');
                if (mode === 'bulan') {
                    chartTren.data.labels = namaBulanShort;
                    chartTren.data.datasets[0].data = jamPerBulan;
                    btnBulan.className = 'px-3 py-1 text-xs font-medium rounded-lg bg-gray-900 text-white transition-colors';
                    btnTahun.className = 'px-3 py-1 text-xs font-medium rounded-lg bg-gray-100 text-gray-600 hover:bg-gray-200 transition-colors';
                } else {
                    chartTren.data.labels = Object.keys(rawTahun);
                    chartTren.data.datasets[0].data = Object.values(rawTahun);
                    btnTahun.className = 'px-3 py-1 text-xs font-medium rounded-lg bg-gray-900 text-white transition-colors';
                    btnBulan.className = 'px-3 py-1 text-xs font-medium rounded-lg bg-gray-100 text-gray-600 hover:bg-gray-200 transition-colors';
                }
                chartTren.update();
            };

            // ── Chart Distribusi Semester — bar per bulan ─────────────────
            (function() {
                const rawBulan = @json($trenJamPerBulan);
                const BULAN_SHORT = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
                const months = BULAN_SHORT.map((label, i) => ({
                    label,
                    jam: rawBulan[i + 1] ?? 0,
                    sem: i < 6 ? 1 : 2,
                }));

                const maxJam = Math.max(...months.map(m => m.jam), 1);
                const container = document.getElementById('semesterMonthBars');
                if (!container) return;

                let prevSem = null;
                months.forEach((m, i) => {
                    if (m.sem !== prevSem) {
                        const d = document.createElement('p');
                        d.className = 'text-xs text-gray-400 text-center py-1';
                        d.textContent = m.sem === 1 ? '— Semester 1 —' : '— Semester 2 —';
                        container.appendChild(d);
                        prevSem = m.sem;
                    }

                    const color = m.sem === 1 ? '#6366f1' : '#f59e0b';
                    const pct = Math.round(m.jam / maxJam * 100);

                    const row = document.createElement('div');
                    row.className = 'flex items-center gap-2';
                    row.innerHTML = `
                        <span class="text-xs text-gray-400 w-6 text-right shrink-0">${m.label}</span>
                        <div class="flex-1 bg-gray-100 rounded h-5 relative overflow-hidden">
                            <div class="month-bar h-full rounded flex items-center px-2 transition-all duration-500"
                                style="width:0%;background:${color};" data-w="${pct}">
                                <span class="text-xs font-medium text-white">${m.jam.toLocaleString('id-ID')}</span>
                            </div>
                        </div>
                    `;
                    container.appendChild(row);

                    setTimeout(() => {
                        row.querySelector('.month-bar').style.width = pct + '%';
                    }, 60 + i * 40);
                });
            })();
        });

        // ── MODAL LOGIC ───────────────────────────────────────────────────────
        const namaBulanFull = {
            1: 'Januari',
            2: 'Februari',
            3: 'Maret',
            4: 'April',
            5: 'Mei',
            6: 'Juni',
            7: 'Juli',
            8: 'Agustus',
            9: 'September',
            10: 'Oktober',
            11: 'November',
            12: 'Desember'
        };

        function openModal(guru) {
            // Populate header
            document.getElementById('modalAvatar').textContent = guru.nama.substring(0, 2).toUpperCase();
            document.getElementById('modalNama').textContent = guru.nama;
            const labelTahun = guru.tahun === 'all' ? 'Semua Tahun' : `Tahun ${guru.tahun}`;
            document.getElementById('modalSubtitle').textContent = `NIP: ${guru.nip} · ${guru.bidang_studi} · ${labelTahun}`;

            // Populate summary cards
            document.getElementById('ms_jam').textContent = Number(guru.total_jam || 0).toLocaleString('id-ID') + ' jam';
            document.getElementById('ms_hadir').textContent = guru.total_hadir ?? 0;
            document.getElementById('ms_izin').textContent = ((guru.total_sakit ?? 0) + (guru.total_izin ?? 0));
            document.getElementById('ms_alfa').textContent = guru.total_alfa ?? 0;

            // Show modal
            const overlay = document.getElementById('modalOverlay');
            overlay.classList.remove('hidden');
            overlay.classList.add('flex');

            // Fetch detail per bulan
            fetchDetailBulan(guru.id_guru, guru.tahun);
        }

        function closeModal(event) {
            if (event && event.target !== document.getElementById('modalOverlay')) return;
            const overlay = document.getElementById('modalOverlay');
            overlay.classList.add('hidden');
            overlay.classList.remove('flex');
        }

        // Override close button call (no event arg)
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const overlay = document.getElementById('modalOverlay');
                overlay.classList.add('hidden');
                overlay.classList.remove('flex');
            }
        });

        function fetchDetailBulan(idGuru, tahun) {
            const tbody = document.getElementById('modalTableBody');
            const loading = document.getElementById('modalLoading');
            const errDiv = document.getElementById('modalError');

            // Reset
            tbody.innerHTML = '';
            errDiv.classList.add('hidden');
            loading.classList.remove('hidden');

            fetch(`{{ route('dashboard.detail-bulan') }}?id_guru=${idGuru}&tahun=${tahun}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(r => {
                    if (!r.ok) throw new Error('Gagal memuat data');
                    return r.json();
                })
                .then(data => {
                    loading.classList.add('hidden');
                    if (!data.length) {
                        tbody.innerHTML = `<tr><td colspan="7" class="px-4 py-8 text-center text-gray-400 text-sm">Tidak ada data untuk periode ini.</td></tr>`;
                        return;
                    }

                    tbody.innerHTML = data.map(row => {
                        const izinTotal = (row.total_sakit ?? 0) + (row.total_izin ?? 0);
                        const allTotal = (row.total_hadir ?? 0) + izinTotal + (row.total_alfa ?? 0);
                        const pct = allTotal > 0 ? Math.round((row.total_hadir / allTotal) * 100) : 0;
                        const barColor = pct >= 90 ? 'bg-emerald-500' : (pct >= 75 ? 'bg-amber-400' : 'bg-red-400');
                        const textColor = pct >= 90 ? 'text-emerald-600' : (pct >= 75 ? 'text-amber-600' : 'text-red-500');

                        return `<tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-4 py-3 font-medium text-gray-700">${namaBulanFull[row.bulan] ?? row.bulan}</td>
                    <td class="px-4 py-3 text-right text-gray-800 font-semibold">${Number(row.total_jam_mengajar ?? 0).toLocaleString('id-ID')} <span class="text-xs font-normal text-gray-400">jam</span></td>
                    <td class="px-4 py-3 text-right">
                        <span class="inline-flex items-center justify-center px-2 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100 min-w-[2rem]">${row.total_hadir ?? 0}</span>
                    </td>
                    <td class="px-4 py-3 text-right">
                        ${(row.total_sakit ?? 0) > 0
                            ? `<span class="inline-flex items-center justify-center px-2 py-0.5 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-100 min-w-[2rem]">${row.total_sakit}</span>`
                            : `<span class="text-gray-300">—</span>`}
                    </td>
                    <td class="px-4 py-3 text-right">
                        ${(row.total_izin ?? 0) > 0
                            ? `<span class="inline-flex items-center justify-center px-2 py-0.5 rounded-full text-xs font-semibold bg-orange-50 text-orange-700 border border-orange-100 min-w-[2rem]">${row.total_izin}</span>`
                            : `<span class="text-gray-300">—</span>`}
                    </td>
                    <td class="px-4 py-3 text-right">
                        ${(row.total_alfa ?? 0) > 0
                            ? `<span class="inline-flex items-center justify-center px-2 py-0.5 rounded-full text-xs font-semibold bg-red-50 text-red-700 border border-red-100 min-w-[2rem]">${row.total_alfa}</span>`
                            : `<span class="text-gray-300">—</span>`}
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-2">
                            <div class="w-16 bg-gray-100 rounded-full h-1.5">
                                <div class="h-1.5 rounded-full ${barColor}" style="width:${pct}%"></div>
                            </div>
                            <span class="text-xs font-bold ${textColor}">${pct}%</span>
                        </div>
                    </td>
                </tr>`;
                    }).join('');
                })
                .catch(err => {
                    loading.classList.add('hidden');
                    errDiv.textContent = err.message;
                    errDiv.classList.remove('hidden');
                });
        }
    </script>
    @endpush

</x-app>