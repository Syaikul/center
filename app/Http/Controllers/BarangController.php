<?php

namespace App\Http\Controllers;

use App\Models\barang;
use App\Models\kategori;
use App\Models\satuan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class BarangController extends Controller
{
    public function index(): View
    {
        $barangs = barang::query()
            ->with(['kategori', 'satuan'])
            ->orderBy('namabarang')
            ->get();
        $kategoris = kategori::query()->orderBy('nama_kategori')->get();
        $satuans = satuan::query()->orderBy('nama_satuan')->get();

        return view('barang.index', compact('barangs', 'kategoris', 'satuans'));
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

        return redirect()->route('barang.index')->with('status', 'Barang berhasil diperbarui.');
    }

    public function destroy(barang $barang): RedirectResponse
    {
        $barang->delete();

        return redirect()->route('barang.index')->with('status', 'Barang berhasil dihapus.');
    }
}
