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
            ->with(['kategori', 'satuan'])
            ->orderBy('namabarang');

        if ($request->filled('kategori')) {
            $namaKategori = $request->string('kategori')->trim();

            $query->whereHas('kategori', function ($q) use ($namaKategori) {
                $q->where('nama_kategori', $namaKategori);
            });
        }

        $data = $query->get();

        return response()->json([
            'data' => $data,
            'meta' => [
                'kategori' => $request->input('kategori'),
                'count' => $data->count(),
            ],
        ]);
    }

    public function withVarian(): JsonResponse
    {
        $data = barang::query()
            ->with([
                'kategori',
                'satuan',
                'subBarang' => fn ($query) => $query->with([
                    'barang',
                    'varian.subBarang.barang',
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
