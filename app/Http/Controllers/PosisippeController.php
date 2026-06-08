<?php

namespace App\Http\Controllers;

use App\Models\barang_sub;
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
            ->with(['posisi', 'subBarang.barang'])
            ->orderBy('idposppe', 'desc')
            ->get();
        $posisis = posisi::query()->orderBy('namaposisi')->get();
        $subBarangs = barang_sub::query()->with('barang')->orderBy('namasubbarang')->get();

        return view('posisippe.index', compact('posisippes', 'posisis', 'subBarangs'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'idposisi' => ['required', 'integer', 'exists:posisi,idposisi'],
            'idsubbarang' => ['required', 'integer', 'exists:barang_sub,idsubbarang'],
            'qty' => ['required', 'integer', 'min:1'],
        ]);

        $request->validate([
            'idsubbarang' => [
                Rule::unique('posisippe', 'idsubbarang')
                    ->where(fn ($query) => $query->where('idposisi', $validated['idposisi'])),
            ],
        ], [
            'idsubbarang.unique' => 'Sub barang ini sudah terdaftar pada posisi tersebut.',
        ]);

        posisippe::query()->create($validated);

        return redirect()->route('posisippe.index')->with('status', 'Mapping posisi-PPE berhasil ditambahkan.');
    }

    public function update(Request $request, posisippe $posisippe): RedirectResponse
    {
        $validated = $request->validate([
            'idposisi' => ['required', 'integer', 'exists:posisi,idposisi'],
            'idsubbarang' => ['required', 'integer', 'exists:barang_sub,idsubbarang'],
            'qty' => ['required', 'integer', 'min:1'],
        ]);

        $request->validate([
            'idsubbarang' => [
                Rule::unique('posisippe', 'idsubbarang')
                    ->where(fn ($query) => $query->where('idposisi', $validated['idposisi']))
                    ->ignore($posisippe->idposppe, 'idposppe'),
            ],
        ], [
            'idsubbarang.unique' => 'Sub barang ini sudah terdaftar pada posisi tersebut.',
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
