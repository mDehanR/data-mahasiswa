@extends('layouts.app', ['title' => 'Data Mahasiswa | Data Kampus'])

@section('content')
    <section class="border-b border-blue-100 bg-white">
        <div class="mx-auto max-w-7xl px-5 py-10 sm:px-8">
            <p class="mb-3 text-xs font-bold uppercase tracking-[0.2em] text-campus">Administrasi akademik</p>
            <div class="flex flex-col justify-between gap-5 md:flex-row md:items-end">
                <div>
                    <h1 class="font-display text-3xl font-bold tracking-tight text-navy sm:text-4xl">Data Mahasiswa</h1>
                    <p class="mt-2 max-w-xl text-sm text-slate-500">Kelola data mahasiswa dan program studi dalam satu ruang kerja akademik.</p>
                </div>
                <a href="{{ route('mahasiswa.create') }}" class="inline-flex items-center justify-center gap-2 rounded-lg bg-campus px-4 py-2.5 text-sm font-semibold text-white shadow-md shadow-blue-900/10 transition hover:bg-navy focus:outline-none focus:ring-4 focus:ring-blue-200">
                    <span class="text-lg leading-none">+</span>
                    Tambah Mahasiswa
                </a>
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-5 py-8 sm:px-8">
        @if (session('success')) <div class="mb-5 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">{{ session('success') }}</div> @endif
        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
            <div class="flex flex-col gap-2 border-b border-slate-200 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="font-display text-lg font-semibold text-navy">Daftar Mahasiswa</h2>
                    <p class="text-sm text-slate-500">{{ $mahasiswas->total() }} mahasiswa terdaftar</p>
                </div>
                <span class="inline-flex w-fit items-center rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-campus">Tahun Akademik 2026/2027</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full min-w-[1120px] text-left text-sm">
                    <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500">
                        <tr>
                            <th scope="col" class="px-5 py-4 font-semibold">No</th>
                            <th scope="col" class="px-5 py-4 font-semibold">NIM</th>
                            <th scope="col" class="px-5 py-4 font-semibold">Nama</th>
                            <th scope="col" class="px-5 py-4 font-semibold">JK</th>
                            <th scope="col" class="px-5 py-4 font-semibold">Alamat</th>
                            <th scope="col" class="px-5 py-4 font-semibold">Foto Mahasiswa</th>
                            <th scope="col" class="px-5 py-4 font-semibold">Prodi ID</th>
                            <th scope="col" class="px-5 py-4 text-center font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($mahasiswas as $mahasiswa)
                            <tr class="transition hover:bg-blue-50/40">
                                <td class="whitespace-nowrap px-5 py-4 text-slate-400">{{ $mahasiswas->firstItem() + $loop->index }}</td>
                                <td class="whitespace-nowrap px-5 py-4 font-semibold text-navy">{{ $mahasiswa->nim }}</td>
                                <td class="whitespace-nowrap px-5 py-4 font-medium text-slate-700">{{ $mahasiswa->nama_mahasiswa }}</td>
                                <td class="px-5 py-4"><span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-slate-100 text-xs font-bold text-slate-600">{{ $mahasiswa->jenis_kelamin }}</span></td>
                                <td class="max-w-xs px-5 py-4 text-slate-600">{{ $mahasiswa->alamat }}</td>
                                <td class="px-5 py-4">@if ($mahasiswa->foto_mahasiswa)<img src="{{ asset($mahasiswa->foto_mahasiswa) }}" alt="Foto {{ $mahasiswa->nama_mahasiswa }}" class="h-12 w-12 rounded-lg object-cover ring-1 ring-slate-200">@else<span class="text-slate-400">-</span>@endif</td>
                                <td class="px-5 py-4 text-slate-600"><span class="font-semibold text-navy">{{ $mahasiswa->prodi_id }}</span><span class="block text-xs text-slate-400">{{ $mahasiswa->prodi?->nama_prodi ?? 'Prodi tidak ditemukan' }}</span></td>
                                <td class="px-5 py-4">
                                    <div class="flex justify-center gap-2">
                                        <a href="{{ route('mahasiswa.edit', $mahasiswa) }}" title="Edit mahasiswa" aria-label="Edit mahasiswa" class="rounded-lg p-2 text-campus transition hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-300">
                                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 20h9"/><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5Z"/></svg>
                                        </a>
                                        <form method="POST" action="{{ route('mahasiswa.destroy', $mahasiswa) }}" onsubmit="return confirm('Hapus data mahasiswa ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" title="Hapus mahasiswa" aria-label="Hapus mahasiswa" class="rounded-lg p-2 text-rose-600 transition hover:bg-rose-50 focus:outline-none focus:ring-2 focus:ring-rose-300">
                                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 6h18"/><path stroke-linecap="round" stroke-linejoin="round" d="M8 6V4h8v2m-9 0 1 14h8l1-14M10 11v5m4-5v5"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="px-5 py-12 text-center text-slate-500">Belum ada data mahasiswa.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($mahasiswas->hasPages())
                <div class="border-t border-slate-200 px-5 py-4">{{ $mahasiswas->links() }}</div>
            @endif
        </div>
    </section>
@endsection