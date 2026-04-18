<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Clan;
use Illuminate\Http\JsonResponse;

class ClanController extends Controller
{
    /*
     * Devuelve la lista de clanes visibles por el jugador
     */
    public function index(): JsonResponse{
        $clanes = Clan::with('padre')
            ->where("visible", true)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $clanes
        ]);
    }

    public function show(int $id): JsonResponse{
        $clan = Clan::with('padre', 'hijos')->find($id);
        if(!$clan){
            return response()->json([
                'success' => false,
                'message' => 'Clan no encontrado'
            ],404);
        }

        return response()->json([
            'success' => true,
            'data' => $clan
        ]);
    }
}
