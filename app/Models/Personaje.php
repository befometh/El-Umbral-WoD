<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Personaje extends Model
{
    protected $fillable = [
        'user_id', 'nombre', 'clan_id', 'generacion',
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

    public function obtenerNivelesDisponibles($disciplinaId)
    {
        // Buscamos cuánto nivel tiene el personaje en esa disciplina
        $pivot = $this->disciplinas()->where('disciplina_id', $disciplinaId)->first()->pivot;
        $nivelMaximo = $pivot->nivel_aprendido;

        // Retornamos los niveles de la tabla disciplina_niveles
        return DisciplinaNivel::where('disciplina_id', $disciplinaId)
            ->where('nivel', '<=', $nivelMaximo)
            ->where(function ($query) {
                // Si eres Master ves todo, si no, solo los visibles
                if (!auth()->user()->hasRole(['Antediluviano', 'Matusalén'])) {
                    $query->where('visible', true);
                }
            })
            ->get();
    }

    // Relación con el Clan
    public function clan()
    {
        return $this->belongsTo(Clan::class);
    }

    // Relación con sus Disciplinas (Pivote de niveles aprendidos)
    public function disciplinas()
    {
        return $this->belongsToMany(Disciplina::class, 'disciplina_personaje')
            ->withPivot('nivel_aprendido')
            ->withTimestamps();
    }

    public function calcularCosteSubida($disciplinaId, $nuevoNivel)
    {
        $clan = $this->clan;

        // Caso Especial: Caitiff y Pander (Multiplicador x6 siempre)
        if (in_array($clan->nombre, ['Caitiff', 'Pander'])) {
            return $nuevoNivel * 6;
        }

        // Caso Normal: Verificar si es de Clan (x5) o Foránea (x7)
        // Comprobamos si la disciplina está en la tabla clan_disciplina para su clan
        $esDeClan = $clan->disciplinas()->where('disciplina_id', $disciplinaId)->exists();

        $multiplicador = $esDeClan ? 5 : 7;

        return $nuevoNivel * $multiplicador;
    }

    //Devuelve la información de las disciplinas que están disponibles para aprender por el personaje
    public function getMostrario(Personaje $personaje)
    {
        // Obtenemos todas las disciplinas que el personaje puede ver
        $disciplinas = Disciplina::where('visible', true)->get();

        return $disciplinas->map(function ($disciplina) use ($personaje) {
            // Buscamos el nivel actual que tiene el personaje en esta disciplina
            $nivelActual = $personaje->disciplinas()
                ->where('disciplina_id', $disciplina->id)
                ->first()?->pivot->nivel_aprendido ?? 0;

            $siguienteNivel = $nivelActual + 1;

            return [
                'id' => $disciplina->id,
                'nombre' => $disciplina->nombre,
                'nivel_actual' => $nivelActual,
                'coste_siguiente_nivel' => $personaje->calcularCosteSubida($disciplina->id, $siguienteNivel),
                'es_nativa' => $personaje->clan->disciplinas()->where('disciplina_id', $disciplina->id)->exists()
            ];
        });
    }
}
