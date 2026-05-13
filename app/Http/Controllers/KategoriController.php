<?php

namespace App\Http\Controllers;

use App\Models\kategori;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class KategoriController extends Controller
{
    public function index(): View
    {
        $kategoris = kategori::query()->orderBy('nama_kategori')->get();

        return view('kategori.index', compact('kategoris'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_kategori' => ['required', 'string', 'max:191', 'unique:kategori,nama_kategori'],
        ]);

        kategori::query()->create($validated);

        return redirect()->route('kategori.index')->with('status', 'Kategori berhasil ditambahkan.');
    }

    public function update(Request $request, kategori $kategori): RedirectResponse
    {
        $validated = $request->validate([
            'nama_kategori' => [
                'required',
                'string',
                'max:191',
                Rule::unique('kategori', 'nama_kategori')->ignore($kategori->idkategori, 'idkategori'),
            ],
        ]);

        $kategori->update($validated);

        return redirect()->route('kategori.index')->with('status', 'Kategori berhasil diperbarui.');
    }

    public function destroy(kategori $kategori): RedirectResponse
    {
        $kategori->delete();

        return redirect()->route('kategori.index')->with('status', 'Kategori berhasil dihapus.');
    }
}
