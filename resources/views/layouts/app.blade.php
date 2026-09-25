<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $title ?? 'Data Kampus' }}</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            navy: '#0f2d52',
                            campus: '#1d5fa7',
                            mist: '#f4f7fb',
                        },
                        fontFamily: {
                            sans: ['DM Sans', 'sans-serif'],
                            display: ['Space Grotesk', 'sans-serif'],
                        },
                    },
                },
            };
        </script>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
        <style>
            @keyframes page-enter {
                from { opacity: 0; transform: translateY(14px); }
                to { opacity: 1; transform: translateY(0); }
            }

            @keyframes nav-enter {
                from { opacity: 0; transform: translateX(-8px); }
                to { opacity: 1; transform: translateY(0); }
            }

            @keyframes soft-glow {
                0%, 100% { box-shadow: 0 0 0 rgba(147, 197, 253, 0); }
                50% { box-shadow: 0 12px 38px rgba(147, 197, 253, 0.14); }
            }

            .site-sidebar {
                animation: nav-enter 600ms cubic-bezier(.22, 1, .36, 1) both;
            }

            .site-sidebar nav a {
                animation: nav-enter 500ms cubic-bezier(.22, 1, .36, 1) both;
            }

            .site-sidebar nav a:nth-child(1) { animation-delay: 80ms; }
            .site-sidebar nav a:nth-child(2) { animation-delay: 140ms; }
            .site-sidebar nav a:nth-child(3) { animation-delay: 200ms; }
            .site-sidebar nav a:nth-child(4) { animation-delay: 260ms; }

            main {
                animation: page-enter 700ms cubic-bezier(.22, 1, .36, 1) 120ms both;
            }

            main section {
                animation: page-enter 700ms cubic-bezier(.22, 1, .36, 1) 220ms both;
            }

            main section + section {
                animation-delay: 320ms;
            }

            .shadow-sm {
                animation: soft-glow 1.8s ease-in-out 700ms both;
            }

            @media (prefers-reduced-motion: reduce) {
                *, *::before, *::after {
                    animation-duration: 1ms !important;
                    animation-delay: 0ms !important;
                    scroll-behavior: auto !important;
                }
            }
        </style>
    </head>
    <body class="min-h-screen bg-mist font-sans text-slate-800 antialiased">
        <aside class="site-sidebar border-b border-blue-900/40 bg-navy text-white shadow-lg shadow-slate-900/10 lg:fixed lg:inset-y-0 lg:left-0 lg:z-20 lg:flex lg:w-72 lg:flex-col lg:border-b-0 lg:border-r lg:border-white/10">
            <div class="flex flex-col gap-6 px-5 py-5 lg:h-full lg:px-6 lg:py-7">
                <a href="{{ url('/') }}" class="flex items-center gap-3">
                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-white/10 text-blue-100 ring-1 ring-white/20" aria-hidden="true">
                        <svg class="h-7 w-7" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5 18 24 8l19 10-19 10L5 18Z" fill="currentColor"/>
                            <path d="M12 22v8c3.7 3.7 7.7 5.5 12 5.5S32.3 33.7 36 30v-8" stroke="currentColor" stroke-width="3" stroke-linecap="round"/>
                            <path d="M43 19v10" stroke="#93C5FD" stroke-width="3" stroke-linecap="round"/>
                            <path d="M9 37h30" stroke="#93C5FD" stroke-width="3" stroke-linecap="round"/>
                        </svg>
                    </span>
                    <span>
                        <span class="block font-display text-lg font-semibold tracking-tight">DATA KAMPUS</span>
                        <span class="block text-xs tracking-[0.2em] text-blue-200">PORTAL AKADEMIK</span>
                    </span>
                </a>
                <div class="hidden border-t border-white/10 pt-5 text-xs font-semibold uppercase tracking-[0.18em] text-blue-300 lg:block">Menu utama</div>
                <nav class="grid grid-cols-2 gap-2 text-sm font-medium text-blue-100 lg:flex lg:flex-col" aria-label="Navigasi utama">
                    <a href="{{ route('home') }}" class="rounded-lg px-3 py-2.5 transition hover:bg-white/10 hover:text-white {{ request()->routeIs('home') ? 'bg-white/10 text-white ring-1 ring-white/10' : '' }}">Beranda</a>
                    <a href="{{ route('prodi.index') }}" class="rounded-lg px-3 py-2.5 transition hover:bg-white/10 hover:text-white {{ request()->routeIs('prodi.*') ? 'bg-white/10 text-white ring-1 ring-white/10' : '' }}">Data Prodi</a>
                    <a href="{{ route('mahasiswa.index') }}" class="rounded-lg px-3 py-2.5 transition hover:bg-white/10 hover:text-white {{ request()->routeIs('mahasiswa.*') ? 'bg-white/10 text-white ring-1 ring-white/10' : '' }}">Data Mahasiswa</a>
                    <a href="{{ route('mata-kuliah.index') }}" class="rounded-lg px-3 py-2.5 transition hover:bg-white/10 hover:text-white {{ request()->routeIs('mata-kuliah.*') ? 'bg-white/10 text-white ring-1 ring-white/10' : '' }}">Data Mata Kuliah</a>
                </nav>
            </div>
        </aside>

        <main class="lg:ml-72">
            @yield('content')
        </main>
    </body>
</html>