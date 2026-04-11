<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Habilidad extends Model
{
    //para más información ver función habilidades() del modelo Personaje
    public function personajes(){
        return $this->belongsToMany(Personaje::class,'personaje_habilidades')
            ->withPivot('nivel')
            ->withTimestamps();

    }
}
