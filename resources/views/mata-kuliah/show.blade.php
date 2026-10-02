@extends('layouts.app', ['title' => 'Detail Mata Kuliah | Data Kampus'])

@section('content')
    <section class="border-b border-blue-100 bg-white">
        <div class="mx-auto max-w-5xl px-5 py-10 sm:px-8">
            <a href="{{ route('mata-kuliah.index') }}" class="text-sm font-semibold text-campus hover:text-navy">&larr; Kembali ke Data Mata Kuliah</a>
            <p class="mb-3 mt-6 text-xs font-bold uppercase tracking-[0.2em] text-campus">Detail mata kuliah</p>
            <h1 class="font-display text-3xl font-bold text-navy">{{ $mataKuliah->nama_mata_kuliah }}</h1>
        </div>
    </section>
    <section class="mx-auto max-w-5xl px-5 py-8 sm:px-8">
        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <dl class="grid gap-5 sm:grid-cols-2">
                <div><dt class="text-xs font-semibold uppercase text-slate-500">ID Mata Kuliah</dt><dd class="mt-1 text-sm text-navy">{{ $mataKuliah->id }}</dd></div>
                <div><dt class="text-xs font-semibold uppercase text-slate-500">Nama Mata Kuliah</dt><dd class="mt-1 text-sm text-navy">{{ $mataKuliah->nama_mata_kuliah }}</dd></div>
                <div><dt class="text-xs font-semibold uppercase text-slate-500">SKS</dt><dd class="mt-1 text-sm text-navy">{{ $mataKuliah->sks }}</dd></div>
                <div><dt class="text-xs font-semibold uppercase text-slate-500">Mahasiswa</dt><dd class="mt-1 text-sm text-navy">@forelse ($mataKuliah->mahasiswas as $mahasiswa)<span class="block">{{ $mahasiswa->nama_mahasiswa }} ({{ $mahasiswa->nim }})</span>@empty Belum ada mahasiswa @endforelse</dd></div>
                <div><dt class="text-xs font-semibold uppercase text-slate-500">Program Studi</dt><dd class="mt-1 text-sm text-navy">{{ $mataKuliah->prodi?->nama_prodi ?? 'Tanpa prodi' }}@if ($mataKuliah->prodi_id) (ID: {{ $mataKuliah->prodi_id }}) @endif</dd></div>
                <div><dt class="text-xs font-semibold uppercase text-slate-500">Dibuat</dt><dd class="mt-1 text-sm text-navy">{{ $mataKuliah->created_at?->format('d/m/Y H:i') ?? '-' }}</dd></div>
            </dl>
            <div class="mt-8 flex gap-3 border-t border-slate-200 pt-5">
                <a href="{{ route('mata-kuliah.edit', $mataKuliah) }}" class="rounded-lg bg-campus px-4 py-2 text-sm font-semibold text-white hover:bg-navy">Edit Mata Kuliah</a>
                <a href="{{ route('mata-kuliah.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Tutup</a>
            </div>
        </div>
    </section>
@endsection
