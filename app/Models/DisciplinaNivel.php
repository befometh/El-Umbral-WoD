<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;

class DisciplinaNivel extends Model
{
    protected $table = 'disciplina_niveles';
    protected $fillable = [
        'disciplina_id', 'nivel', 'nombre', 'descripcion', 'sistema',
        'pool_dados_lanzados', 'pool_stats_pasivos', 'pool_stats_activos',
        'comportamiento', 'duracion', 'costes', 'msj_info', 'visible'
    ];

    public function show(int $id): JsonResponse{
        $poder = DisciplinaNivel::where('id', $id)->first();
        if($poder) return response()->json([
            'success' => true,
            'data' => $poder
        ]);
        else return response()->json([
            'success' => false,
            'message' => 'Aún no hay puntos asignados'
        ]);
    }

    protected function casts(): array
    {
        return [
            'pool_dados_lanzados' => 'array',
            'pool_stats_pasivos'  => 'array',
            'pool_stats_activos'  => 'array',
            'costes'              => 'array',
            'msj_info'            => 'array',
            'comportamiento'      => 'integer',
            'duracion'            => 'integer',
            'visible'             => 'boolean',
        ];
    }
}
