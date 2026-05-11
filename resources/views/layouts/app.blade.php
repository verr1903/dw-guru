<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SMA Cendana Pekanbaru')</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=DM+Serif+Display:ital@0;1&display=swap" rel="stylesheet">

    {{-- Vite / Tailwind --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --green-primary: #1a6b3a;
            --green-accent:  #22c55e;
            --gold:          #c9a84c;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .font-display {
            font-family: 'DM Serif Display', serif;
        }

        /* Sidebar active state */
        .nav-link.active {
            @apply bg-green-700 text-white;
        }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #94a3b8; border-radius: 9999px; }
    </style>

    @stack('styles')
</head>
<body class="h-full bg-slate-100 text-slate-800 antialiased">

{{-- ============================================================
     SHELL: Sidebar + Top Bar + Content
     ============================================================ --}}
<div class="flex h-full min-h-screen">

    {{-- ── SIDEBAR ── --}}
    <aside id="sidebar"
           class="fixed inset-y-0 left-0 z-30 flex w-64 flex-col bg-[#1a6b3a] shadow-xl
                  transition-transform duration-300 -translate-x-full lg:translate-x-0 lg:static lg:inset-auto">

        {{-- Logo --}}
        <div class="flex items-center gap-3 px-6 py-5 border-b border-green-700">
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/10 ring-1 ring-white/20">
                {{-- Ganti dengan <img src="{{ asset('img/logo.png') }}" alt="Logo"> --}}
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                     class="h-6 w-6 text-amber-300">
                    <path d="M11.7 2.805a.75.75 0 0 1 .6 0A60.65 60.65 0 0 1 22.83 8.72a.75.75 0 0
                             0-.231 1.337 49.948 49.948 0 0 0-9.902 5.73 52.517 52.517 0 0 0-6.83-5.073c-.32.214-.641.43-.961.647
                             a.75.75 0 0 0 .231-1.337A60.653 60.653 0 0 1 11.7 2.805Z"/>
                    <path d="M13.06 15.473a48.45 48.45 0 0 1 7.666-3.282c.134 1.414.22 2.843.255
                             4.284a.75.75 0 0 1-.46.711 47.87 47.87 0 0 0-8.105 4.342.75.75 0 0
                             1-.832 0 47.87 47.87 0 0 0-8.104-4.342.75.75 0 0 1-.461-.71c.035-1.442.121-2.87.255-4.286L13.06
                             15.473Zm-5.16-5.16a48.956 48.956 0 0 0-3.585 1.497A48.96 48.96 0 0 0 3 21.91V22a.75.75 0 0
                             0 1.5 0v-.09a47.456 47.456 0 0 1 1.316-9.697l1.085-2.9Z"/>
                </svg>
            </div>
            <div class="leading-tight">
                <p class="text-xs font-semibold uppercase tracking-widest text-green-300">SMA</p>
                <p class="font-display text-lg leading-none text-white">Cendana</p>
            </div>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-0.5">

            {{-- Section label --}}
            <p class="mb-1 px-3 text-[10px] font-semibold uppercase tracking-widest text-green-400">Menu Utama</p>

            <a href="{{ route('dashboard') }}"
               class="nav-link group flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium
                      text-green-100 hover:bg-green-700 hover:text-white transition-colors
                      {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5 shrink-0 opacity-70 group-hover:opacity-100">
                    <path fill-rule="evenodd" d="M9.293 2.293a1 1 0 0 1 1.414 0l7 7A1 1 0 0 1 17 11h-1v6a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1v-3a1 1 0 0 0-1-1H9a1 1 0 0 0-1 1v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-6H3a1 1 0 0 1-.707-1.707l7-7Z" clip-rule="evenodd"/>
                </svg>
                Dashboard
            </a>

            <a href="#"
               class="nav-link group flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium
                      text-green-100 hover:bg-green-700 hover:text-white transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5 shrink-0 opacity-70 group-hover:opacity-100">
                    <path d="M10 9a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM6 8a2 2 0 1 1-4 0 2 2 0 0 1 4 0ZM1.49 15.326a.78.78 0 0 1-.358-.442 3 3 0 0 1 4.308-3.516 6.484 6.484 0 0 0-1.905 3.959c-.023.222-.014.442.025.654a4.97 4.97 0 0 1-2.07-.655ZM16.44 15.98a4.97 4.97 0 0 0 2.07-.654.78.78 0 0 0 .357-.442 3 3 0 0 0-4.308-3.517 6.484 6.484 0 0 1 1.907 3.96 2.32 2.32 0 0 1-.026.654ZM18 8a2 2 0 1 1-4 0 2 2 0 0 1 4 0ZM5.304 16.19a.844.844 0 0 1-.277-.71 5 5 0 0 1 9.947 0 .843.843 0 0 1-.277.71A6.975 6.975 0 0 1 10 18a6.974 6.974 0 0 1-4.696-1.81Z"/>
                </svg>
                Data Siswa
            </a>

            <a href="#"
               class="nav-link group flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium
                      text-green-100 hover:bg-green-700 hover:text-white transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5 shrink-0 opacity-70 group-hover:opacity-100">
                    <path d="M5.25 12a.75.75 0 0 1 .75-.75h.01a.75.75 0 0 1 .75.75v.01a.75.75 0 0 1-.75.75H6a.75.75 0 0 1-.75-.75V12ZM6 13.25a.75.75 0 0 0-.75.75v.01c0 .414.336.75.75.75h.01a.75.75 0 0 0 .75-.75V14a.75.75 0 0 0-.75-.75H6ZM7.25 12a.75.75 0 0 1 .75-.75h.01a.75.75 0 0 1 .75.75v.01a.75.75 0 0 1-.75.75H8a.75.75 0 0 1-.75-.75V12ZM8 13.25a.75.75 0 0 0-.75.75v.01c0 .414.336.75.75.75h.01a.75.75 0 0 0 .75-.75V14a.75.75 0 0 0-.75-.75H8ZM9.25 10a.75.75 0 0 1 .75-.75h.01a.75.75 0 0 1 .75.75v.01a.75.75 0 0 1-.75.75H10a.75.75 0 0 1-.75-.75V10ZM10 11.25a.75.75 0 0 0-.75.75v.01c0 .414.336.75.75.75h.01a.75.75 0 0 0 .75-.75V12a.75.75 0 0 0-.75-.75H10ZM9.25 14a.75.75 0 0 1 .75-.75h.01a.75.75 0 0 1 .75.75v.01a.75.75 0 0 1-.75.75H10a.75.75 0 0 1-.75-.75V14ZM12 9.25a.75.75 0 0 0-.75.75v.01c0 .414.336.75.75.75h.01a.75.75 0 0 0 .75-.75V10a.75.75 0 0 0-.75-.75H12ZM11.25 12a.75.75 0 0 1 .75-.75h.01a.75.75 0 0 1 .75.75v.01a.75.75 0 0 1-.75.75H12a.75.75 0 0 1-.75-.75V12ZM12 13.25a.75.75 0 0 0-.75.75v.01c0 .414.336.75.75.75h.01a.75.75 0 0 0 .75-.75V14a.75.75 0 0 0-.75-.75H12Z"/>
                    <path fill-rule="evenodd" d="M6.75 2.25A.75.75 0 0 1 7.5 3v1.5h9V3A.75.75 0 0 1 18 3v1.5h.75a3 3 0 0 1 3 3v11.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V7.5a3 3 0 0 1 3-3H6V3a.75.75 0 0 1 .75-.75Zm13.5 9a1.5 1.5 0 0 0-1.5-1.5H5.25a1.5 1.5 0 0 0-1.5 1.5v7.5a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5v-7.5Z" clip-rule="evenodd"/>
                </svg>
                Jadwal
            </a>

            <a href="#"
               class="nav-link group flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium
                      text-green-100 hover:bg-green-700 hover:text-white transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5 shrink-0 opacity-70 group-hover:opacity-100">
                    <path fill-rule="evenodd" d="M4 4a2 2 0 0 0-2 2v4.586A2 2 0 0 0 2.586 12L7 16.414A2 2 0 0 0 8.414 17H14a2 2 0 0 0 2-2v-5.586A2 2 0 0 0 15.414 8L11 3.586A2 2 0 0 0 9.586 3H6a2 2 0 0 0-2-2v3Zm8 0a1 1 0 1 0-2 0 1 1 0 0 0 2 0Zm-4 0a1 1 0 1 0-2 0 1 1 0 0 0 2 0Z" clip-rule="evenodd"/>
                </svg>
                Nilai
            </a>

            <p class="mt-4 mb-1 px-3 text-[10px] font-semibold uppercase tracking-widest text-green-400">Administrasi</p>

            <a href="#"
               class="nav-link group flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium
                      text-green-100 hover:bg-green-700 hover:text-white transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5 shrink-0 opacity-70 group-hover:opacity-100">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-5.5-2.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0ZM10 12a5.99 5.99 0 0 0-4.793 2.39A6.483 6.483 0 0 0 10 16.5a6.483 6.483 0 0 0 4.793-2.11A5.99 5.99 0 0 0 10 12Z" clip-rule="evenodd"/>
                </svg>
                Pengguna
            </a>

            <a href="#"
               class="nav-link group flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium
                      text-green-100 hover:bg-green-700 hover:text-white transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5 shrink-0 opacity-70 group-hover:opacity-100">
                    <path fill-rule="evenodd" d="M7.84 1.804A1 1 0 0 1 8.82 1h2.36a1 1 0 0 1 .98.804l.331 1.652a6.993 6.993 0 0 1 1.929 1.115l1.598-.54a1 1 0 0 1 1.186.447l1.18 2.044a1 1 0 0 1-.205 1.251l-1.267 1.113a7.047 7.047 0 0 1 0 2.228l1.267 1.113a1 1 0 0 1 .206 1.25l-1.18 2.045a1 1 0 0 1-1.187.447l-1.598-.54a6.993 6.993 0 0 1-1.929 1.115l-.33 1.652a1 1 0 0 1-.98.804H8.82a1 1 0 0 1-.98-.804l-.331-1.652a6.993 6.993 0 0 1-1.929-1.115l-1.598.54a1 1 0 0 1-1.186-.447l-1.18-2.044a1 1 0 0 1 .205-1.251l1.267-1.114a7.05 7.05 0 0 1 0-2.227L1.821 7.773a1 1 0 0 1-.206-1.25l1.18-2.045a1 1 0 0 1 1.187-.447l1.598.54A6.992 6.992 0 0 1 7.51 3.456l.33-1.652ZM10 13a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" clip-rule="evenodd"/>
                </svg>
                Pengaturan
            </a>
        </nav>

        {{-- User Card --}}
        <div class="border-t border-green-700 p-4">
            <div class="flex items-center gap-3">
                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-amber-400 text-sm font-bold text-green-900">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </div>
                <div class="min-w-0 flex-1">
                    <p class="truncate text-sm font-semibold text-white">{{ auth()->user()->name ?? 'Admin' }}</p>
                    <p class="truncate text-xs text-green-300">{{ auth()->user()->role ?? 'Administrator' }}</p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" title="Keluar"
                            class="rounded-lg p-1.5 text-green-300 hover:bg-green-700 hover:text-white transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                            <path fill-rule="evenodd" d="M3 4.25A2.25 2.25 0 0 1 5.25 2h5.5A2.25 2.25 0 0 1 13 4.25v2a.75.75 0 0 1-1.5 0v-2a.75.75 0 0 0-.75-.75h-5.5a.75.75 0 0 0-.75.75v11.5c0 .414.336.75.75.75h5.5a.75.75 0 0 0 .75-.75v-2a.75.75 0 0 1 1.5 0v2A2.25 2.25 0 0 1 10.75 18h-5.5A2.25 2.25 0 0 1 3 15.75V4.25Z" clip-rule="evenodd"/>
                            <path fill-rule="evenodd" d="M19 10a.75.75 0 0 0-.75-.75H8.704l1.048-1.08a.75.75 0 1 0-1.04-1.08l-2.5 2.57a.75.75 0 0 0 0 1.08l2.5 2.57a.75.75 0 1 0 1.04-1.08l-1.047-1.08H18.25A.75.75 0 0 0 19 10Z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    {{-- ── MAIN AREA ── --}}
    <div class="flex flex-1 flex-col min-w-0">

        {{-- Top Bar --}}
        <header class="sticky top-0 z-20 flex h-16 items-center gap-4 border-b border-slate-200
                        bg-white/80 px-4 backdrop-blur-sm sm:px-6">

            {{-- Mobile sidebar toggle --}}
            <button id="sidebarToggle"
                    class="flex h-9 w-9 items-center justify-center rounded-lg text-slate-500 hover:bg-slate-100 lg:hidden">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                </svg>
            </button>

            {{-- Breadcrumb / Page title --}}
            <div class="flex-1">
                <h1 class="text-base font-semibold text-slate-800">@yield('page-title', 'Dashboard')</h1>
                <p class="text-xs text-slate-400">@yield('page-subtitle', 'SMA Cendana Pekanbaru')</p>
            </div>

            {{-- Right actions --}}
            <div class="flex items-center gap-2">
                {{-- Notification --}}
                <button class="relative flex h-9 w-9 items-center justify-center rounded-lg text-slate-500 hover:bg-slate-100">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                        <path fill-rule="evenodd" d="M4 8a6 6 0 1 1 12 0c0 1.887.454 3.665 1.257 5.234a.75.75 0 0 1-.515 1.076 32.91 32.91 0 0 1-3.256.508 3.5 3.5 0 0 1-6.972 0 32.903 32.903 0 0 1-3.256-.508.75.75 0 0 1-.515-1.076A11.448 11.448 0 0 0 4 8Zm6 7c-.655 0-1.305-.02-1.95-.057a2 2 0 0 0 3.9 0c-.645.038-1.295.057-1.95.057Z" clip-rule="evenodd"/>
                    </svg>
                    <span class="absolute right-1.5 top-1.5 h-2 w-2 rounded-full bg-red-500 ring-2 ring-white"></span>
                </button>

                {{-- Avatar --}}
                <div class="flex h-9 w-9 items-center justify-center rounded-full bg-green-700 text-sm font-bold text-white">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </div>
            </div>
        </header>

        {{-- Page Content --}}
        <main class="flex-1 overflow-y-auto p-4 sm:p-6">
            @yield('content')
        </main>

        {{-- Footer --}}
        <footer class="border-t border-slate-200 bg-white px-6 py-3">
            <p class="text-xs text-slate-400">
                &copy; {{ date('Y') }} SMA Cendana Pekanbaru. Hak cipta dilindungi.
                <span class="mx-2 text-slate-300">|</span>
                <a href="#" class="hover:text-slate-600">Ketentuan Layanan</a>
                <span class="mx-2 text-slate-300">|</span>
                <a href="#" class="hover:text-slate-600">Kebijakan Privasi</a>
                <span class="ml-4 float-right">v1.0.0</span>
            </p>
        </footer>
    </div>
</div>

{{-- Sidebar overlay (mobile) --}}
<div id="sidebarOverlay"
     class="fixed inset-0 z-20 bg-black/40 backdrop-blur-sm hidden lg:hidden"></div>

<script>
    const sidebar  = document.getElementById('sidebar');
    const overlay  = document.getElementById('sidebarOverlay');
    const toggle   = document.getElementById('sidebarToggle');

    function openSidebar() {
        sidebar.classList.remove('-translate-x-full');
        overlay.classList.remove('hidden');
    }
    function closeSidebar() {
        sidebar.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
    }

    toggle?.addEventListener('click', openSidebar);
    overlay?.addEventListener('click', closeSidebar);
</script>

@stack('scripts')
</body>
</html>