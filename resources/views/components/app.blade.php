<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'SMA Cendana Pekanbaru' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
</head>

<body class="bg-gray-50 min-h-screen flex flex-col">

    {{-- ===== TOP NAVBAR ===== --}}
    <x-navbar />

    {{-- ===== BODY BELOW NAVBAR ===== --}}
    <div class="flex flex-1 pt-14">

        {{-- ===== SIDEBAR ===== --}}
        <x-sidebar />

        {{-- ===== MAIN CONTENT ===== --}}
        <div id="main-wrapper" class="flex-1 min-w-0" style="margin-left: 240px;">
            <main class="max-w-7xl mx-auto px-6 py-3">
                {{ $slot }}
            </main>
        </div>

    </div>

    <script>
        // ---- Sidebar toggle dengan localStorage ----
        const sidebar = document.getElementById('sidebar');
        const mainWrapper = document.getElementById('main-wrapper');
        const toggleBtn = document.getElementById('sidebarToggle');

        // Baca state dari localStorage saat halaman load
        function applySidebarState() {
            const isCollapsed = localStorage.getItem('sidebar_collapsed') === 'true';
            if (isCollapsed) {
                sidebar.classList.add('collapsed');
                mainWrapper.style.marginLeft = '68px';
            } else {
                sidebar.classList.remove('collapsed');
                mainWrapper.style.marginLeft = '240px';
            }
        }

        // Terapkan state langsung saat load
        applySidebarState();

        // Toggle dan simpan ke localStorage
        toggleBtn.addEventListener('click', function() {
            const isCollapsed = sidebar.classList.toggle('collapsed');
            mainWrapper.style.marginLeft = isCollapsed ? '68px' : '240px';
            localStorage.setItem('sidebar_collapsed', isCollapsed);
        });
    </script>
    @stack('scripts')

</body>

</html>