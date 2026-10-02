@extends('layouts.app', ['title' => 'Beranda | Data Kampus'])

@section('content')
    <style>
        .book-stage {
            width: min(100%, 32rem);
            height: clamp(20rem, 36vw, 33rem);
            overflow: visible;
            outline: none;
        }

        .book-stage canvas {
            display: block;
            width: 100%;
            height: 100%;
        }
    </style>
    <section class="relative isolate bg-navy">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(57,132,211,0.34),_transparent_42%),linear-gradient(135deg,_#0f2d52_0%,_#164b80_100%)]"></div>
        <div class="relative mx-auto grid min-h-screen max-w-7xl items-center gap-12 px-5 py-16 sm:px-8 lg:grid-cols-[1.1fr_0.9fr] lg:py-24">
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

            <div class="relative flex items-center justify-center">
                <div class="absolute h-72 w-72 rounded-full bg-blue-300/10 blur-3xl"></div>
                <div class="book-stage relative flex items-center justify-center" data-book-scene data-book-link="{{ route('mahasiswa.index') }}" tabindex="0" aria-label="Buku hardcover 3D Data Kampus">
                    <canvas aria-hidden="true"></canvas>
                </div>
            </div>
        </div>
    </section>
    @vite('resources/js/app.js')
@endsection
