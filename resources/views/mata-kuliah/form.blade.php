@csrf
@php
    $selectedMahasiswa = old('mahasiswa_ids', isset($mataKuliah) ? $mataKuliah->mahasiswas->pluck('id')->all() : []);
@endphp
<div class="grid gap-5 sm:grid-cols-2">
    <label class="text-sm font-medium text-slate-700">Nama Mata Kuliah<input name="nama_mata_kuliah" value="{{ old('nama_mata_kuliah', $mataKuliah->nama_mata_kuliah ?? '') }}" required class="mt-2 w-full rounded-lg border border-slate-300 px-3 py-2.5"></label>
    <label class="text-sm font-medium text-slate-700">SKS<input type="number" name="sks" min="1" max="8" value="{{ old('sks', $mataKuliah->sks ?? 2) }}" required class="mt-2 w-full rounded-lg border border-slate-300 px-3 py-2.5"></label>
    <label class="text-sm font-medium text-slate-700">Program Studi<select name="prodi_id" class="mt-2 w-full rounded-lg border border-slate-300 px-3 py-2.5"><option value="">Tanpa prodi</option>@foreach ($prodis as $prodi)<option value="{{ $prodi->id }}" @selected((string) old('prodi_id', $mataKuliah->prodi_id ?? '') === (string) $prodi->id)>{{ $prodi->nama_prodi }}</option>@endforeach</select></label>
    <fieldset class="sm:col-span-2">
        <legend class="text-sm font-medium text-slate-700">Mahasiswa</legend>
        <div class="mt-2 grid max-h-72 gap-1 overflow-y-auto rounded-lg border border-slate-300 bg-white p-2 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($mahasiswas as $mahasiswaOption)
                <label class="flex cursor-pointer items-center gap-3 rounded-md px-3 py-2.5 text-sm text-slate-700 hover:bg-blue-50">
                    <input type="checkbox" name="mahasiswa_ids[]" value="{{ $mahasiswaOption->id }}" @checked(in_array($mahasiswaOption->id, $selectedMahasiswa)) class="h-4 w-4 rounded border-slate-300 accent-campus">
                    <span><span class="font-medium">{{ $mahasiswaOption->nama_mahasiswa }}</span><span class="ml-2 text-xs text-slate-500">{{ $mahasiswaOption->nim }}</span></span>
                </label>
            @empty
                <p class="px-3 py-2 text-sm text-slate-500 sm:col-span-2 lg:col-span-3">Belum ada data mahasiswa.</p>
            @endforelse
        </div>
        @if ($errors->has('mahasiswa_ids') || $errors->has('mahasiswa_ids.*'))
            <p class="mt-2 text-sm text-rose-600">{{ $errors->first('mahasiswa_ids') ?: $errors->first('mahasiswa_ids.*') }}</p>
        @endif
    </fieldset>
</div>
<p class="mt-4 text-xs text-slate-500">Pilih satu atau lebih mahasiswa. Prodi mata kuliah dapat berbeda dari prodi mahasiswa.</p>
<div class="mt-6 flex justify-end gap-3"><a href="{{ route('mata-kuliah.index') }}" class="rounded-lg px-4 py-2.5 text-sm font-semibold text-slate-600 hover:bg-slate-100">Batal</a><button class="rounded-lg bg-campus px-4 py-2.5 text-sm font-semibold text-white hover:bg-navy">Simpan</button></div>
