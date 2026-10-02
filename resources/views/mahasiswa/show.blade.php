@extends('layouts.app', ['title' => 'Detail Mahasiswa | Data Kampus'])

@section('content')
    <section class="border-b border-blue-100 bg-white">
        <div class="mx-auto max-w-5xl px-5 py-10 sm:px-8">
            <a href="{{ route('mahasiswa.index') }}" class="text-sm font-semibold text-campus hover:text-navy">&larr; Kembali ke Data Mahasiswa</a>
            <p class="mb-3 mt-6 text-xs font-bold uppercase tracking-[0.2em] text-campus">Detail mahasiswa</p>
            <h1 class="font-display text-3xl font-bold text-navy">{{ $mahasiswa->nama_mahasiswa }}</h1>
        </div>
    </section>
    <section class="mx-auto max-w-5xl px-5 py-8 sm:px-8">
        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            @if ($mahasiswa->foto_mahasiswa)
                <img src="{{ asset('storage/' . $mahasiswa->foto_mahasiswa) }}" alt="Foto {{ $mahasiswa->nama_mahasiswa }}" class="mb-6 h-24 w-24 rounded-lg object-cover ring-1 ring-slate-200">
            @endif
            <dl class="grid gap-5 sm:grid-cols-2">
                <div><dt class="text-xs font-semibold uppercase text-slate-500">ID Mahasiswa</dt><dd class="mt-1 text-sm text-navy">{{ $mahasiswa->id }}</dd></div>
                <div><dt class="text-xs font-semibold uppercase text-slate-500">NIM</dt><dd class="mt-1 text-sm text-navy">{{ $mahasiswa->nim }}</dd></div>
                <div><dt class="text-xs font-semibold uppercase text-slate-500">Nama</dt><dd class="mt-1 text-sm text-navy">{{ $mahasiswa->nama_mahasiswa }}</dd></div>
                <div><dt class="text-xs font-semibold uppercase text-slate-500">Jenis Kelamin</dt><dd class="mt-1 text-sm text-navy">{{ $mahasiswa->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</dd></div>
                <div><dt class="text-xs font-semibold uppercase text-slate-500">Program Studi</dt><dd class="mt-1 text-sm text-navy">{{ $mahasiswa->prodi?->nama_prodi ?? 'Tanpa prodi' }}</dd></div>
                <div><dt class="text-xs font-semibold uppercase text-slate-500">Jumlah Mata Kuliah</dt><dd class="mt-1 text-sm text-navy">{{ $mahasiswa->mataKuliahs->count() }}</dd></div>
                <div class="sm:col-span-2"><dt class="text-xs font-semibold uppercase text-slate-500">Alamat</dt><dd class="mt-1 whitespace-pre-line text-sm text-navy">{{ $mahasiswa->alamat }}</dd></div>
            </dl>
            <div class="mt-8 flex gap-3 border-t border-slate-200 pt-5">
                <a href="{{ route('mahasiswa.edit', $mahasiswa) }}" class="rounded-lg bg-campus px-4 py-2 text-sm font-semibold text-white hover:bg-navy">Edit Mahasiswa</a>
                <a href="{{ route('mahasiswa.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Tutup</a>
            </div>
        </div>
    </section>
@endsection
