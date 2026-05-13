<?php

namespace App\Http\Controllers;

use App\Models\barang;
use App\Models\posisi;
use App\Models\posisippe;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PosisippeController extends Controller
{
    public function index(): View
    {
        $posisippes = posisippe::query()
            ->with(['posisi', 'barang'])
            ->orderBy('idposppe', 'desc')
            ->get();
        $posisis = posisi::query()->orderBy('namaposisi')->get();
        $barangs = barang::query()->orderBy('namabarang')->get();

        return view('posisippe.index', compact('posisippes', 'posisis', 'barangs'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'idposisi' => ['required', 'integer', 'exists:posisi,idposisi'],
            'idbarang' => ['required', 'integer', 'exists:barang,idbarang'],
            'qty' => ['required', 'integer', 'min:1'],
        ]);

        $request->validate([
            'idbarang' => [
                Rule::unique('posisippe', 'idbarang')
                    ->where(fn ($query) => $query->where('idposisi', $validated['idposisi'])),
            ],
        ], [
            'idbarang.unique' => 'Barang ini sudah terdaftar pada posisi tersebut.',
        ]);

        posisippe::query()->create($validated);

        return redirect()->route('posisippe.index')->with('status', 'Mapping posisi-PPE berhasil ditambahkan.');
    }

    public function update(Request $request, posisippe $posisippe): RedirectResponse
    {
        $validated = $request->validate([
            'idposisi' => ['required', 'integer', 'exists:posisi,idposisi'],
            'idbarang' => ['required', 'integer', 'exists:barang,idbarang'],
            'qty' => ['required', 'integer', 'min:1'],
        ]);

        $request->validate([
            'idbarang' => [
                Rule::unique('posisippe', 'idbarang')
                    ->where(fn ($query) => $query->where('idposisi', $validated['idposisi']))
                    ->ignore($posisippe->idposppe, 'idposppe'),
            ],
        ], [
            'idbarang.unique' => 'Barang ini sudah terdaftar pada posisi tersebut.',
        ]);

        $posisippe->update($validated);

        return redirect()->route('posisippe.index')->with('status', 'Mapping posisi-PPE berhasil diperbarui.');
    }

    public function destroy(posisippe $posisippe): RedirectResponse
    {
        $posisippe->delete();

        return redirect()->route('posisippe.index')->with('status', 'Mapping posisi-PPE berhasil dihapus.');
    }
}
