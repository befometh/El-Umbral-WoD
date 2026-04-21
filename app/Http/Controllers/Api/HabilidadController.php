<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Enums\TipoHabilidad;
use App\Models\Habilidad;
use Illuminate\Http\JsonResponse;

class HabilidadController extends Controller
{
    public function index(): JsonResponse
    {
        // 1. Obtenemos todas las habilidades
        $habilidades = Habilidad::all();

        // 2. Agrupamos y transformamos las llaves usando el Enum
        $agrupadas = $habilidades->groupBy('tipo')->mapWithKeys(function ($item, $key) {
            // Intentamos obtener el label desde el Enum usando el ID (la llave)
            $label = TipoHabilidad::tryFrom($key)?->label() ?? 'Sin Asignar';
            return [$label => $item];
        });

        return response()->json([
            'success' => true,
            'data' => $agrupadas
        ]);
    }
    public function show(int $id): JsonResponse{
        $habilidad = Habilidad::find($id);
        if($habilidad){
            return response()->json([
                'success' => true,
                'data' => $habilidad
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Habilidad no encontrada'
            ]);
        }
    }

    //Ahora, si queremos obtenerlas todas de manera agrupada por tipo tendríamos lo siguiente:
    public function porTipo(int $id): JsonResponse{
        //Busca en el Enum correspondiente, (1 => 'Talentos', 2 => 'Técnicas', 3 => ..., etc)
        $tipoLista = TipoHabilidad::tryFrom($id);
        $habilidades = Habilidad::where('tipo', $id)->get();
        if($habilidades->isEmpty()&&!$tipoLista){
            return response()->json([
                'success' => false,
                'message' => 'No se ha encontrado información'
            ],404);
        }

        return response()->json([
            'success' => true,
            'categoria' => $tipoLista?$tipoLista->label():'Sin Asignar',
            'data' => $habilidades
        ]);
    }
}
