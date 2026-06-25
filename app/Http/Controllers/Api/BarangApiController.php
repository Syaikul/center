<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\barang;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BarangApiController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = barang::query()
            ->with(['tipe', 'satuan'])
            ->orderBy('namabarang');

        if ($request->filled('tipe')) {
            $namaTipe = $request->string('tipe')->trim();

            $query->whereHas('tipe', function ($q) use ($namaTipe) {
                $q->where('nama_tipe', $namaTipe);
            });
        }

        $data = $query->get();

        return response()->json([
            'data' => $data,
            'meta' => [
                'tipe' => $request->input('tipe'),
                'count' => $data->count(),
            ],
        ]);
    }

    public function withVarian(): JsonResponse
    {
        $data = barang::query()
            ->with([
                'tipe',
                'satuan',
                'subBarang' => fn ($query) => $query->with([
                    'barang',
                    'varian' => fn ($q) => $q->nonDefault(),
                ]),
            ])
            ->withCount(['subBarang', 'varian'])
            ->orderBy('namabarang')
            ->get();

        return response()->json([
            'data' => $data,
        ]);
    }
}
