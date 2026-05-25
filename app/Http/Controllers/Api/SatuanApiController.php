<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\satuan;
use Illuminate\Http\JsonResponse;

class SatuanApiController extends Controller
{
    public function index(): JsonResponse
    {
        $data = satuan::query()
            ->orderBy('nama_satuan')
            ->get();

        return response()->json([
            'data' => $data,
        ]);
    }
}
