<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Prodi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class MahasiswaController extends Controller
{
    public function index(): View
    {
        $mahasiswas = Mahasiswa::with('prodi')->latest()->paginate(10);

        return view('mahasiswa.index', compact('mahasiswas'));
    }

    public function create(): View
    {
        return view('mahasiswa.create', ['prodis' => Prodi::orderBy('nama_prodi')->get()]);
    }

    public function show(Mahasiswa $mahasiswa): View
    {
        $mahasiswa->load(['prodi', 'mataKuliahs']);

        return view('mahasiswa.show', compact('mahasiswa'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate($this->rules());
        $data['foto_mahasiswa'] = $request->file('foto_mahasiswa')?->store('mahasiswa', 'public');

        Mahasiswa::create($data);

        return to_route('mahasiswa.index')->with('success', 'Data mahasiswa berhasil ditambahkan.');
    }

    public function edit(Mahasiswa $mahasiswa): View
    {
        return view('mahasiswa.edit', compact('mahasiswa') + ['prodis' => Prodi::orderBy('nama_prodi')->get()]);
    }

    public function update(Request $request, Mahasiswa $mahasiswa): RedirectResponse
    {
        $data = $request->validate($this->rules($mahasiswa));

        if ($request->hasFile('foto_mahasiswa')) {
            if ($mahasiswa->foto_mahasiswa) {
                Storage::disk('public')->delete($mahasiswa->foto_mahasiswa);
            }

            $data['foto_mahasiswa'] = $request->file('foto_mahasiswa')->store('mahasiswa', 'public');
        } else {
            unset($data['foto_mahasiswa']);
        }

        $mahasiswa->update($data);

        return to_route('mahasiswa.index')->with('success', 'Data mahasiswa berhasil diperbarui.');
    }

    public function destroy(Mahasiswa $mahasiswa): RedirectResponse
    {
        if ($mahasiswa->foto_mahasiswa) {
            Storage::disk('public')->delete($mahasiswa->foto_mahasiswa);
        }

        $mahasiswa->delete();

        return to_route('mahasiswa.index')->with('success', 'Data mahasiswa berhasil dihapus.');
    }

    private function rules(?Mahasiswa $mahasiswa = null): array
    {
        return [
            'nim' => ['required', 'string', 'max:255', 'unique:mahasiswas,nim,' . ($mahasiswa?->id ?? 'NULL')],
            'nama_mahasiswa' => ['required', 'string', 'max:255'],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'alamat' => ['required', 'string'],
            'foto_mahasiswa' => ['nullable', 'image', 'max:2048'],
            'prodi_id' => ['nullable', 'exists:prodis,id'],
        ];
    }
}
