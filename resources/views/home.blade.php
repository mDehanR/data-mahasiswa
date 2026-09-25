@extends('layouts.app', ['title' => 'Beranda | Data Kampus'])

@section('content')
    <style>
        .book-stage {
            perspective: 650px;
            min-height: 30rem;
        }

        .book {
            position: relative;
            --book-depth: 2.4rem;
            width: 14rem;
            height: 18rem;
            transform: rotateX(20deg) rotateY(-42deg) rotateZ(-4deg);
            transform-style: preserve-3d;
            transition: filter 500ms ease-out;
            filter: drop-shadow(1.5rem 1.5rem 1rem rgba(2, 17, 38, .34));
        }

        .book-stage:hover .book,
        .book-stage:focus-within .book {
            filter: drop-shadow(1.5rem 1.5rem 1rem rgba(2, 17, 38, .5));
        }

        .book-face {
            position: absolute;
            display: flex;
            align-items: center;
            justify-content: center;
            transform-style: preserve-3d;
            backface-visibility: hidden;
        }

        .book-cover {
            inset: 0;
            border: 1px solid rgba(255, 255, 255, .35);
            border-radius: .35rem .75rem .75rem .35rem;
            background: linear-gradient(145deg, #3285d2, #123d70 70%);
            color: #e0f2fe;
            transform: translateZ(calc(var(--book-depth) / 2));
        }

        .book-cover::before {
            content: '';
            position: absolute;
            inset: 1.1rem;
            border: 1px solid rgba(191, 219, 254, .6);
            border-radius: .2rem .5rem .5rem .2rem;
        }

        .book-cover::after {
            content: 'DATA KAMPUS';
            position: absolute;
            top: 3.2rem;
            left: 1.8rem;
            right: 1.8rem;
            padding: .65rem .25rem;
            border-top: 1px solid rgba(219, 234, 254, .7);
            border-bottom: 1px solid rgba(219, 234, 254, .7);
            font: 700 .8rem/1.2 'Space Grotesk', sans-serif;
            letter-spacing: .24em;
            text-align: center;
        }

        .book-back {
            inset: 0;
            border: 1px solid rgba(147, 197, 253, .45);
            border-radius: .35rem .75rem .75rem .35rem;
            background: #123d70;
            transform: rotateY(180deg) translateZ(calc(var(--book-depth) / 2));
        }

        .book-pages {
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: 1px solid #bfdbfe;
            border-radius: .2rem;
            background: repeating-linear-gradient(to bottom, #eff6ff 0, #eff6ff 3px, #bfdbfe 4px, #eff6ff 5px);
            transform: translateZ(0);
        }

        .book-pages::before {
            content: '';
            position: absolute;
            inset: .45rem .3rem;
            border-radius: .1rem;
            background: repeating-linear-gradient(to bottom, #dbeafe 0, #dbeafe 3px, #93c5fd 4px, #dbeafe 5px);
        }

        .book-top,
        .book-bottom {
            left: 0;
            width: 100%;
            height: var(--book-depth);
            border: 1px solid #bfdbfe;
            background: repeating-linear-gradient(to right, #eff6ff 0, #eff6ff 3px, #bfdbfe 4px, #eff6ff 5px);
        }

        .book-top {
            top: calc(var(--book-depth) / -2);
            transform: rotateX(90deg);
            transform-origin: bottom center;
        }

        .book-bottom {
            bottom: calc(var(--book-depth) / -2);
            transform: rotateX(-90deg);
            transform-origin: top center;
        }

        .book-spine,
        .book-edge {
            top: 0;
            width: var(--book-depth);
            height: 100%;
            border: 1px solid rgba(147, 197, 253, .6);
            background: linear-gradient(90deg, #0b2a4d, #2468a8);
        }

        .book-spine {
            left: calc(var(--book-depth) / -2);
            transform: rotateY(-90deg);
            transform-origin: right center;
        }

        .book-edge {
            right: calc(var(--book-depth) / -2);
            transform: rotateY(90deg);
            transform-origin: left center;
            background: repeating-linear-gradient(to bottom, #eff6ff 0, #eff6ff 3px, #bfdbfe 4px, #eff6ff 5px);
        }

        .book-label {
            position: relative;
            z-index: 1;
            margin-top: 5.4rem;
            font-size: .72rem;
            letter-spacing: .18em;
            text-transform: uppercase;
        }

        @media (prefers-reduced-motion: reduce) {
            .book { transform: rotateX(20deg) rotateY(-42deg) rotateZ(-4deg); }
        }
    </style>
    <section class="relative isolate overflow-hidden bg-navy">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(57,132,211,0.34),_transparent_42%),linear-gradient(135deg,_#0f2d52_0%,_#164b80_100%)]"></div>
        <div class="relative mx-auto grid min-h-[calc(100vh-73px)] max-w-7xl items-center gap-12 px-5 py-16 sm:px-8 lg:grid-cols-[1.1fr_0.9fr] lg:py-24">
            <div class="max-w-2xl">
                <h1 class="font-display text-4xl font-bold leading-tight tracking-tight text-white sm:text-6xl">Selamat Datang di <span class="text-blue-200">Data Kampus</span></h1>
                <p class="mt-6 max-w-xl text-base leading-8 text-blue-100 sm:text-lg">Kelola data program studi, mahasiswa, dan mata kuliah dengan lebih mudah, teratur, dan terhubung dalam satu sistem akademik.</p>
                <div class="mt-9 flex flex-col gap-3 sm:flex-row">
                    <a href="{{ route('mahasiswa.index') }}" class="inline-flex items-center justify-center gap-3 rounded-lg bg-white px-5 py-3 text-sm font-bold text-navy shadow-xl shadow-slate-950/20 transition hover:bg-blue-50 focus:outline-none focus:ring-4 focus:ring-white/30">
                        Lanjut Masukkan Data
                        <span aria-hidden="true" class="text-lg">&#8594;</span>
                    </a>
                    <a href="{{ route('prodi.index') }}" class="inline-flex items-center justify-center rounded-lg border border-white/25 px-5 py-3 text-sm font-semibold text-white transition hover:bg-white/10 focus:outline-none focus:ring-4 focus:ring-white/20">Lihat Program Studi</a>
                </div>
            </div>

            <div class="relative hidden lg:flex lg:items-center lg:justify-center">
                <div class="absolute h-72 w-72 rounded-full bg-blue-300/10 blur-3xl"></div>
                <div class="book-stage relative flex w-full items-center justify-center" tabindex="0" aria-label="Buku 3D Data Kampus">
                    <div class="book" aria-hidden="true">
                        <div class="book-face book-back"></div>
                        <div class="book-face book-pages"></div>
                        <div class="book-face book-top"></div>
                        <div class="book-face book-bottom"></div>
                        <div class="book-face book-spine"></div>
                        <div class="book-face book-edge"></div>
                        <div class="book-face book-cover"><span class="book-label">Ruang kerja akademik</span></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        (() => {
            const stage = document.querySelector('.book-stage');
            const book = stage?.querySelector('.book');

            if (!stage || !book) return;

            const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
            let angle = -42;
            let speed = 20;
            let targetSpeed = 20;
            let previousTime = performance.now();

            const render = (time) => {
                const elapsed = Math.min((time - previousTime) / 1000, 0.05);
                previousTime = time;

                if (!reducedMotion.matches) {
                    speed += (targetSpeed - speed) * Math.min(elapsed * 4.5, 1);
                    angle += speed * elapsed;
                    book.style.transform = `rotateX(20deg) rotateY(${angle}deg) rotateZ(-4deg)`;
                }

                requestAnimationFrame(render);
            };

            const accelerate = () => { targetSpeed = 150; };
            const decelerate = () => { targetSpeed = 20; };

            stage.addEventListener('mouseenter', accelerate);
            stage.addEventListener('mouseleave', decelerate);
            stage.addEventListener('focusin', accelerate);
            stage.addEventListener('focusout', decelerate);
            reducedMotion.addEventListener?.('change', () => {
                if (reducedMotion.matches) book.style.transform = 'rotateX(20deg) rotateY(-42deg) rotateZ(-4deg)';
            });

            requestAnimationFrame(render);
        })();
    </script>
@endsection