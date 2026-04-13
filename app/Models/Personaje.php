<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Personaje extends Model
{
    protected $fillable = [
        'user_id', 'nombre', 'clan', 'generacion',
        'fuerza', 'destreza', 'resistencia',
        'carisma', 'manipulacion', 'apariencia',
        'percepcion', 'inteligencia', 'astucia',
        'salud_actual', 'reserva_sangre_max', 'reserva_sangre_actual'
];
    public function usuario() : BelongsTo{
        return $this->belongsTo(User::class, 'user_id');
    }

    public function gastarSangre(int $cantidad) : bool{
       if($this->reserva_sangre_actual >= $cantidad){
           $this->reserva_sangre_actual -= $cantidad;
           $this->save();
       } return false;
    }

    public function recuperarSangre (int $cantidad) : void{
        $total = $this->reserva_sangre_actual + $cantidad;
        //Se evita que supere el máximo de reserva;
        $this->reservaSangreActual = $total<$this->reservaSangreMax?$total:$this->reservaSangreMax;
        $this->save();
    }

    public function habilidades(){
        //Un personaje puede tener muchas habilidades
        //withPivot permite acceder a la columna en cuestión de la tabla personajes_habilidades
        return $this->belongsToMany(Habilidad::class, 'personaje_habilidad')
            ->withPivot('nivel')
            ->withTimestamps();
    }

    public function tirarHabilidad(string $nomHabilidad): int {
        $habilidad = $this->habilidades()
        ->where('nombre', $nomHabilidad)
        ->first();
        return $habilidad?$habilidad->pivot->nivel:0;
    }

    public function iniciativa(): int{
        return $this->destreza + $this->astucia;
    }

}
