<x-app title="Laporan | SMA Cendana Pekanbaru">
    
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Laporan Kinerja Guru</h1>
            <p class="text-sm text-gray-500 mt-1">Ringkasan performa mengajar dan kehadiran tenaga pengajar</p>
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
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                </div>
            </div>
        </form>
    </div>

    {{-- ===== STAT CARDS ===== --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <p class="text-xs font-medium text-gray-400 uppercase tracking-wide">Total Jam Mengajar</p>
            <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($totalJamTahun) }}</p>
            <p class="text-xs text-gray-400 font-medium mt-1">Jam tahun {{ $tahun }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <p class="text-xs font-medium text-gray-400 uppercase tracking-wide">Tingkat Kehadiran</p>
            <p class="text-3xl font-bold text-emerald-500 mt-2">{{ $persenKehadiran }}%</p>
            <div class="mt-2 w-full bg-gray-100 rounded-full h-1.5">
                <div class="bg-emerald-500 h-1.5 rounded-full" style="width: {{ $persenKehadiran }}%"></div>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <p class="text-xs font-medium text-gray-400 uppercase tracking-wide">Total Prestasi</p>
            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalPrestasi }}</p>
            <p class="text-xs text-emerald-600 font-medium mt-1">Seluruh periode</p>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <p class="text-xs font-medium text-gray-400 uppercase tracking-wide">Total Pelatihan</p>
            <p class="text-3xl font-bold text-amber-500 mt-2">{{ $totalPelatihan }}</p>
            <p class="text-xs text-gray-400 font-medium mt-1">Kegiatan tercatat</p>
        </div>
    </div>

    {{-- ===== DOWNLOAD REPORT CARDS ===== --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
        @foreach([['Laporan Jam Mengajar','Rekap total jam per guru','M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z','bg-gray-100','text-gray-700'],['Laporan Kehadiran','Data hadir, izin & alfa guru','M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z','bg-emerald-50','text-emerald-600'],['Laporan Analisis Kinerja','Performa lengkap guru','M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z','bg-amber-50','text-amber-600']] as $card)
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <div class="w-9 h-9 rounded-xl {{ $card[3] }} flex items-center justify-center mb-3">
                <svg class="w-5 h-5 {{ $card[4] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $card[2] }}" /></svg>
            </div>
            <p class="text-sm font-semibold text-gray-800">{{ $card[0] }}</p>
            <p class="text-xs text-gray-400 mt-0.5">{{ $card[1] }}</p>
            <div class="flex items-center gap-2 mt-4">
                <button onclick="alert('Download PDF...')" class="flex-1 flex items-center justify-center gap-1.5 bg-gray-900 hover:bg-gray-700 text-white text-xs font-semibold py-2 rounded-xl transition-all">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                    PDF
                </button>
                <button onclick="alert('Download Excel...')" class="flex-1 flex items-center justify-center gap-1.5 bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-semibold py-2 rounded-xl transition-all">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                    Excel
                </button>
            </div>
        </div>
        @endforeach
    </div>

    {{-- ===== CHARTS ===== --}}
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6 mb-8">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 lg:col-span-3">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-base font-semibold text-gray-900">Tren Absensi per Bulan</h2>
                    <p class="text-xs text-gray-400 mt-0.5">Sakit, Izin, Alpa per bulan</p>
                </div>
                <div class="flex items-center gap-3 text-xs text-gray-500">
                    <span class="flex items-center gap-1.5"><span class="w-3 h-0.5 bg-indigo-500 inline-block rounded"></span> Sakit</span>
                    <span class="flex items-center gap-1.5"><span class="w-3 h-0.5 bg-amber-400 inline-block rounded"></span> Izin</span>
                    <span class="flex items-center gap-1.5"><span class="w-3 h-0.5 bg-red-400 inline-block rounded"></span> Alpa</span>
                </div>
            </div>
            <div class="relative h-56"><canvas id="lineChart"></canvas></div>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 lg:col-span-2">
            <div class="mb-4">
                <h2 class="text-base font-semibold text-gray-900">Distribusi Absensi</h2>
                <p class="text-xs text-gray-400 mt-0.5">Tahun {{ $tahun }}</p>
            </div>
            <div class="relative h-44 flex items-center justify-center"><canvas id="pieChart"></canvas></div>
            @php
                $totalSakit = $trenKehadiran->sum('total_sakit');
                $totalIzin = $trenKehadiran->sum('total_izin');
                $totalAlpa = $trenKehadiran->sum('total_alpa');
            @endphp
            <div class="grid grid-cols-3 gap-2 mt-5">
                <div class="flex flex-col items-center gap-1"><span class="w-3 h-3 rounded-full bg-blue-500"></span><span class="text-xs text-gray-500">Sakit</span><span class="text-sm font-bold text-gray-800">{{ $totalSakit }}</span></div>
                <div class="flex flex-col items-center gap-1"><span class="w-3 h-3 rounded-full bg-amber-400"></span><span class="text-xs text-gray-500">Izin</span><span class="text-sm font-bold text-gray-800">{{ $totalIzin }}</span></div>
                <div class="flex flex-col items-center gap-1"><span class="w-3 h-3 rounded-full bg-red-400"></span><span class="text-xs text-gray-500">Alpa</span><span class="text-sm font-bold text-gray-800">{{ $totalAlpa }}</span></div>
            </div>
        </div>
    </div>

    {{-- ===== TABLE ===== --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 px-6 py-4 border-b border-gray-100">
            <h2 class="text-base font-semibold text-gray-900">Detail Kinerja Guru</h2>
            <form method="GET" action="{{ route('laporan') }}" class="flex items-center gap-3">
                <input type="hidden" name="tahun" value="{{ $tahun }}">
                <div class="relative">
                    <input type="text" name="search" value="{{ $search }}" placeholder="Cari guru..."
                        class="bg-gray-50 border border-gray-200 rounded-xl pl-9 pr-4 py-2 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-amber-400 w-44">
                    <svg class="w-4 h-4 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                </div>
                <button type="submit" class="bg-gray-900 hover:bg-gray-700 text-white text-xs font-semibold px-4 py-2 rounded-xl transition-all">Cari</button>
            </form>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 text-left">
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Guru</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Jam Mengajar</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Kehadiran</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Prestasi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($guruKinerja as $guru)
                    @php
                        $absen = $absensiPerGuru[$guru->nama_guru] ?? null;
                        $totalAbsen = $absen ? $absen->total_absen : 0;
                        $jmlPrestasi = $prestasiPerGuru[$guru->nama_guru] ?? 0;
                    @endphp
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center text-xs font-bold shrink-0">{{ strtoupper(substr($guru->nama_guru, 0, 2)) }}</div>
                                <div><p class="font-semibold text-gray-800">{{ $guru->nama_guru }}</p><p class="text-xs text-gray-400">{{ $guru->bidang_studi }}</p></div>
                            </div>
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-700">{{ $guru->total_jam }} jam</td>
                        <td class="px-6 py-4">
                            @if($totalAbsen == 0)
                            <span class="text-emerald-600 font-semibold text-xs">Hadir Penuh</span>
                            @else
                            <span class="text-amber-600 font-semibold text-xs">{{ $totalAbsen }} hari absen</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($jmlPrestasi > 0)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">{{ $jmlPrestasi }} prestasi</span>
                            @else
                            <span class="text-gray-400">—</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="px-6 py-8 text-center text-gray-400">Tidak ada data.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $guruKinerja->appends(['tahun' => $tahun, 'search' => $search])->links() }}
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const trenData = @json($trenKehadiran);
            const bulanNames = @json($namaBulan);
            const labels = trenData.map(t => bulanNames[t.periode_bulan] ? bulanNames[t.periode_bulan].substring(0,3) : t.periode_bulan);

            // Line Chart
            const lineCtx = document.getElementById('lineChart').getContext('2d');
            const g = lineCtx.createLinearGradient(0,0,0,220);
            g.addColorStop(0,'rgba(99,102,241,0.2)'); g.addColorStop(1,'rgba(99,102,241,0)');
            new Chart(lineCtx, {
                type: 'line',
                data: { labels, datasets: [
                    { label:'Sakit', data: trenData.map(t=>parseInt(t.total_sakit)), borderColor:'#6366f1', borderWidth:2.5, backgroundColor:g, fill:true, tension:0.4, pointBackgroundColor:'#6366f1', pointBorderColor:'#fff', pointBorderWidth:2, pointRadius:4 },
                    { label:'Izin', data: trenData.map(t=>parseInt(t.total_izin)), borderColor:'#fbbf24', borderWidth:2, fill:false, tension:0.4, pointBackgroundColor:'#fbbf24', pointBorderColor:'#fff', pointBorderWidth:2, pointRadius:4 },
                    { label:'Alpa', data: trenData.map(t=>parseInt(t.total_alpa)), borderColor:'#f87171', borderWidth:2, fill:false, tension:0.4, pointBackgroundColor:'#f87171', pointBorderColor:'#fff', pointBorderWidth:2, pointRadius:4 }
                ]},
                options: { responsive:true, maintainAspectRatio:false, plugins:{ legend:{display:false}, tooltip:{ backgroundColor:'#1e293b', bodyColor:'#fff', padding:10, callbacks:{ label: ctx=>` ${ctx.dataset.label}: ${ctx.parsed.y}` }}},
                    scales:{ x:{grid:{display:false},border:{display:false},ticks:{color:'#94a3b8',font:{size:11}}}, y:{min:0,grid:{color:'#f1f5f9'},border:{display:false},ticks:{color:'#94a3b8',font:{size:11},stepSize:5}} }}
            });

            // Pie Chart
            const pieCtx = document.getElementById('pieChart').getContext('2d');
            new Chart(pieCtx, {
                type: 'pie',
                data: { labels:['Sakit','Izin','Alpa'], datasets:[{ data:[{{ $totalSakit }},{{ $totalIzin }},{{ $totalAlpa }}], backgroundColor:['#3b82f6','#fbbf24','#f87171'], borderWidth:2, borderColor:'#fff', hoverOffset:6 }]},
                options: { responsive:true, maintainAspectRatio:false, plugins:{ legend:{display:false}, tooltip:{ backgroundColor:'#1e293b', bodyColor:'#fff', padding:10, callbacks:{ label: ctx=>` ${ctx.label}: ${ctx.parsed} hari` }}}}
            });
        });
    </script>
    @endpush

</x-app>