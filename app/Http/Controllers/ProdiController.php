<?php

namespace App\Http\Controllers;

use App\Models\Prodi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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

    public function show(Prodi $prodi): View
    {
        $prodi->load(['mahasiswas', 'mataKuliahs']);

        return view('prodi.show', compact('prodi'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate($this->rules());
        $data['foto_prodi'] = $request->file('foto_prodi')?->store('prodi', 'public');

        Prodi::create($data);

        return to_route('prodi.index')->with('success', 'Program studi berhasil ditambahkan.');
    }

    public function edit(Prodi $prodi): View
    {
        return view('prodi.edit', compact('prodi'));
    }

    public function update(Request $request, Prodi $prodi): RedirectResponse
    {
        $data = $request->validate($this->rules());

        if ($request->hasFile('foto_prodi')) {
            if ($prodi->foto_prodi) {
                Storage::disk('public')->delete($prodi->foto_prodi);
            }

            $data['foto_prodi'] = $request->file('foto_prodi')->store('prodi', 'public');
        } else {
            unset($data['foto_prodi']);
        }

        $prodi->update($data);

        return to_route('prodi.index')->with('success', 'Program studi berhasil diperbarui.');
    }

    public function destroy(Prodi $prodi): RedirectResponse
    {
        if ($prodi->foto_prodi) {
            Storage::disk('public')->delete($prodi->foto_prodi);
        }

        $prodi->delete();

        return to_route('prodi.index')->with('success', 'Program studi berhasil dihapus.');
    }

    private function rules(): array
    {
        return [
            'nama_prodi' => ['required', 'string', 'max:255'],
            'akreditasi' => ['required', 'in:Unggul,Baik Sekali,Baik,Belum terakreditasi'],
            'foto_prodi' => ['nullable', 'image', 'max:2048'],
        ];
    }
}
