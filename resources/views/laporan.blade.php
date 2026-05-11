<x-app title="Laporan | SMA Cendana Pekanbaru">
    
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Laporan Kinerja Guru</h1>
            <p class="text-sm text-gray-500 mt-1">Ringkasan performa mengajar dan kehadiran tenaga pengajar</p>
        </div>
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
    </div>

    {{-- ===== STAT CARDS ===== --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8">

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <p class="text-xs font-medium text-gray-400 uppercase tracking-wide">Rata-rata Nilai Siswa</p>
            <p class="text-3xl font-bold text-gray-900 mt-2">85.5</p>
            <p class="text-xs text-emerald-600 font-medium mt-1 flex items-center gap-1">
                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                </svg>
                +2.1 dari semester lalu
            </p>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <p class="text-xs font-medium text-gray-400 uppercase tracking-wide">Jam Mengajar Minggu Ini</p>
            <p class="text-3xl font-bold text-gray-900 mt-2">24</p>
            <p class="text-xs text-gray-400 font-medium mt-1">Jam terealisasi</p>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <p class="text-xs font-medium text-gray-400 uppercase tracking-wide">Tingkat Kehadiran</p>
            <p class="text-3xl font-bold text-emerald-500 mt-2">92%</p>
            <div class="mt-2 w-full bg-gray-100 rounded-full h-1.5">
                <div class="bg-emerald-500 h-1.5 rounded-full" style="width: 92%"></div>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <p class="text-xs font-medium text-gray-400 uppercase tracking-wide">Performa Rating</p>
            <p class="text-3xl font-bold text-amber-500 mt-2">4.5</p>
            <div class="flex items-center gap-0.5 mt-1.5">
                @for($i = 1; $i <= 5; $i++)
                    @if($i <=4)
                    <svg class="w-3.5 h-3.5 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                    @else
                    <svg class="w-3.5 h-3.5 text-amber-200" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                    @endif
                    @endfor
            </div>
        </div>
    </div>

    {{-- ===== DOWNLOAD REPORT CARDS ===== --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">

        {{-- Laporan Jam Mengajar --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <div class="flex items-start justify-between">
                <div>
                    <div class="w-9 h-9 rounded-xl bg-gray-100 flex items-center justify-center mb-3">
                        <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <p class="text-sm font-semibold text-gray-800">Laporan Jam Mengajar</p>
                    <p class="text-xs text-gray-400 mt-0.5">Rekap total jam per guru</p>
                </div>
            </div>
            <div class="flex items-center gap-2 mt-4">
                <button onclick="unduh('Jam Mengajar', 'PDF')"
                    class="flex-1 flex items-center justify-center gap-1.5 bg-gray-900 hover:bg-gray-700 text-white text-xs font-semibold py-2 rounded-xl transition-all">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Download PDF
                </button>
                <button onclick="unduh('Jam Mengajar', 'Excel')"
                    class="flex-1 flex items-center justify-center gap-1.5 bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-semibold py-2 rounded-xl transition-all">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Download Excel
                </button>
            </div>
        </div>

        {{-- Laporan Kehadiran --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <div class="flex items-start justify-between">
                <div>
                    <div class="w-9 h-9 rounded-xl bg-emerald-50 flex items-center justify-center mb-3">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <p class="text-sm font-semibold text-gray-800">Laporan Kehadiran</p>
                    <p class="text-xs text-gray-400 mt-0.5">Data hadir, izin & alfa guru</p>
                </div>
            </div>
            <div class="flex items-center gap-2 mt-4">
                <button onclick="unduh('Kehadiran', 'PDF')"
                    class="flex-1 flex items-center justify-center gap-1.5 bg-gray-900 hover:bg-gray-700 text-white text-xs font-semibold py-2 rounded-xl transition-all">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Download PDF
                </button>
                <button onclick="unduh('Kehadiran', 'Excel')"
                    class="flex-1 flex items-center justify-center gap-1.5 bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-semibold py-2 rounded-xl transition-all">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Download Excel
                </button>
            </div>
        </div>

        {{-- Laporan Analisis Kinerja --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <div class="flex items-start justify-between">
                <div>
                    <div class="w-9 h-9 rounded-xl bg-amber-50 flex items-center justify-center mb-3">
                        <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <p class="text-sm font-semibold text-gray-800">Laporan Analisis Kinerja</p>
                    <p class="text-xs text-gray-400 mt-0.5">Nilai & performa lengkap</p>
                </div>
            </div>
            <div class="flex items-center gap-2 mt-4">
                <button onclick="unduh('Analisis Kinerja', 'PDF')"
                    class="flex-1 flex items-center justify-center gap-1.5 bg-gray-900 hover:bg-gray-700 text-white text-xs font-semibold py-2 rounded-xl transition-all">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Download PDF
                </button>
                <button onclick="unduh('Analisis Kinerja', 'Excel')"
                    class="flex-1 flex items-center justify-center gap-1.5 bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-semibold py-2 rounded-xl transition-all">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Download Excel
                </button>
            </div>
        </div>
    </div>

    {{-- ===== CHARTS ===== --}}
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6 mb-8">

        {{-- Line Chart --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 lg:col-span-3">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-base font-semibold text-gray-900">Korelasi Jam Mengajar & Nilai Siswa</h2>
                    <p class="text-xs text-gray-400 mt-0.5">Perbandingan tren mingguan</p>
                </div>
                <div class="flex items-center gap-3 text-xs text-gray-500">
                    <span class="flex items-center gap-1.5">
                        <span class="w-3 h-0.5 bg-indigo-500 inline-block rounded"></span> Hadir
                    </span>
                    <span class="flex items-center gap-1.5">
                        <span class="w-3 h-0.5 bg-amber-400 inline-block rounded"></span> Izin
                    </span>
                    <span class="flex items-center gap-1.5">
                        <span class="w-3 h-0.5 bg-red-400 inline-block rounded"></span> Alfa
                    </span>
                </div>
            </div>
            <div class="relative h-56">
                <canvas id="lineChart"></canvas>
            </div>
        </div>

        {{-- Pie Chart --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 lg:col-span-2">
            <div class="mb-4">
                <h2 class="text-base font-semibold text-gray-900">Perbandingan Performa Guru</h2>
                <p class="text-xs text-gray-400 mt-0.5">Distribusi status kehadiran</p>
            </div>
            <div class="relative h-44 flex items-center justify-center">
                <canvas id="pieChart"></canvas>
            </div>
            <div class="grid grid-cols-3 gap-2 mt-5">
                <div class="flex flex-col items-center gap-1">
                    <span class="w-3 h-3 rounded-full bg-blue-500 shrink-0"></span>
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

    {{-- ===== TABLE ===== --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 px-6 py-4 border-b border-gray-100">
            <h2 class="text-base font-semibold text-gray-900">Detail Kinerja Guru</h2>
            <div class="flex items-center gap-3">
                {{-- Search --}}
                <div class="relative">
                    <input type="text" placeholder="Cari guru..."
                        class="bg-gray-50 border border-gray-200 rounded-xl pl-9 pr-4 py-2 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-amber-400 w-44">
                    <svg class="w-4 h-4 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                {{-- Filter --}}
                <select class="bg-gray-50 border border-gray-200 rounded-xl px-3 py-2 text-sm text-gray-700 focus:outline-none">
                    <option>Semua Departemen</option>
                    <option>MIPA</option>
                    <option>IPS</option>
                    <option>Bahasa</option>
                    <option>Olahraga & Seni</option>
                </select>
                {{-- Export Buttons --}}
                <button onclick="unduh('Detail Kinerja', 'Excel')"
                    class="flex items-center gap-1.5 bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-semibold px-4 py-2 rounded-xl transition-all">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Export Excel
                </button>
                <button onclick="unduh('Detail Kinerja', 'PDF')"
                    class="flex items-center gap-1.5 bg-gray-900 hover:bg-gray-700 text-white text-xs font-semibold px-4 py-2 rounded-xl transition-all">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Export PDF
                </button>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 text-left">
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Guru</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Jam Mengajar</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Rata-rata Nilai</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Kehadiran</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Rating</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Performa</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @php
                    $guruData = [
                    ['nama' => 'Budi Santoso', 'mapel' => 'Matematika', 'jam' => 20, 'nilai' => 18, 'hadir' => 2, 'alfa' => 0, 'rating' => 4.8, 'performa' => 90],
                    ['nama' => 'Siti Rahayu', 'mapel' => 'Bahasa Indonesia', 'jam' => 20, 'nilai' => 19, 'hadir' => 1, 'alfa' => 0, 'rating' => 4.5, 'performa' => 95],
                    ['nama' => 'Ahmad Fauzi', 'mapel' => 'Fisika', 'jam' => 20, 'nilai' => 17, 'hadir' => 2, 'alfa' => 1, 'rating' => 4.2, 'performa' => 82],
                    ['nama' => 'Rina Marlina', 'mapel' => 'Kimia', 'jam' => 20, 'nilai' => 20, 'hadir' => 0, 'alfa' => 0, 'rating' => 5.0, 'performa' => 100],
                    ['nama' => 'Doni Kusuma', 'mapel' => 'Biologi', 'jam' => 20, 'nilai' => 15, 'hadir' => 3, 'alfa' => 2, 'rating' => 3.5, 'performa' => 68],
                    ['nama' => 'Wulandari', 'mapel' => 'Sejarah', 'jam' => 20, 'nilai' => 19, 'hadir' => 1, 'alfa' => 0, 'rating' => 4.7, 'performa' => 93],
                    ['nama' => 'Hendra Wijaya', 'mapel' => 'Bahasa Inggris', 'jam' => 20, 'nilai' => 18, 'hadir' => 2, 'alfa' => 0, 'rating' => 4.4, 'performa' => 88],
                    ];
                    @endphp

                    @foreach($guruData as $guru)
                    @php
                    $pc = $guru['performa'];
                    $barColor = $pc >= 90 ? 'bg-emerald-500' : ($pc >= 75 ? 'bg-amber-400' : 'bg-red-400');
                    $textColor = $pc >= 90 ? 'text-emerald-600' : ($pc >= 75 ? 'text-amber-600' : 'text-red-500');
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
                        {{-- Jam Mengajar --}}
                        <td class="px-6 py-4 font-medium text-gray-700">{{ $guru['jam'] }}</td>
                        {{-- Rata-rata Nilai --}}
                        <td class="px-6 py-4 font-semibold text-gray-800">{{ $guru['nilai'] }}</td>
                        {{-- Kehadiran (Izin & Alfa) --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                @if($guru['hadir'] > 0)
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-amber-50 text-amber-700 border border-amber-100">
                                    {{ $guru['hadir'] }} izin
                                </span>
                                @endif
                                @if($guru['alfa'] > 0)
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-50 text-red-700 border border-red-100">
                                    {{ $guru['alfa'] }} alfa
                                </span>
                                @endif
                                @if($guru['hadir'] == 0 && $guru['alfa'] == 0)
                                <span class="text-gray-400 text-xs">—</span>
                                @endif
                            </div>
                        </td>
                        {{-- Rating --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <span class="text-sm font-semibold text-gray-800">{{ number_format($guru['rating'], 1) }}</span>
                            </div>
                        </td>
                        {{-- Performa --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <div class="w-20 bg-gray-100 rounded-full h-1.5">
                                    <div class="h-1.5 rounded-full {{ $barColor }}" style="width: {{ $pc }}%"></div>
                                </div>
                                <span class="font-semibold text-sm {{ $textColor }}">{{ $pc }}%</span>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
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
            const gradientHadir = lineCtx.createLinearGradient(0, 0, 0, 220);
            gradientHadir.addColorStop(0, 'rgba(99, 102, 241, 0.2)');
            gradientHadir.addColorStop(1, 'rgba(99, 102, 241, 0.0)');

            new Chart(lineCtx, {
                type: 'line',
                data: {
                    labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'],
                    datasets: [{
                            label: 'Hadir',
                            data: [90, 88, 92, 86, 90],
                            borderColor: '#6366f1',
                            borderWidth: 2.5,
                            backgroundColor: gradientHadir,
                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: '#6366f1',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            pointHoverRadius: 6,
                        },
                        {
                            label: 'Izin',
                            data: [6, 8, 5, 10, 7],
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
                            data: [4, 4, 3, 4, 3],
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
                                label: ctx => ` ${ctx.dataset.label}: ${ctx.parsed.y}`
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
                                stepSize: 20
                            }
                        }
                    }
                }
            });

            // ---- Pie Chart ----
            const pieCtx = document.getElementById('pieChart').getContext('2d');
            new Chart(pieCtx, {
                type: 'pie',
                data: {
                    labels: ['Hadir', 'Izin', 'Alfa'],
                    datasets: [{
                        data: [46, 3, 1],
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

        function unduh(jenis, format) {
            const sel = document.getElementById('periodeSelect');
            const periode = sel.options[sel.selectedIndex].text;
            alert(`Laporan "${jenis}" (${format}) periode "${periode}" sedang diunduh...`);
        }
    </script>
    @endpush

</x-app>