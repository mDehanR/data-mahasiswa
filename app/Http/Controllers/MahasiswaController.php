<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Prodi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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

    public function store(Request $request): RedirectResponse
    {
        Mahasiswa::create($request->validate($this->rules()));

        return to_route('mahasiswa.index')->with('success', 'Data mahasiswa berhasil ditambahkan.');
    }

    public function edit(Mahasiswa $mahasiswa): View
    {
        return view('mahasiswa.edit', compact('mahasiswa') + ['prodis' => Prodi::orderBy('nama_prodi')->get()]);
    }

    public function update(Request $request, Mahasiswa $mahasiswa): RedirectResponse
    {
        $mahasiswa->update($request->validate($this->rules($mahasiswa)));

        return to_route('mahasiswa.index')->with('success', 'Data mahasiswa berhasil diperbarui.');
    }

    public function destroy(Mahasiswa $mahasiswa): RedirectResponse
    {
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
            'foto_mahasiswa' => ['nullable', 'string', 'max:255'],
            'prodi_id' => ['required', 'exists:prodis,id'],
        ];
    }
}