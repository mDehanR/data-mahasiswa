@extends('layouts.app', ['title' => 'Data Mata Kuliah | Data Kampus'])

@section('content')
    <section class="border-b border-blue-100 bg-white">
        <div class="mx-auto max-w-7xl px-5 py-10 sm:px-8">
            <p class="mb-3 text-xs font-bold uppercase tracking-[0.2em] text-campus">Administrasi akademik</p>
            <div class="flex flex-col justify-between gap-5 md:flex-row md:items-end"><div><h1 class="font-display text-3xl font-bold tracking-tight text-navy sm:text-4xl">Data Mata Kuliah</h1><p class="mt-2 text-sm text-slate-500">Daftar mata kuliah dan program studi terkait.</p></div><a href="{{ route('mata-kuliah.create') }}" class="rounded-lg bg-campus px-4 py-2.5 text-sm font-semibold text-white hover:bg-navy">+ Tambah Mata Kuliah</a></div>
        </div>
    </section>
    <section class="mx-auto max-w-7xl px-5 py-8 sm:px-8">
        @if (session('success')) <div class="mb-5 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">{{ session('success') }}</div> @endif
        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-200 px-5 py-4"><h2 class="font-display text-lg font-semibold text-navy">Daftar Mata Kuliah</h2></div>
            <div class="overflow-x-auto">
                <table class="w-full min-w-[920px] text-left text-sm">
                    <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500"><tr><th class="px-5 py-4">No</th><th class="px-5 py-4">Nama Mata Kuliah</th><th class="px-5 py-4">SKS</th><th class="px-5 py-4">Mahasiswa ID</th><th class="px-5 py-4">Prodi ID</th><th class="px-5 py-4">Relasi Data</th><th class="px-5 py-4">Aksi</th></tr></thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($mataKuliahs as $mataKuliah)
                            <tr class="hover:bg-blue-50/40"><td class="px-5 py-4 text-slate-400">{{ $mataKuliahs->firstItem() + $loop->index }}</td><td class="px-5 py-4 font-medium text-navy">{{ $mataKuliah->nama_mata_kuliah }}</td><td class="px-5 py-4 text-slate-600">{{ $mataKuliah->sks }}</td><td class="px-5 py-4 text-slate-600"><span class="font-semibold text-navy">{{ $mataKuliah->mahasiswa_id }}</span></td><td class="px-5 py-4 text-slate-600"><span class="font-semibold text-navy">{{ $mataKuliah->prodi_id }}</span></td><td class="px-5 py-4 text-slate-600"><span class="block">{{ $mataKuliah->mahasiswa?->nama_mahasiswa ?? 'Mahasiswa tidak ditemukan' }}</span><span class="text-xs text-slate-400">{{ $mataKuliah->prodi?->nama_prodi ?? 'Prodi tidak ditemukan' }}</span></td><td class="px-5 py-4"><div class="flex gap-2"><a href="{{ route('mata-kuliah.edit', $mataKuliah) }}" class="rounded-lg px-2 py-1 text-xs font-semibold text-campus hover:bg-blue-100">Edit</a><form method="POST" action="{{ route('mata-kuliah.destroy', $mataKuliah) }}" onsubmit="return confirm('Hapus mata kuliah ini?')">@csrf @method('DELETE')<button class="rounded-lg px-2 py-1 text-xs font-semibold text-rose-600 hover:bg-rose-50">Hapus</button></form></div></td></tr>
                        @empty
                            <tr><td colspan="6" class="px-5 py-12 text-center text-slate-500">Belum ada data mata kuliah.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($mataKuliahs->hasPages()) <div class="border-t border-slate-200 px-5 py-4">{{ $mataKuliahs->links() }}</div> @endif
        </div>
    </section>
@endsection