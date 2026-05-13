<?php

namespace App\Http\Controllers;

use App\Models\gudang;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class GudangController extends Controller
{
    public function index(): View
    {
        $gudangs = gudang::query()->orderBy('namagudang')->get();

        return view('gudang.index', compact('gudangs'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'namagudang' => ['required', 'string', 'max:191', 'unique:gudang,namagudang'],
            'nomorkontrak' => ['nullable', 'string', 'max:191'],
        ]);

        gudang::query()->create($validated);

        return redirect()->route('gudang.index')->with('status', 'Gudang berhasil ditambahkan.');
    }

    public function update(Request $request, gudang $gudang): RedirectResponse
    {
        $validated = $request->validate([
            'namagudang' => [
                'required',
                'string',
                'max:191',
                Rule::unique('gudang', 'namagudang')->ignore($gudang->idgudang, 'idgudang'),
            ],
            'nomorkontrak' => ['nullable', 'string', 'max:191'],
        ]);

        $gudang->update($validated);

        return redirect()->route('gudang.index')->with('status', 'Gudang berhasil diperbarui.');
    }

    public function destroy(gudang $gudang): RedirectResponse
    {
        $gudang->delete();

        return redirect()->route('gudang.index')->with('status', 'Gudang berhasil dihapus.');
    }
}
