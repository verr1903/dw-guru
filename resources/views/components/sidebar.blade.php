{{-- ===== SIDEBAR PARTIAL ===== --}}
{{-- resources/views/partials/sidebar.blade.php --}}

<aside id="sidebar"
    class="bg-white border-r border-gray-100 shadow-sm flex flex-col py-4 px-2 fixed left-0 top-14 bottom-0 z-20">

    <nav class="flex flex-col gap-0.5 flex-1 overflow-hidden">

        <p class="sidebar-section-label text-xs font-semibold text-gray-400 uppercase tracking-widest px-3 mb-1 mt-1">
            Menu Utama
        </p>

        <a href="{{ route('dashboard') }}"
            class="my-1 nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}"
            data-tooltip="Dashboard">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            <span class="nav-label">Dashboard</span>
        </a>

        <a href="{{ route('jam-mengajar') }}"
            class="my-1 nav-item {{ request()->routeIs('jam-mengajar') ? 'active' : '' }}"
            data-tooltip="Jam Mengajar">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="nav-label">Jam Mengajar</span>
        </a>

        <a href="{{ route('kehadiran-guru') }}"
            class="my-1 nav-item {{ request()->routeIs('kehadiran-guru') ? 'active' : '' }}"
            data-tooltip="Kehadiran Guru">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            <span class="nav-label">Kehadiran Guru</span>
        </a>

        <a href="{{ route('laporan') }}"
            class="my-1 nav-item {{ request()->routeIs('laporan') ? 'active' : '' }}"
            data-tooltip="Laporan">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <span class="nav-label">Laporan</span>
        </a>

        <div class="border-t border-gray-100 my-2 mx-1"></div>

        <p class="sidebar-section-label text-xs font-semibold text-gray-400 uppercase tracking-widest px-3 mb-1">
            Sistem
        </p>

        <a href="{{ route('pengaturan') }}"
            class="my-1 nav-item {{ request()->routeIs('pengaturan') ? 'active' : '' }}"
            data-tooltip="Pengaturan">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            <span class="nav-label">Pengaturan</span>
        </a>
    </nav>

    {{-- Logout at bottom --}}
    <div class="border-t border-gray-100 pt-2 mt-2">
        <a href="#" class="nav-item danger" data-tooltip="Keluar"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
            </svg>
            <span class="nav-label">Keluar</span>
        </a>
        <form id="logout-form" action="" method="POST" class="hidden">
            @csrf
        </form>
    </div>
</aside>