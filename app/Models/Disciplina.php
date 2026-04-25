<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\JsonResponse;
use function PHPUnit\Framework\isEmpty;

class Disciplina extends Model
{
    protected $fillable = ['nombre', 'descripcion', 'visible', 'logo'];
    protected $casts = ['visible' => 'boolean'];

    /*
     * Relación de la disciplina con sus respectivos poderes asociados
     */
    public function Puntos(): HasMany
    {
        return $this->hasMany(DisciplinaNivel::class, 'disciplina_id', 'id');
    }

    /*
     * Relación con la disciplina si tiene el nivel adquirido, entrega un array de los puntos adquiridos
     */
    public function puntosAdquiridos(int $nivel):array {
        return $this->Puntos()->where('nivel','<=', $nivel)
            ->orderBy('nivel', 'asc')
            ->get()->toArray();
    }
}
