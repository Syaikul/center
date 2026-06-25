<?php

namespace App\Http\Controllers;

use App\Models\tipe;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class TipeController extends Controller
{
    public function index(): View
    {
        $tipes = tipe::query()->orderBy('nama_tipe')->get();

        return view('tipe.index', compact('tipes'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_tipe' => ['required', 'string', 'max:191', 'unique:tipe,nama_tipe'],
        ]);

        tipe::query()->create($validated);

        return redirect()->route('tipe.index')->with('status', 'Tipe berhasil ditambahkan.');
    }

    public function update(Request $request, tipe $tipe): RedirectResponse
    {
        $validated = $request->validate([
            'nama_tipe' => [
                'required',
                'string',
                'max:191',
                Rule::unique('tipe', 'nama_tipe')->ignore($tipe->idtipe, 'idtipe'),
            ],
        ]);

        $tipe->update($validated);

        return redirect()->route('tipe.index')->with('status', 'Tipe berhasil diperbarui.');
    }

    public function destroy(tipe $tipe): RedirectResponse
    {
        $tipe->delete();

        return redirect()->route('tipe.index')->with('status', 'Tipe berhasil dihapus.');
    }
}
