@extends('layouts.app', ['title' => 'Detail Prodi | Data Kampus'])

@section('content')
    <section class="border-b border-blue-100 bg-white">
        <div class="mx-auto max-w-5xl px-5 py-10 sm:px-8">
            <a href="{{ route('prodi.index') }}" class="text-sm font-semibold text-campus hover:text-navy">&larr; Kembali ke Data Prodi</a>
            <p class="mb-3 mt-6 text-xs font-bold uppercase tracking-[0.2em] text-campus">Detail program studi</p>
            <h1 class="font-display text-3xl font-bold text-navy">{{ $prodi->nama_prodi }}</h1>
        </div>
    </section>
    <section class="mx-auto max-w-5xl px-5 py-8 sm:px-8">
        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            @if ($prodi->foto_prodi)
                <img src="{{ asset('storage/' . $prodi->foto_prodi) }}" alt="Logo {{ $prodi->nama_prodi }}" class="mb-6 h-24 w-24 rounded-lg object-cover ring-1 ring-slate-200">
            @endif
            <dl class="grid gap-5 sm:grid-cols-2">
                <div><dt class="text-xs font-semibold uppercase text-slate-500">ID Prodi</dt><dd class="mt-1 text-sm text-navy">{{ $prodi->id }}</dd></div>
                <div><dt class="text-xs font-semibold uppercase text-slate-500">Nama Prodi</dt><dd class="mt-1 text-sm text-navy">{{ $prodi->nama_prodi }}</dd></div>
                <div><dt class="text-xs font-semibold uppercase text-slate-500">Akreditasi</dt><dd class="mt-1 text-sm text-navy">{{ $prodi->akreditasi }}</dd></div>
                <div><dt class="text-xs font-semibold uppercase text-slate-500">Jumlah Mahasiswa</dt><dd class="mt-1 text-sm text-navy">{{ $prodi->mahasiswas->count() }}</dd></div>
                <div><dt class="text-xs font-semibold uppercase text-slate-500">Jumlah Mata Kuliah</dt><dd class="mt-1 text-sm text-navy">{{ $prodi->mataKuliahs->count() }}</dd></div>
                <div><dt class="text-xs font-semibold uppercase text-slate-500">Dibuat</dt><dd class="mt-1 text-sm text-navy">{{ $prodi->created_at?->format('d/m/Y H:i') ?? '-' }}</dd></div>
            </dl>
            <div class="mt-8 flex gap-3 border-t border-slate-200 pt-5">
                <a href="{{ route('prodi.edit', $prodi) }}" class="rounded-lg bg-campus px-4 py-2 text-sm font-semibold text-white hover:bg-navy">Edit Prodi</a>
                <a href="{{ route('prodi.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Tutup</a>
            </div>
        </div>
    </section>
@endsection
