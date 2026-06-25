<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\personel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PersonelApiController extends Controller
{
    public function index(): JsonResponse
    {
        $data = personel::query()
            ->orderBy('namapersonel')
            ->get();

        return response()->json([
            'data' => $data,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nik' => ['required', 'string', 'max:50', 'unique:personel,nik'],
            'namapersonel' => ['required', 'string', 'max:191', 'unique:personel,namapersonel'],
        ]);

        $data = personel::query()->create($validated);

        return response()->json([
            'message' => 'Personel berhasil ditambahkan.',
            'data' => $data,
        ], 201);
    }

    public function show(personel $personel): JsonResponse
    {
        return response()->json([
            'data' => $personel,
        ]);
    }

    public function update(Request $request, personel $personel): JsonResponse
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

        return response()->json([
            'message' => 'Personel berhasil diperbarui.',
            'data' => $personel->fresh(),
        ]);
    }

    public function destroy(personel $personel): JsonResponse
    {
        $personel->delete();

        return response()->json([
            'message' => 'Personel berhasil dihapus.',
        ]);
    }
}
