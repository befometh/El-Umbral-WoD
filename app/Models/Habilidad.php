<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\TipoHabilidad;

class Habilidad extends Model
{
    //Forzamos el nombre de la tabla, ya que por defecto el sistema entiende "habilidads" porque cree que es un plural en inglés
    protected $table = 'habilidades';
    protected $fillable = ['nombre', 'tipo', 'descripcion'];
    //para más información ver función habilidades() del modelo Personaje
    public function personajes(){
        return $this->belongsToMany(Personaje::class,'personaje_habilidades')
            ->withPivot('nivel')
            ->withTimestamps();

    }
}
