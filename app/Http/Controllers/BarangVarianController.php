<?php

namespace App\Http\Controllers;

use App\Models\barang;
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
            ->with('barang')
            ->orderBy('idvarian', 'desc')
            ->get();
        $barangs = barang::query()->orderBy('namabarang')->get();

        return view('barang-varian.index', compact('varians', 'barangs'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'idbarang' => ['required', 'integer', 'exists:barang,idbarang'],
            'kodevarian' => ['required', 'string', 'max:100'],
            'namavarian' => ['required', 'string', 'max:191'],
        ]);

        $request->validate([
            'kodevarian' => [
                Rule::unique('barang_varian', 'kodevarian')
                    ->where(fn ($query) => $query->where('idbarang', $validated['idbarang'])),
            ],
        ], [
            'kodevarian.unique' => 'Kode varian ini sudah dipakai untuk barang yang dipilih.',
        ]);

        barang_varian::query()->create($validated);

        return redirect()->route('barang-varian.index')->with('status', 'Varian barang berhasil ditambahkan.');
    }

    public function update(Request $request, barang_varian $barang_varian): RedirectResponse
    {
        $validated = $request->validate([
            'idbarang' => ['required', 'integer', 'exists:barang,idbarang'],
            'kodevarian' => ['required', 'string', 'max:100'],
            'namavarian' => ['required', 'string', 'max:191'],
        ]);

        $request->validate([
            'kodevarian' => [
                Rule::unique('barang_varian', 'kodevarian')
                    ->where(fn ($query) => $query->where('idbarang', $validated['idbarang']))
                    ->ignore($barang_varian->idvarian, 'idvarian'),
            ],
        ], [
            'kodevarian.unique' => 'Kode varian ini sudah dipakai untuk barang yang dipilih.',
        ]);

        $barang_varian->update($validated);

        return redirect()->route('barang-varian.index')->with('status', 'Varian barang berhasil diperbarui.');
    }

    public function destroy(barang_varian $barang_varian): RedirectResponse
    {
        $barang_varian->delete();

        return redirect()->route('barang-varian.index')->with('status', 'Varian barang berhasil dihapus.');
    }
}
