<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Disciplina;
use Illuminate\Http\JsonResponse;

class DisciplinaController extends Controller
{
    public function index(): JsonResponse{
        return response()->json(Disciplina::where('visible', false)->get());
    }

    public function show(int $id): JsonResponse{
        return response()->json(Disciplina::where('id', $id)->first());
    }

    public function showConPuntos(int $id, int $nivel): JsonResponse{
        //1. Buscamos la disciplina correspondiente
        $disciplina = Disciplina::find($id);

        //2. Si no se encuentra la disciplina retorna fallo y envía un anuncio
        if(!$disciplina){
            return response()->json([
                'success'=>false,
                'message'=>'Disciplina no encontrada'
            ],404);
        }

        //3. Traemos sus niveles asociados desde DisciplinaNiveles, los llamaremos puntos, ya que en el juego se representa
        //con eso mismo
        $puntos = $disciplina->puntosAdquiridos($nivel);

        //Enviamos la información completa
        return response()->json([
            'success'=>true,
            'data' => [
                'disciplina' => $disciplina->nombre,
                'descripcion' => $disciplina->descripcion,
                'logo' => $disciplina->logo,
                'nivel_adquirido' => $nivel,
                //Si está vacío y no se han asignado puntos enviamos un mensaje
                'puntos' => empty($puntos)?'Aún no se han asignado puntos a esta disciplina': $puntos
            ]
        ]);
    }
}
