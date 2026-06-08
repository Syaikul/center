<?php

namespace App\Http\Controllers;

use App\Models\barang;
use App\Models\barang_sub;
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
            ->withCount('subBarang')
            ->orderBy('namabarang')
            ->get();

        $kategoris = kategori::query()->orderBy('nama_kategori')->get();
        $satuans = satuan::query()->orderBy('nama_satuan')->get();

        $selectedBarang = null;
        $selectedSubBarang = null;
        $subBarangs = collect();
        $varians = collect();
        $hasOnlyDefaultVarian = false;

        if ($request->filled('barang')) {
            $selectedBarang = barang::query()
                ->with('kategori')
                ->find($request->integer('barang'));

            if ($selectedBarang) {
                $subBarangs = $selectedBarang->subBarang()
                    ->with(['varian'])
                    ->orderBy('namasubbarang')
                    ->get();

                if ($request->filled('subbarang')) {
                    $selectedSubBarang = barang_sub::query()
                        ->where('idbarang', $selectedBarang->idbarang)
                        ->find($request->integer('subbarang'));

                    if ($selectedSubBarang) {
                        $hasOnlyDefaultVarian = $selectedSubBarang->hasOnlyDefaultVarian();
                        $varians = $selectedSubBarang->varian()
                            ->nonDefault()
                            ->orderBy('namavarian')
                            ->get();
                    }
                }
            }
        }

        return view('barang.index', compact(
            'barangs',
            'kategoris',
            'satuans',
            'selectedBarang',
            'selectedSubBarang',
            'subBarangs',
            'varians',
            'hasOnlyDefaultVarian'
        ));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'kodebarang' => ['required', 'string', 'max:100', 'unique:barang,kodebarang'],
            'namabarang' => ['required', 'string', 'max:191', 'unique:barang,namabarang'],
            'idkategori' => ['required', 'integer', 'exists:kategori,idkategori'],
            'idsatuan' => ['required', 'integer', 'exists:satuan,idsatuan'],
            'detail_tambahan' => ['nullable', 'string', 'max:5000'],
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
            'detail_tambahan' => ['nullable', 'string', 'max:5000'],
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

    public function storeSubBarang(Request $request, barang $barang): RedirectResponse
    {
        $validated = $request->validate([
            'kodesubbarang' => ['required', 'string', 'max:100'],
            'namasubbarang' => ['required', 'string', 'max:191'],
        ]);

        $request->validate([
            'kodesubbarang' => [
                Rule::unique('barang_sub', 'kodesubbarang')
                    ->where(fn ($query) => $query->where('idbarang', $barang->idbarang)),
            ],
        ], [
            'kodesubbarang.unique' => 'Kode sub barang ini sudah dipakai untuk barang ini.',
        ]);

        $subBarang = $barang->subBarang()->create($validated);
        $subBarang->ensureDefaultVarian();

        return redirect()
            ->route('barang.index', ['barang' => $barang->idbarang])
            ->with('status', 'Sub barang berhasil ditambahkan.');
    }

    public function updateSubBarang(Request $request, barang $barang, barang_sub $barang_sub): RedirectResponse
    {
        abort_unless($barang_sub->idbarang === $barang->idbarang, 404);

        $validated = $request->validate([
            'kodesubbarang' => ['required', 'string', 'max:100'],
            'namasubbarang' => ['required', 'string', 'max:191'],
        ]);

        $request->validate([
            'kodesubbarang' => [
                Rule::unique('barang_sub', 'kodesubbarang')
                    ->where(fn ($query) => $query->where('idbarang', $barang->idbarang))
                    ->ignore($barang_sub->idsubbarang, 'idsubbarang'),
            ],
        ], [
            'kodesubbarang.unique' => 'Kode sub barang ini sudah dipakai untuk barang ini.',
        ]);

        $barang_sub->update($validated);

        return redirect()
            ->route('barang.index', [
                'barang' => $barang->idbarang,
                'subbarang' => $barang_sub->idsubbarang,
            ])
            ->with('status', 'Sub barang berhasil diperbarui.');
    }

    public function destroySubBarang(barang $barang, barang_sub $barang_sub): RedirectResponse
    {
        abort_unless($barang_sub->idbarang === $barang->idbarang, 404);

        $barang_sub->delete();

        return redirect()
            ->route('barang.index', ['barang' => $barang->idbarang])
            ->with('status', 'Sub barang berhasil dihapus.');
    }

    public function storeVarian(Request $request, barang $barang, barang_sub $barang_sub): RedirectResponse
    {
        abort_unless($barang_sub->idbarang === $barang->idbarang, 404);

        $validated = $request->validate([
            'kodevarian' => ['required', 'string', 'max:100'],
            'namavarian' => ['required', 'string', 'max:191', 'not_in:-'],
        ]);

        $request->validate([
            'kodevarian' => [
                Rule::unique('barang_varian', 'kodevarian')
                    ->where(fn ($query) => $query->where('idsubbarang', $barang_sub->idsubbarang)),
            ],
        ], [
            'kodevarian.unique' => 'Kode varian ini sudah dipakai untuk sub barang ini.',
        ]);

        if ($barang_sub->hasOnlyDefaultVarian()) {
            $barang_sub->defaultVarian()?->delete();
        }

        $barang_sub->varian()->create($validated);

        return redirect()
            ->route('barang.index', [
                'barang' => $barang->idbarang,
                'subbarang' => $barang_sub->idsubbarang,
            ])
            ->with('status', 'Varian berhasil ditambahkan.');
    }

    public function updateVarian(Request $request, barang $barang, barang_sub $barang_sub, barang_varian $barang_varian): RedirectResponse
    {
        abort_unless($barang_sub->idbarang === $barang->idbarang, 404);
        abort_unless($barang_varian->idsubbarang === $barang_sub->idsubbarang, 404);
        abort_if($barang_varian->isDefault(), 404);

        $validated = $request->validate([
            'kodevarian' => ['required', 'string', 'max:100'],
            'namavarian' => ['required', 'string', 'max:191', 'not_in:-'],
        ]);

        $request->validate([
            'kodevarian' => [
                Rule::unique('barang_varian', 'kodevarian')
                    ->where(fn ($query) => $query->where('idsubbarang', $barang_sub->idsubbarang))
                    ->ignore($barang_varian->idvarian, 'idvarian'),
            ],
        ], [
            'kodevarian.unique' => 'Kode varian ini sudah dipakai untuk sub barang ini.',
        ]);

        $barang_varian->update($validated);

        return redirect()
            ->route('barang.index', [
                'barang' => $barang->idbarang,
                'subbarang' => $barang_sub->idsubbarang,
            ])
            ->with('status', 'Varian berhasil diperbarui.');
    }

    public function destroyVarian(barang $barang, barang_sub $barang_sub, barang_varian $barang_varian): RedirectResponse
    {
        abort_unless($barang_sub->idbarang === $barang->idbarang, 404);
        abort_unless($barang_varian->idsubbarang === $barang_sub->idsubbarang, 404);
        abort_if($barang_varian->isDefault(), 404);

        $barang_varian->delete();

        if ($barang_sub->varian()->count() === 0) {
            $barang_sub->ensureDefaultVarian();
        }

        return redirect()
            ->route('barang.index', [
                'barang' => $barang->idbarang,
                'subbarang' => $barang_sub->idsubbarang,
            ])
            ->with('status', 'Varian berhasil dihapus.');
    }
}
