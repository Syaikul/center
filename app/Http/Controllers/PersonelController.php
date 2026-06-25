<?php

namespace App\Http\Controllers;

use App\Models\personel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PersonelController extends Controller
{
    public function index(): View
    {
        $personels = personel::query()->orderBy('namapersonel')->get();

        return view('personel.index', compact('personels'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nik' => ['required', 'string', 'max:50', 'unique:personel,nik'],
            'namapersonel' => ['required', 'string', 'max:191', 'unique:personel,namapersonel'],
        ]);

        personel::query()->create($validated);

        return redirect()->route('personel.index')->with('status', 'Personel berhasil ditambahkan.');
    }

    public function update(Request $request, personel $personel): RedirectResponse
    {
        $validated = $request->validate([
            'nik' => [
                'required',
                'string',
                'max:50',
                Rule::unique('personel', 'nik')->ignore($personel->idpersonel, 'idpersonel'),
            ],
            'namapersonel' => [
                'required',
                'string',
                'max:191',
                Rule::unique('personel', 'namapersonel')->ignore($personel->idpersonel, 'idpersonel'),
            ],
        ]);

        $personel->update($validated);

        return redirect()->route('personel.index')->with('status', 'Personel berhasil diperbarui.');
    }

    public function destroy(personel $personel): RedirectResponse
    {
        $personel->delete();

        return redirect()->route('personel.index')->with('status', 'Personel berhasil dihapus.');
    }
}
