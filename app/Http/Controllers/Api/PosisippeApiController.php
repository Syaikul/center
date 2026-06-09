<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\posisippe;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PosisippeApiController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = posisippe::query()
            ->with([
                'posisi',
                'subBarang.barang.kategori',
                'subBarang.barang.satuan',
            ])
            ->orderBy('idposisi')
            ->orderBy('idposppe');

        if ($request->filled('posisi')) {
            $query->where('idposisi', $request->integer('posisi'));
        }

        $data = $query->get();

        return response()->json([
            'data' => $data,
            'meta' => [
                'count' => $data->count(),
                'posisi' => $request->input('posisi'),
            ],
        ]);
    }
}
