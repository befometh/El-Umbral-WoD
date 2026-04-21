<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
     * Esta es una modificación de la función anterior donde se filtrarían aquellos poderes que el personaje ha adquirido
     */
    public function PuntosAdquiridos(int $nivel) {
        return $this->Puntos()->where('nivel','<=', $nivel)
            ->orderBy('nivel', 'asc')
            ->get();
    }
}
