<x-app title="Laporan | SMA Cendana Pekanbaru">

    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Pengaturan</h1>
        <p class="text-sm text-gray-500 mt-1">Kelola pengguna, tampilan, dan konfigurasi sistem</p>
    </div>

    {{-- ===== SETTING TABS ===== --}}
    <div class="flex items-center gap-1 bg-white border border-gray-100 shadow-sm rounded-2xl p-1.5 mb-8 overflow-x-auto w-fit">
        <button class="setting-tab active" data-tab="pengguna" onclick="switchTab('pengguna', this)">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            Kelola Pengguna
        </button>
        <button class="setting-tab" data-tab="tampilan" onclick="switchTab('tampilan', this)">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
            </svg>
            Tampilan
        </button>
        <button class="setting-tab" data-tab="keamanan" onclick="switchTab('keamanan', this)">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
            Keamanan
        </button>
        <button class="setting-tab" data-tab="sekolah" onclick="switchTab('sekolah', this)">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
            </svg>
            Info Sekolah
        </button>
    </div>

    {{-- ================================================================ --}}
    {{-- TAB 1: KELOLA PENGGUNA --}}
    {{-- ================================================================ --}}
    <div id="panel-pengguna" class="setting-panel active">

        {{-- Role summary cards --}}
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-indigo-950 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-indigo-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-400 font-medium">Tata Usaha</p>
                    <p class="text-xl font-bold text-gray-900">1</p>
                </div>
            </div>
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-400 font-medium">Kepala Sekolah</p>
                    <p class="text-xl font-bold text-gray-900">1</p>
                </div>
            </div>
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-400 font-medium">Wakil Kepala</p>
                    <p class="text-xl font-bold text-gray-900">2</p>
                </div>
            </div>
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-amber-500 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-400 font-medium">Guru</p>
                    <p class="text-xl font-bold text-gray-900">48</p>
                </div>
            </div>
        </div>

        {{-- User Table --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 px-6 py-4 border-b border-gray-100">
                <h2 class="text-base font-semibold text-gray-900">Daftar Pengguna</h2>
                <div class="flex items-center gap-3">
                    <div class="relative">
                        <input type="text" placeholder="Cari pengguna..."
                            class="bg-gray-50 border border-gray-200 rounded-xl pl-9 pr-4 py-2 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-amber-400 w-44">
                        <svg class="w-4 h-4 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <select class="bg-gray-50 border border-gray-200 rounded-xl px-3 py-2 text-sm text-gray-700 focus:outline-none">
                        <option>Semua Role</option>
                        <option>Tata Usaha</option>
                        <option>Kepala Sekolah</option>
                        <option>Wakil Kepala Sekolah</option>
                        <option>Guru</option>
                    </select>
                    <button onclick="openModal()"
                        class="bg-gray-900 hover:bg-gray-700 text-white text-xs font-semibold px-4 py-2 rounded-xl transition-all flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Tambah Pengguna
                    </button>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 text-left">
                            <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Pengguna</th>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Role</th>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Terakhir Login</th>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @php
                        $users = [
                        ['nama'=>'Bambang Kariyawan', 'initial'=>'BK', 'role'=>'Tata Usaha', 'role_key'=>'super_admin', 'email'=>'bambang@sma-cendana.sch.id', 'login'=>'Hari ini, 08.15', 'aktif'=>true, 'color'=>'bg-indigo-100 text-indigo-700'],
                        ['nama'=>'Dr. Hendra Gunawan', 'initial'=>'HG', 'role'=>'Kepala Sekolah', 'role_key'=>'kepala', 'email'=>'hendra@sma-cendana.sch.id', 'login'=>'Hari ini, 07.45', 'aktif'=>true, 'color'=>'bg-blue-100 text-blue-700'],
                        ['nama'=>'Sari Permatasari', 'initial'=>'SP', 'role'=>'Wakil Kepala Sekolah', 'role_key'=>'wakil', 'email'=>'sari@sma-cendana.sch.id', 'login'=>'Kemarin, 14.30', 'aktif'=>true, 'color'=>'bg-emerald-100 text-emerald-700'],
                        ['nama'=>'Drs. Agus Santoso', 'initial'=>'AS', 'role'=>'Wakil Kepala Sekolah', 'role_key'=>'wakil', 'email'=>'agus@sma-cendana.sch.id', 'login'=>'2 hari lalu', 'aktif'=>true, 'color'=>'bg-emerald-100 text-emerald-700'],
                        ['nama'=>'Andi Susanto', 'initial'=>'AS', 'role'=>'Guru', 'role_key'=>'guru', 'email'=>'andi@sma-cendana.sch.id', 'login'=>'Hari ini, 09.00', 'aktif'=>true, 'color'=>'bg-amber-100 text-amber-700'],
                        ['nama'=>'Budi Raharjo', 'initial'=>'BR', 'role'=>'Guru', 'role_key'=>'guru', 'email'=>'budi@sma-cendana.sch.id', 'login'=>'3 hari lalu', 'aktif'=>false, 'color'=>'bg-amber-100 text-amber-700'],
                        ['nama'=>'Citra Dewi', 'initial'=>'CD', 'role'=>'Guru', 'role_key'=>'guru', 'email'=>'citra@sma-cendana.sch.id', 'login'=>'Seminggu lalu', 'aktif'=>false, 'color'=>'bg-amber-100 text-amber-700'],
                        ];
                        $roleBadge = [
                        'super_admin' => 'role-super-admin',
                        'kepala' => 'role-kepala',
                        'wakil' => 'role-wakil',
                        'guru' => 'role-guru',
                        ];
                        @endphp

                        @foreach($users as $u)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full {{ $u['color'] }} flex items-center justify-center text-xs font-bold shrink-0">{{ $u['initial'] }}</div>
                                    <span class="font-semibold text-gray-800">{{ $u['nama'] }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="role-badge {{ $roleBadge[$u['role_key']] }}">{{ $u['role'] }}</span>
                            </td>
                            <td class="px-6 py-4 text-gray-500 text-xs">{{ $u['email'] }}</td>
                            <td class="px-6 py-4 text-gray-400 text-xs">{{ $u['login'] }}</td>
                            <td class="px-6 py-4">
                                @if($u['aktif'])
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold status-active">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif
                                </span>
                                @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold status-inactive">
                                    <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span> Nonaktif
                                </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <button class="w-7 h-7 flex items-center justify-center rounded-lg hover:bg-blue-50 text-blue-500 transition-colors" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>
                                    <button class="w-7 h-7 flex items-center justify-center rounded-lg hover:bg-amber-50 text-amber-500 transition-colors" title="{{ $u['aktif'] ? 'Nonaktifkan' : 'Aktifkan' }}">
                                        @if($u['aktif'])
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                        </svg>
                                        @else
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        @endif
                                    </button>
                                    <button class="w-7 h-7 flex items-center justify-center rounded-lg hover:bg-red-50 text-red-400 transition-colors" title="Hapus">
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

            <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between">
                <p class="text-xs text-gray-500">Menampilkan 7 dari 52 pengguna</p>
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
    </div>

    {{-- ================================================================ --}}
    {{-- TAB 2: TAMPILAN --}}
    {{-- ================================================================ --}}
    <div id="panel-tampilan" class="setting-panel">

        {{-- Header --}}
        <div class="flex items-center justify-between mb-4 flex-wrap gap-3">
            <div>
                <p class="text-sm font-semibold text-gray-900">Pengaturan Tampilan</p>
                <p class="text-xs text-gray-400 mt-0.5">Kelola halaman dan preferensi per role pengguna</p>
            </div>
        </div>

        {{-- Role Tabs --}}
        <div class="flex gap-2 flex-wrap mb-5">
            <button onclick="switchRole(this,'tu')" class="role-tab px-4 py-1.5 rounded-xl text-xs font-semibold border border-gray-900 bg-gray-900 text-white transition-all">
                Tata Usaha
            </button>
            <button onclick="switchRole(this,'kepsek')" class="role-tab px-4 py-1.5 rounded-xl text-xs font-semibold border border-gray-200 bg-gray-50 text-gray-600 transition-all">
                Kepala Sekolah
            </button>
            <button onclick="switchRole(this,'wakasek')" class="role-tab px-4 py-1.5 rounded-xl text-xs font-semibold border border-gray-200 bg-gray-50 text-gray-600 transition-all">
                Wakil Kepala Sekolah
            </button>
            <button onclick="switchRole(this,'guru')" class="role-tab px-4 py-1.5 rounded-xl text-xs font-semibold border border-gray-200 bg-gray-50 text-gray-600 transition-all">
                Guru
            </button>
        </div>

        {{-- Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            {{-- Halaman yang Ditampilkan --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <div class="flex items-center justify-between mb-1">
                    <h2 class="text-base font-semibold text-gray-900">Halaman yang Ditampilkan</h2>
                    <span id="role-label" class="text-xs font-semibold text-gray-500 bg-gray-100 px-3 py-1 rounded-full">Tata Usaha</span>
                </div>
                <p class="text-xs text-gray-400 mb-5">Aktifkan atau nonaktifkan menu pada navigasi</p>

                <div id="menu-list" class="flex flex-col"></div>

                <button onclick="saveSettings()" class="mt-6 w-full bg-gray-900 hover:bg-gray-700 text-white text-sm font-semibold py-2.5 rounded-xl transition-all">
                    Simpan Pengaturan Tampilan
                </button>
            </div>

            {{-- Kanan --}}
            <div class="flex flex-col gap-6">

                {{-- Ukuran Tabel --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <h2 class="text-base font-semibold text-gray-900 mb-1">Ukuran Tabel</h2>
                    <p class="text-xs text-gray-400 mb-4">Jumlah baris per halaman pada tabel data untuk seluruh role pengguna</p>
                    <div class="flex items-center gap-2 flex-wrap">
                        @foreach([10, 25, 50, 100] as $n)
                        <button onclick="setPaginasi(this)"
                            class="pag-btn px-4 py-2 rounded-xl text-sm font-semibold border border-gray-200 {{ $n == 25 ? 'bg-gray-900 text-white border-gray-900' : 'bg-gray-50 text-gray-600 hover:bg-gray-100' }} transition-all">
                            {{ $n }}
                        </button>
                        @endforeach
                    </div>
                </div>

                {{-- Ringkasan Akses --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <h2 class="text-base font-semibold text-gray-900 mb-1">Ringkasan Akses</h2>
                    <p class="text-xs text-gray-400 mb-4">Halaman aktif untuk role ini</p>
                    <div id="summary-list" class="flex flex-col gap-2"></div>
                </div>

            </div>
        </div>
    </div>

    {{-- ================================================================ --}}
    {{-- TAB 3: KEAMANAN --}}
    {{-- ================================================================ --}}
    <div id="panel-keamanan" class="setting-panel">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">

                {{-- Profil (read-only) --}}
                <div class="flex items-center gap-4 mb-6 pb-6 border-b border-gray-100">
                    <div class="w-12 h-12 rounded-full bg-amber-100 flex items-center justify-center text-amber-700 font-bold text-sm border border-amber-200 shrink-0">
                        BK
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-900">{{ auth()->user()->name ?? 'Bambang Kariyawan' }}</p>
                        <p class="text-xs text-gray-400 mt-0.5">Tata Usaha</p>
                    </div>
                    <span class="ml-auto text-xs text-gray-400 bg-gray-100 px-3 py-1 rounded-full font-medium">Akun Anda</span>
                </div>

                {{-- Form --}}
                <h2 class="text-base font-semibold text-gray-900 mb-1">Ubah Password</h2>
                <p class="text-xs text-gray-400 mb-5">Perbarui kata sandi akun Anda</p>

                <div class="flex flex-col gap-4">

                    {{-- Password Lama --}}
                    <div>
                        <label class="form-label">Password Lama</label>
                        <div class="relative">
                            <input type="password" id="pw-lama" class="form-input pr-10" placeholder="••••••••">
                            <button type="button" onclick="togglePw('pw-lama', 'eye-lama')"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors">
                                <svg id="eye-lama" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Password Baru --}}
                    <div>
                        <label class="form-label">Password Baru</label>
                        <div class="relative">
                            <input type="password" id="pw-baru" class="form-input pr-10" placeholder="••••••••">
                            <button type="button" onclick="togglePw('pw-baru', 'eye-baru')"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors">
                                <svg id="eye-baru" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Konfirmasi Password Baru --}}
                    <div>
                        <label class="form-label">Konfirmasi Password Baru</label>
                        <div class="relative">
                            <input type="password" id="pw-konfirm" class="form-input pr-10" placeholder="••••••••">
                            <button type="button" onclick="togglePw('pw-konfirm', 'eye-konfirm')"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors">
                                <svg id="eye-konfirm" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <button class="w-full bg-gray-900 hover:bg-gray-700 text-white text-sm font-semibold py-2.5 rounded-xl transition-all mt-1">
                        Perbarui Password
                    </button>

                </div>
            </div>

            <div class="flex flex-col gap-6">
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <h2 class="text-base font-semibold text-gray-900 mb-1">Keamanan Sesi</h2>
                    <p class="text-xs text-gray-400 mb-5">Pengaturan sesi dan akses login</p>
                    @php
                    $sesi = [
                    ['nama'=>'Paksa Logout', 'desc'=>'Logout paksa disemua perangkat (kecuali perangkat sekarang)', 'aktif'=>true],
                    ['nama'=>'Log Aktivitas Login', 'desc'=>'Catat semua riwayat login pengguna', 'aktif'=>true],
                    ];
                    @endphp
                    <div class="flex flex-col gap-4">
                        @foreach($sesi as $s)
                        <div class="flex items-center justify-between py-3 border-b border-gray-50 last:border-0">
                            <div>
                                <p class="text-sm font-semibold text-gray-800">{{ $s['nama'] }}</p>
                                <p class="text-xs text-gray-400 mt-0.5">{{ $s['desc'] }}</p>
                            </div>
                            <label class="toggle-wrap">
                                <input type="checkbox" {{ $s['aktif'] ? 'checked' : '' }}>
                                <div class="toggle-track">
                                    <div class="toggle-thumb"></div>
                                </div>
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <h2 class="text-base font-semibold text-gray-900 mb-1">Sesi Aktif</h2>
                    <p class="text-xs text-gray-400 mb-4">Perangkat yang sedang login</p>
                    <div class="flex flex-col gap-3">
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                <div>
                                    <p class="text-xs font-semibold text-gray-700">Chrome · Windows</p>
                                    <p class="text-xs text-gray-400">Pekanbaru · Aktif sekarang</p>
                                </div>
                            </div>
                            <span class="text-xs text-emerald-600 font-semibold bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-100">Ini Anda</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                                <div>
                                    <p class="text-xs font-semibold text-gray-700">Safari · iPhone</p>
                                    <p class="text-xs text-gray-400">Pekanbaru · 2 jam lalu</p>
                                </div>
                            </div>
                            <button class="text-xs text-red-500 font-semibold hover:underline">Akhiri</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ================================================================ --}}
    {{-- TAB 4: INFO SEKOLAH --}}
    {{-- ================================================================ --}}
    <div id="panel-sekolah" class="setting-panel">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 lg:p-8">

            {{-- Header --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-8">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">
                        Informasi Sekolah
                    </h2>
                    <p class="text-sm text-gray-400 mt-1">
                        Data identitas sekolah dan logo utama sistem
                    </p>
                </div>

                <div class="hidden sm:flex items-center gap-2 text-xs text-gray-400">
                    <div class="w-2 h-2 rounded-full bg-emerald-400"></div>
                    Sistem aktif
                </div>
            </div>

            {{-- Content --}}
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">

                {{-- Left Form --}}
                <div class="xl:col-span-2 space-y-6">

                    {{-- Nama Sekolah --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Sekolah
                        </label>

                        <input
                            type="text"
                            class="w-full rounded-xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-transparent transition-all"
                            value="SMA Cendana Pekanbaru">
                    </div>



                </div>

                {{-- Right Logo Card --}}
                <div>
                    <div class="border border-gray-100 rounded-2xl bg-gray-50/70 p-5 h-full">

                        <div class="mb-5">
                            <h3 class="text-sm font-semibold text-gray-800">
                                Logo Sekolah
                            </h3>

                            <p class="text-xs text-gray-400 mt-1 leading-relaxed">
                                Logo akan tampil pada navbar, halaman login, dan laporan sistem.
                            </p>
                        </div>

                        {{-- Logo Preview --}}
                        <div class="flex flex-col items-center text-center">

                            <div class="w-28 h-28 rounded-2xl bg-white border border-dashed border-gray-300 flex items-center justify-center shadow-sm overflow-hidden mb-4">
                                <img
                                    src="{{ asset('img/logo.png') }}"
                                    class="w-20 h-20 object-contain"
                                    onerror="this.style.display='none'">
                            </div>

                            <button
                                type="button"
                                class="bg-gray-900 hover:bg-gray-700 text-white text-sm font-medium px-5 py-2.5 rounded-xl transition-all">
                                Unggah Logo
                            </button>

                            <p class="text-xs text-gray-400 mt-3">
                                PNG, JPG, SVG · Maks 2MB
                            </p>

                        </div>

                    </div>
                </div>

            </div>

            {{-- Footer Action --}}
            <div class="mt-8 pt-6 border-t border-gray-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

                <p class="text-xs text-gray-400">
                    Perubahan akan langsung diterapkan ke seluruh sistem.
                </p>

                <div class="flex items-center gap-3">

                    <button
                        type="button"
                        class="px-5 py-2.5 rounded-xl border border-gray-200 text-sm font-medium text-gray-600 hover:bg-gray-50 transition-all">
                        Reset
                    </button>

                    <button
                        type="button"
                        class="bg-gray-900 hover:bg-gray-700 text-white text-sm font-semibold px-6 py-2.5 rounded-xl transition-all shadow-sm">
                        Simpan Perubahan
                    </button>

                </div>

            </div>

        </div>
    </div>

    {{-- ===== MODAL: TAMBAH PENGGUNA ===== --}}
    <div id="modal-overlay" onclick="closeModal(event)">
        <div id="modal-box">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-base font-bold text-gray-900">Tambah Pengguna Baru</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Isi data pengguna yang akan ditambahkan</p>
                </div>
                <button onclick="closeModal()" class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-gray-100 text-gray-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="flex flex-col gap-4">
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-input" placeholder="Nama pengguna">
                    </div>
                    <div>
                        <label class="form-label">Username</label>
                        <input type="text" class="form-input" placeholder="username">
                    </div>
                </div>
                <div>
                    <label class="form-label">Email</label>
                    <input type="email" class="form-input" placeholder="email@sma-cendana.sch.id">
                </div>
                <div>
                    <label class="form-label">Role</label>
                    <select class="form-input">
                        <option value="">Pilih Role</option>
                        <option>Tata Usaha</option>
                        <option>Kepala Sekolah</option>
                        <option>Wakil Kepala Sekolah</option>
                        <option>Guru</option>
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="form-label">Password</label>
                        <input type="password" class="form-input" placeholder="••••••••">
                    </div>
                    <div>
                        <label class="form-label">Konfirmasi Password</label>
                        <input type="password" class="form-input" placeholder="••••••••">
                    </div>
                </div>
                <div class="flex items-center justify-between py-2">
                    <div>
                        <p class="text-sm font-semibold text-gray-800">Status Aktif</p>
                        <p class="text-xs text-gray-400">Pengguna dapat login langsung</p>
                    </div>
                    <label class="toggle-wrap">
                        <input type="checkbox" checked>
                        <div class="toggle-track">
                            <div class="toggle-thumb"></div>
                        </div>
                    </label>
                </div>
            </div>

            <div class="flex items-center gap-3 mt-6">
                <button onclick="closeModal()" class="flex-1 border border-gray-200 text-gray-600 text-sm font-semibold py-2.5 rounded-xl hover:bg-gray-50 transition-all">
                    Batal
                </button>
                <button class="flex-1 bg-gray-900 hover:bg-gray-700 text-white text-sm font-semibold py-2.5 rounded-xl transition-all">
                    Simpan Pengguna
                </button>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // ---- Setting Tabs ----
        function switchTab(tab, btn) {
            document.querySelectorAll('.setting-panel').forEach(p => p.classList.remove('active'));
            document.querySelectorAll('.setting-tab').forEach(t => t.classList.remove('active'));
            document.getElementById('panel-' + tab).classList.add('active');
            btn.classList.add('active');
        }

        // ---- Modal ----
        function openModal() {
            document.getElementById('modal-overlay').classList.add('open');
        }

        function closeModal(e) {
            if (!e || e.target === document.getElementById('modal-overlay')) {
                document.getElementById('modal-overlay').classList.remove('open');
            }
        }

        // ---- Paginasi selector ----
        function setPaginasi(btn) {
            btn.closest('div').querySelectorAll('button').forEach(b => {
                b.className = 'px-4 py-2 rounded-xl text-sm font-semibold border border-gray-200 bg-gray-50 text-gray-600 hover:bg-gray-100 transition-all';
            });
            btn.className = 'px-4 py-2 rounded-xl text-sm font-semibold border border-gray-900 bg-gray-900 text-white transition-all';
        }

        // ---- Semester selector ----
        function setSemester(btn) {
            btn.closest('div').querySelectorAll('button').forEach(b => {
                b.className = 'flex-1 py-2 rounded-xl text-sm font-semibold border border-gray-200 bg-gray-50 text-gray-600 hover:bg-gray-100 transition-all';
            });
            btn.className = 'flex-1 py-2 rounded-xl text-sm font-semibold border border-gray-900 bg-gray-900 text-white transition-all';
        }

        // ---- Role Menu Tampilan ----
        const roleMenus = {
            tu: [{
                    nama: 'Dashboard',
                    desc: 'Halaman ringkasan kinerja utama',
                    aktif: true
                },
                {
                    nama: 'Jam Mengajar',
                    desc: 'Rekap jam mengajar per guru',
                    aktif: true
                },
                {
                    nama: 'Kehadiran Guru',
                    desc: 'Monitoring absensi harian guru',
                    aktif: true
                },
                {
                    nama: 'Laporan',
                    desc: 'Unduh laporan kinerja & kehadiran',
                    aktif: true
                },
            ],
            kepsek: [{
                    nama: 'Dashboard',
                    desc: 'Halaman ringkasan kinerja utama',
                    aktif: true
                },
                {
                    nama: 'Jam Mengajar',
                    desc: 'Rekap jam mengajar per guru',
                    aktif: true
                },
                {
                    nama: 'Kehadiran Guru',
                    desc: 'Monitoring absensi harian guru',
                    aktif: true
                },
                {
                    nama: 'Laporan',
                    desc: 'Unduh laporan kinerja & kehadiran',
                    aktif: true
                },
            ],
            wakasek: [{
                    nama: 'Dashboard',
                    desc: 'Halaman ringkasan kinerja utama',
                    aktif: true
                },
                {
                    nama: 'Jam Mengajar',
                    desc: 'Rekap jam mengajar per guru',
                    aktif: true
                },
                {
                    nama: 'Kehadiran Guru',
                    desc: 'Monitoring absensi harian guru',
                    aktif: true
                },
                {
                    nama: 'Laporan',
                    desc: 'Unduh laporan kinerja & kehadiran',
                    aktif: false
                },
            ],
            guru: [{
                    nama: 'Dashboard',
                    desc: 'Halaman ringkasan kinerja utama',
                    aktif: true
                },
                {
                    nama: 'Jam Mengajar',
                    desc: 'Rekap jam mengajar per guru',
                    aktif: true
                },
                {
                    nama: 'Kehadiran Guru',
                    desc: 'Monitoring absensi harian guru',
                    aktif: false
                },
                {
                    nama: 'Laporan',
                    desc: 'Unduh laporan kinerja & kehadiran',
                    aktif: false
                },
            ],
        };

        const roleLabels = {
            tu: 'Tata Usaha',
            kepsek: 'Kepala Sekolah',
            wakasek: 'Wakil Kepala Sekolah',
            guru: 'Guru'
        };

        let states = {};
        Object.keys(roleMenus).forEach(r => {
            states[r] = roleMenus[r].map(m => m.aktif);
        });

        let currentRole = 'tu';

        function renderMenus(role) {
            const list = document.getElementById('menu-list');
            if (!list) return;
            list.innerHTML = '';
            roleMenus[role].forEach((m, i) => {
                const id = `toggle-${role}-${i}`;
                const row = document.createElement('div');
                row.className = 'flex items-center justify-between py-3 border-b border-gray-50 last:border-0';
                row.innerHTML = `
            <div>
                <p class="text-sm font-semibold text-gray-800">${m.nama}</p>
                <p class="text-xs text-gray-400 mt-0.5">${m.desc}</p>
            </div>
            <label class="toggle-wrap">
                <input type="checkbox" id="${id}" ${states[role][i] ? 'checked' : ''} onchange="updateState(${i})">
                <div class="toggle-track"><div class="toggle-thumb"></div></div>
            </label>`;
                list.appendChild(row);
            });
            updateSummary(role);
        }

        function updateState(idx) {
            const chk = document.getElementById(`toggle-${currentRole}-${idx}`);
            states[currentRole][idx] = chk.checked;
            updateSummary(currentRole);
        }

        function updateSummary(role) {
            const el = document.getElementById('summary-list');
            if (!el) return;
            el.innerHTML = '';
            roleMenus[role].forEach((m, i) => {
                const aktif = states[role][i];
                const row = document.createElement('div');
                row.className = `flex items-center gap-2 text-xs ${aktif ? 'text-gray-700' : 'text-gray-300'}`;
                row.innerHTML = `
            <svg class="w-3.5 h-3.5 shrink-0 ${aktif ? 'text-emerald-500' : 'text-gray-300'}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                ${aktif
                    ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>'
                    : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>'}
            </svg>
            ${m.nama}`;
                el.appendChild(row);
            });
        }

        function switchRole(btn, role) {
            document.querySelectorAll('.role-tab').forEach(b => {
                b.classList.remove('bg-gray-900', 'text-white', 'border-gray-900');
                b.classList.add('bg-gray-50', 'text-gray-600', 'border-gray-200');
            });
            btn.classList.add('bg-gray-900', 'text-white', 'border-gray-900');
            btn.classList.remove('bg-gray-50', 'text-gray-600', 'border-gray-200');
            currentRole = role;
            document.getElementById('role-label').textContent = roleLabels[role];
            renderMenus(role);
        }

        function saveSettings() {
            const btn = document.querySelector('[onclick="saveSettings()"]');
            const original = btn.textContent;
            btn.textContent = 'Tersimpan ✓';
            btn.disabled = true;
            setTimeout(() => {
                btn.textContent = original;
                btn.disabled = false;
            }, 2000);
            // axios.post('/settings/tampilan', { role: currentRole, menus: states[currentRole] });
        }

        // Init saat halaman load
        renderMenus('tu');

        // ---- Toggle show/hide password ----
        function togglePw(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            const isHidden = input.type === 'password';

            input.type = isHidden ? 'text' : 'password';

            // Ganti icon: mata terbuka ↔ mata tercoret
            icon.innerHTML = isHidden ?
                `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7
                        a9.956 9.956 0 012.293-3.95M6.32 6.32A9.956 9.956 0 0112 5
                        c4.478 0 8.268 2.943 9.542 7a9.965 9.965 0 01-4.198 5.542
                        M3 3l18 18"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 3l18 18"/>` :
                `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7
                        -1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>`;
        }
    </script>
    @endpush

</x-app>