<!DOCTYPE html>
<html lang="id" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'SMA Cendana Pekanbaru' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=DM+Serif+Display:ital@0;1&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
    <link rel="stylesheet" href="/css/auth.css" />

</head>

<body>

    {{-- Particles Background --}}
    <div id="particles-js"></div>

    {{-- Page Shell --}}
    <div class="page-layer">

        {{-- header --}}
        <x-header-auth />

        {{-- Main Slot --}}
        <main class="flex flex-1 items-center justify-center px-4">
            {{ $slot }}
        </main>

        {{-- Footer --}}
        <x-footer-auth />
    </div>

    <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
    <script src="/js/auth.js"></script>
    @stack('scripts')
    <script>
        particlesJS('particles-js', {
            particles: {
                number: {
                    value: 60,
                    density: {
                        enable: true,
                        value_area: 900
                    }
                },
                color: {
                    value: '#d4af37'
                },
                shape: {
                    type: 'circle'
                },
                opacity: {
                    value: 0.45,
                    random: true,
                    anim: {
                        enable: true,
                        speed: 0.6,
                        opacity_min: 0.15,
                        sync: false
                    }
                },
                size: {
                    value: 4,
                    random: true,
                    anim: {
                        enable: true,
                        speed: 1.2,
                        size_min: 0.5,
                        sync: false
                    }
                },
                line_linked: {
                    enable: true,
                    distance: 160,
                    color: '#b68b2c',
                    opacity: 0.18,
                    width: 0.8
                },
                move: {
                    enable: true,
                    speed: 0.55,
                    direction: 'none',
                    random: true,
                    straight: false,
                    out_mode: 'out',
                    bounce: false,
                    attract: {
                        enable: false
                    }
                }
            },
            interactivity: {
                detect_on: 'canvas',
                events: {
                    onhover: {
                        enable: true,
                        mode: 'bubble'
                    },
                    onclick: {
                        enable: false
                    },
                    resize: true
                },
                modes: {
                    bubble: {
                        distance: 160,
                        size: 5,
                        duration: 1.5,
                        opacity: 0.6,
                        speed: 3
                    }
                }
            },
            retina_detect: true
        });
    </script>

</body>

</html>