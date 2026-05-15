<?php

namespace App\Http\Controllers;

use App\Models\barang;
use App\Models\barang_varian;
use App\Models\kategori;
use App\Models\satuan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class BarangController extends Controller
{
    public function index(Request $request): View
    {
        $barangs = barang::query()
            ->with('kategori')
            ->withCount('varian')
            ->orderBy('namabarang')
            ->get();

        $kategoris = kategori::query()->orderBy('nama_kategori')->get();
        $satuans = satuan::query()->orderBy('nama_satuan')->get();

        $selectedBarang = null;
        $varians = collect();

        if ($request->filled('barang')) {
            $selectedBarang = barang::query()
                ->with('kategori')
                ->find($request->integer('barang'));

            if ($selectedBarang) {
                $varians = $selectedBarang->varian()->orderBy('namavarian')->get();
            }
        }

        return view('barang.index', compact('barangs', 'kategoris', 'satuans', 'selectedBarang', 'varians'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'kodebarang' => ['required', 'string', 'max:100', 'unique:barang,kodebarang'],
            'namabarang' => ['required', 'string', 'max:191', 'unique:barang,namabarang'],
            'idkategori' => ['required', 'integer', 'exists:kategori,idkategori'],
            'idsatuan' => ['required', 'integer', 'exists:satuan,idsatuan'],
        ]);

        barang::query()->create($validated);

        return redirect()->route('barang.index')->with('status', 'Barang berhasil ditambahkan.');
    }

    public function update(Request $request, barang $barang): RedirectResponse
    {
        $validated = $request->validate([
            'kodebarang' => [
                'required',
                'string',
                'max:100',
                Rule::unique('barang', 'kodebarang')->ignore($barang->idbarang, 'idbarang'),
            ],
            'namabarang' => [
                'required',
                'string',
                'max:191',
                Rule::unique('barang', 'namabarang')->ignore($barang->idbarang, 'idbarang'),
            ],
            'idkategori' => ['required', 'integer', 'exists:kategori,idkategori'],
            'idsatuan' => ['required', 'integer', 'exists:satuan,idsatuan'],
        ]);

        $barang->update($validated);

        return redirect()
            ->route('barang.index', ['barang' => $barang->idbarang])
            ->with('status', 'Barang berhasil diperbarui.');
    }

    public function destroy(barang $barang): RedirectResponse
    {
        $barang->delete();

        return redirect()->route('barang.index')->with('status', 'Barang berhasil dihapus.');
    }

    public function storeVarian(Request $request, barang $barang): RedirectResponse
    {
        $validated = $request->validate([
            'kodevarian' => ['required', 'string', 'max:100'],
            'namavarian' => ['required', 'string', 'max:191'],
        ]);

        $request->validate([
            'kodevarian' => [
                Rule::unique('barang_varian', 'kodevarian')
                    ->where(fn ($query) => $query->where('idbarang', $barang->idbarang)),
            ],
        ], [
            'kodevarian.unique' => 'Kode varian ini sudah dipakai untuk barang ini.',
        ]);

        $barang->varian()->create($validated);

        return redirect()
            ->route('barang.index', ['barang' => $barang->idbarang])
            ->with('status', 'Varian berhasil ditambahkan.');
    }

    public function updateVarian(Request $request, barang $barang, barang_varian $barang_varian): RedirectResponse
    {
        abort_unless($barang_varian->idbarang === $barang->idbarang, 404);

        $validated = $request->validate([
            'kodevarian' => ['required', 'string', 'max:100'],
            'namavarian' => ['required', 'string', 'max:191'],
        ]);

        $request->validate([
            'kodevarian' => [
                Rule::unique('barang_varian', 'kodevarian')
                    ->where(fn ($query) => $query->where('idbarang', $barang->idbarang))
                    ->ignore($barang_varian->idvarian, 'idvarian'),
            ],
        ], [
            'kodevarian.unique' => 'Kode varian ini sudah dipakai untuk barang ini.',
        ]);

        $barang_varian->update($validated);

        return redirect()
            ->route('barang.index', ['barang' => $barang->idbarang])
            ->with('status', 'Varian berhasil diperbarui.');
    }

    public function destroyVarian(barang $barang, barang_varian $barang_varian): RedirectResponse
    {
        abort_unless($barang_varian->idbarang === $barang->idbarang, 404);

        $barang_varian->delete();

        return redirect()
            ->route('barang.index', ['barang' => $barang->idbarang])
            ->with('status', 'Varian berhasil dihapus.');
    }
}
