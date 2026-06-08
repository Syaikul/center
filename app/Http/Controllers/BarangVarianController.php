<?php

namespace App\Http\Controllers;

use App\Models\barang_sub;
use App\Models\barang_varian;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class BarangVarianController extends Controller
{
    public function index(): View
    {
        $varians = barang_varian::query()
            ->nonDefault()
            ->with('subBarang.barang')
            ->orderBy('idvarian', 'desc')
            ->get();
        $subBarangs = barang_sub::query()->with('barang')->orderBy('namasubbarang')->get();

        return view('barang-varian.index', compact('varians', 'subBarangs'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'idsubbarang' => ['required', 'integer', 'exists:barang_sub,idsubbarang'],
            'kodevarian' => ['required', 'string', 'max:100'],
            'namavarian' => ['required', 'string', 'max:191', 'not_in:-'],
        ]);

        $request->validate([
            'kodevarian' => [
                Rule::unique('barang_varian', 'kodevarian')
                    ->where(fn ($query) => $query->where('idsubbarang', $validated['idsubbarang'])),
            ],
        ], [
            'kodevarian.unique' => 'Kode varian ini sudah dipakai untuk sub barang yang dipilih.',
        ]);

        $subBarang = barang_sub::query()->findOrFail($validated['idsubbarang']);

        if ($subBarang->hasOnlyDefaultVarian()) {
            $subBarang->defaultVarian()?->delete();
        }

        barang_varian::query()->create($validated);

        return redirect()->route('barang-varian.index')->with('status', 'Varian barang berhasil ditambahkan.');
    }

    public function update(Request $request, barang_varian $barang_varian): RedirectResponse
    {
        abort_if($barang_varian->isDefault(), 404);

        $validated = $request->validate([
            'idsubbarang' => ['required', 'integer', 'exists:barang_sub,idsubbarang'],
            'kodevarian' => ['required', 'string', 'max:100'],
            'namavarian' => ['required', 'string', 'max:191', 'not_in:-'],
        ]);

        $request->validate([
            'kodevarian' => [
                Rule::unique('barang_varian', 'kodevarian')
                    ->where(fn ($query) => $query->where('idsubbarang', $validated['idsubbarang']))
                    ->ignore($barang_varian->idvarian, 'idvarian'),
            ],
        ], [
            'kodevarian.unique' => 'Kode varian ini sudah dipakai untuk sub barang yang dipilih.',
        ]);

        $barang_varian->update($validated);

        return redirect()->route('barang-varian.index')->with('status', 'Varian barang berhasil diperbarui.');
    }

    public function destroy(barang_varian $barang_varian): RedirectResponse
    {
        abort_if($barang_varian->isDefault(), 404);

        $subBarang = $barang_varian->subBarang;
        $barang_varian->delete();

        if ($subBarang && $subBarang->varian()->count() === 0) {
            $subBarang->ensureDefaultVarian();
        }

        return redirect()->route('barang-varian.index')->with('status', 'Varian barang berhasil dihapus.');
    }
}
