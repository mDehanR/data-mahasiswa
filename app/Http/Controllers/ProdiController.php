<?php

namespace App\Http\Controllers;

use App\Models\Prodi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProdiController extends Controller
{
    public function index(): View
    {
        return view('prodi.index', [
            'prodis' => Prodi::withCount(['mahasiswas', 'mataKuliahs'])->latest()->paginate(10),
        ]);
    }

    public function create(): View
    {
        return view('prodi.create');
    }

    public function store(Request $request): RedirectResponse
    {
        Prodi::create($request->validate($this->rules()));

        return to_route('prodi.index')->with('success', 'Program studi berhasil ditambahkan.');
    }

    public function edit(Prodi $prodi): View
    {
        return view('prodi.edit', compact('prodi'));
    }

    public function update(Request $request, Prodi $prodi): RedirectResponse
    {
        $prodi->update($request->validate($this->rules()));

        return to_route('prodi.index')->with('success', 'Program studi berhasil diperbarui.');
    }

    public function destroy(Prodi $prodi): RedirectResponse
    {
        $prodi->delete();

        return to_route('prodi.index')->with('success', 'Program studi berhasil dihapus.');
    }

    private function rules(): array
    {
        return [
            'nama_prodi' => ['required', 'string', 'max:255'],
            'akreditasi' => ['required', 'in:Unggul,Baik Sekali,Baik,Belum terakreditasi'],
            'foto_prodi' => ['nullable', 'string', 'max:255'],
        ];
    }
}