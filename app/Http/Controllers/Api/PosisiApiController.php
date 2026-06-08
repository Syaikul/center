<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\posisi;
use Illuminate\Http\JsonResponse;

class PosisiApiController extends Controller
{
    public function index(): JsonResponse
    {
        $data = posisi::query()
            ->withCount('items')
            ->orderBy('namaposisi')
            ->get();

        return response()->json([
            'data' => $data,
        ]);
    }

    public function ppe(posisi $posisi): JsonResponse
    {
        $items = $posisi->items()
            ->with(['subBarang.barang.kategori', 'subBarang.barang.satuan'])
            ->orderBy('idposppe')
            ->get();

        return response()->json([
            'data' => [
                'posisi' => $posisi,
                'ppe' => $items,
            ],
        ]);
    }
}
