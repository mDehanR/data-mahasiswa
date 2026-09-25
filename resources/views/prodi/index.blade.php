@extends('layouts.app', ['title' => 'Data Prodi | Data Kampus'])

@section('content')
    <section class="border-b border-blue-100 bg-white">
        <div class="mx-auto max-w-7xl px-5 py-10 sm:px-8">
            <p class="mb-3 text-xs font-bold uppercase tracking-[0.2em] text-campus">Administrasi akademik</p>
            <div class="flex flex-col justify-between gap-5 md:flex-row md:items-end"><div><h1 class="font-display text-3xl font-bold tracking-tight text-navy sm:text-4xl">Data Program Studi</h1><p class="mt-2 text-sm text-slate-500">Daftar program studi yang tersedia di kampus.</p></div><a href="{{ route('prodi.create') }}" class="rounded-lg bg-campus px-4 py-2.5 text-sm font-semibold text-white hover:bg-navy">+ Tambah Prodi</a></div>
        </div>
    </section>
    <section class="mx-auto max-w-7xl px-5 py-8 sm:px-8">
        @if (session('success')) <div class="mb-5 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">{{ session('success') }}</div> @endif
        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-200 px-5 py-4">
                <h2 class="font-display text-lg font-semibold text-navy">Daftar Prodi</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full min-w-[760px] text-left text-sm">
                    <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500">
                        <tr>
                            <th class="px-5 py-4">No</th><th class="px-5 py-4">Nama Prodi</th><th class="px-5 py-4">Akreditasi</th><th class="px-5 py-4">Foto / Logo Prodi</th><th class="px-5 py-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($prodis as $prodi)
                            <tr class="hover:bg-blue-50/40"><td class="px-5 py-4 text-slate-400">{{ $prodis->firstItem() + $loop->index }}</td><td class="px-5 py-4 font-medium text-navy">{{ $prodi->nama_prodi }}</td><td class="px-5 py-4 text-slate-600">{{ $prodi->akreditasi }}</td><td class="px-5 py-4">@if ($prodi->foto_prodi)<img src="{{ asset($prodi->foto_prodi) }}" alt="Logo {{ $prodi->nama_prodi }}" class="h-12 w-12 rounded-lg object-cover ring-1 ring-slate-200">@else<span class="text-slate-400">-</span>@endif</td><td class="px-5 py-4"><div class="flex gap-2"><a href="{{ route('prodi.edit', $prodi) }}" class="rounded-lg px-2 py-1 text-xs font-semibold text-campus hover:bg-blue-100">Edit</a><form method="POST" action="{{ route('prodi.destroy', $prodi) }}" onsubmit="return confirm('Hapus prodi ini? Data terkait juga akan terhapus.')">@csrf @method('DELETE')<button class="rounded-lg px-2 py-1 text-xs font-semibold text-rose-600 hover:bg-rose-50">Hapus</button></form></div></td></tr>
                        @empty
                            <tr><td colspan="6" class="px-5 py-12 text-center text-slate-500">Belum ada data program studi.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($prodis->hasPages()) <div class="border-t border-slate-200 px-5 py-4">{{ $prodis->links() }}</div> @endif
        </div>
    </section>
@endsection