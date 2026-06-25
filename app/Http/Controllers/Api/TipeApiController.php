<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\tipe;
use Illuminate\Http\JsonResponse;

class TipeApiController extends Controller
{
    public function index(): JsonResponse
    {
        $data = tipe::query()
            ->orderBy('nama_tipe')
            ->get();

        return response()->json([
            'data' => $data,
        ]);
    }
}
