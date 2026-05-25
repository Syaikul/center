<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\kategori;
use Illuminate\Http\JsonResponse;

class KategoriApiController extends Controller
{
    public function index(): JsonResponse
    {
        $data = kategori::query()
            ->orderBy('nama_kategori')
            ->get();

        return response()->json([
            'data' => $data,
        ]);
    }
}
