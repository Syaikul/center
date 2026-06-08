<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\gudang;
use Illuminate\Http\JsonResponse;

class GudangApiController extends Controller
{
    public function index(): JsonResponse
    {
        $data = gudang::query()
            ->orderBy('namagudang')
            ->get();

        return response()->json([
            'data' => $data,
        ]);
    }
}
