{{-- ===== NAVBAR PARTIAL ===== --}}
{{-- resources/views/partials/navbar.blade.php --}}

<nav class="bg-white border-b border-gray-200 px-4 py-0 flex items-center justify-between fixed top-0 left-0 right-0 z-30 h-14">
    <div class="flex items-center gap-3">
        {{-- Hamburger --}}
        <button id="sidebarToggle"
            class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-gray-100 transition-colors"
            aria-label="Toggle sidebar">
            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
        {{-- Logo + School name --}}
        <div class="flex items-center gap-2.5">
            <img src="{{ asset('img/logo.png') }}" class="h-8 w-8 object-contain" alt="Logo SMA Cendana">
            <span class="font-bold text-gray-800 text-sm tracking-tight hidden sm:block">SMA CENDANA PEKANBARU</span>
        </div>
    </div>

    <div class="flex items-center gap-2">
        <div class="flex items-center gap-2 cursor-pointer group pl-1 pr-3">
            {{-- Avatar --}}
            <div class="w-9 h-9 rounded-full bg-amber-100 flex items-center justify-center text-amber-700 font-bold text-xs border border-amber-200">
                {{ strtoupper(substr(auth()->user()->name ?? 'Bambang', 0, 1)) }}{{ strtoupper(substr(strstr(auth()->user()->name ?? 'Bambang Kariyawan', ' '), 1, 1)) }}
            </div>
            {{-- User Info --}}
            <div class="hidden sm:flex flex-col leading-tight">
                <span class="text-sm font-medium text-gray-700 group-hover:text-gray-900 transition-colors">
                    {{ auth()->user()->name ?? 'Bambang Kariyawan' }}
                </span>
                <span class="text-xs text-gray-400">
                    {{ auth()->user()->role ?? 'Tata Usaha' }}
                </span>
            </div>
        </div>
    </div>
</nav>