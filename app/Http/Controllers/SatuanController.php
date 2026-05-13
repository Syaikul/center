<?php

namespace App\Http\Controllers;

use App\Models\satuan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class SatuanController extends Controller
{
    public function index(): View
    {
        $satuans = satuan::query()->orderBy('nama_satuan')->get();

        return view('satuan.index', compact('satuans'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_satuan' => ['required', 'string', 'max:191', 'unique:satuan,nama_satuan'],
        ]);

        satuan::query()->create($validated);

        return redirect()->route('satuan.index')->with('status', 'Satuan berhasil ditambahkan.');
    }

    public function update(Request $request, satuan $satuan): RedirectResponse
    {
        $validated = $request->validate([
            'nama_satuan' => [
                'required',
                'string',
                'max:191',
                Rule::unique('satuan', 'nama_satuan')->ignore($satuan->idsatuan, 'idsatuan'),
            ],
        ]);

        $satuan->update($validated);

        return redirect()->route('satuan.index')->with('status', 'Satuan berhasil diperbarui.');
    }

    public function destroy(satuan $satuan): RedirectResponse
    {
        $satuan->delete();

        return redirect()->route('satuan.index')->with('status', 'Satuan berhasil dihapus.');
    }
}
