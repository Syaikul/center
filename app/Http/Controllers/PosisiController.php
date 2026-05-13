<?php

namespace App\Http\Controllers;

use App\Models\posisi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PosisiController extends Controller
{
    public function index(): View
    {
        $posisis = posisi::query()->orderBy('namaposisi')->get();

        return view('posisi.index', compact('posisis'));
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

        return redirect()->route('posisi.index')->with('status', 'Posisi berhasil diperbarui.');
    }

    public function destroy(posisi $posisi): RedirectResponse
    {
        $posisi->delete();

        return redirect()->route('posisi.index')->with('status', 'Posisi berhasil dihapus.');
    }
}
