@csrf
<div class="grid gap-5 sm:grid-cols-2">
    <label class="text-sm font-medium text-slate-700">Nama Prodi
        <input name="nama_prodi" value="{{ old('nama_prodi', $prodi->nama_prodi ?? '') }}" required class="mt-2 w-full rounded-lg border border-slate-300 px-3 py-2.5 focus:border-campus focus:outline-none focus:ring-2 focus:ring-blue-100">
    </label>
    <label class="text-sm font-medium text-slate-700">Akreditasi
        <select name="akreditasi" required class="mt-2 w-full rounded-lg border border-slate-300 px-3 py-2.5 focus:border-campus focus:outline-none focus:ring-2 focus:ring-blue-100">
            @foreach (['Unggul', 'Baik Sekali', 'Baik', 'Belum terakreditasi'] as $akreditasi)
                <option value="{{ $akreditasi }}" @selected(old('akreditasi', $prodi->akreditasi ?? '') === $akreditasi)>{{ $akreditasi }}</option>
            @endforeach
        </select>
    </label>
</div>
<label class="mt-5 block text-sm font-medium text-slate-700">Path Foto Prodi <span class="font-normal text-slate-400">(opsional)</span>
    <input name="foto_prodi" value="{{ old('foto_prodi', $prodi->foto_prodi ?? '') }}" class="mt-2 w-full rounded-lg border border-slate-300 px-3 py-2.5 focus:border-campus focus:outline-none focus:ring-2 focus:ring-blue-100">
</label>
<div class="mt-6 flex justify-end gap-3"><a href="{{ route('prodi.index') }}" class="rounded-lg px-4 py-2.5 text-sm font-semibold text-slate-600 hover:bg-slate-100">Batal</a><button class="rounded-lg bg-campus px-4 py-2.5 text-sm font-semibold text-white hover:bg-navy">Simpan</button></div>