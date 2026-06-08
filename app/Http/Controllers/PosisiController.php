<?php

namespace App\Http\Controllers;

use App\Models\barang_sub;
use App\Models\posisi;
use App\Models\posisippe;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PosisiController extends Controller
{
    public function index(Request $request): View
    {
        $posisis = posisi::query()
            ->withCount('items')
            ->orderBy('namaposisi')
            ->get();

        $subBarangs = barang_sub::query()
            ->with('barang')
            ->orderBy('namasubbarang')
            ->get();

        $selectedPosisi = null;
        $items = collect();

        if ($request->filled('posisi')) {
            $selectedPosisi = posisi::query()->find($request->integer('posisi'));

            if ($selectedPosisi) {
                $items = $selectedPosisi->items()
                    ->with('subBarang.barang')
                    ->orderBy('idposppe')
                    ->get();
            }
        }

        return view('posisi.index', compact('posisis', 'subBarangs', 'selectedPosisi', 'items'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'namaposisi' => ['required', 'string', 'max:191', 'unique:posisi,namaposisi'],
        ]);

        posisi::query()->create($validated);

        return redirect()->route('posisi.index')->with('status', 'Posisi berhasil ditambahkan.');
    }

    public function update(Request $request, posisi $posisi): RedirectResponse
    {
        $validated = $request->validate([
            'namaposisi' => [
                'required',
                'string',
                'max:191',
                Rule::unique('posisi', 'namaposisi')->ignore($posisi->idposisi, 'idposisi'),
            ],
        ]);

        $posisi->update($validated);

        return redirect()
            ->route('posisi.index', ['posisi' => $posisi->idposisi])
            ->with('status', 'Posisi berhasil diperbarui.');
    }

    public function destroy(posisi $posisi): RedirectResponse
    {
        $posisi->delete();

        return redirect()->route('posisi.index')->with('status', 'Posisi berhasil dihapus.');
    }

    public function storeItem(Request $request, posisi $posisi): RedirectResponse
    {
        $validated = $request->validate([
            'idsubbarang' => ['required', 'integer', 'exists:barang_sub,idsubbarang'],
            'qty' => ['required', 'integer', 'min:1'],
        ]);

        $request->validate([
            'idsubbarang' => [
                Rule::unique('posisippe', 'idsubbarang')
                    ->where(fn ($query) => $query->where('idposisi', $posisi->idposisi)),
            ],
        ], [
            'idsubbarang.unique' => 'Sub barang ini sudah terdaftar pada posisi ini.',
        ]);

        $posisi->items()->create([
            'idsubbarang' => $validated['idsubbarang'],
            'qty' => $validated['qty'],
        ]);

        return redirect()
            ->route('posisi.index', ['posisi' => $posisi->idposisi])
            ->with('status', 'Item berhasil ditambahkan.');
    }

    public function updateItem(Request $request, posisi $posisi, posisippe $posisippe): RedirectResponse
    {
        abort_unless($posisippe->idposisi === $posisi->idposisi, 404);

        $validated = $request->validate([
            'idsubbarang' => ['required', 'integer', 'exists:barang_sub,idsubbarang'],
            'qty' => ['required', 'integer', 'min:1'],
        ]);

        $request->validate([
            'idsubbarang' => [
                Rule::unique('posisippe', 'idsubbarang')
                    ->where(fn ($query) => $query->where('idposisi', $posisi->idposisi))
                    ->ignore($posisippe->idposppe, 'idposppe'),
            ],
        ], [
            'idsubbarang.unique' => 'Sub barang ini sudah terdaftar pada posisi ini.',
        ]);

        $posisippe->update($validated);

        return redirect()
            ->route('posisi.index', ['posisi' => $posisi->idposisi])
            ->with('status', 'Item berhasil diperbarui.');
    }

    public function destroyItem(posisi $posisi, posisippe $posisippe): RedirectResponse
    {
        abort_unless($posisippe->idposisi === $posisi->idposisi, 404);

        $posisippe->delete();

        return redirect()
            ->route('posisi.index', ['posisi' => $posisi->idposisi])
            ->with('status', 'Item berhasil dihapus.');
    }
}
