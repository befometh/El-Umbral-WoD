<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clan extends Model
{
    protected $table = 'clanes';

    //Campos que se pueden llenar de manera masiva
    protected $fillable = [
        'nombre',
        'apodo',
        'descripcion',
        'faccion',
        'debilidad',
        'visible',
        'logo',
        'clan_padre_id'
    ];

    protected $appends = ['debilidad_completa'];

    /*
     * Un clan puede tener varios hijos, (entre ellos ghouls y aparecidos)
     */
    public function hijos(){
        return $this->hasMany(Clan::class, 'clan_padre_id');
    }

    /*
     * Un clan solo puede tener un único clan padre
     */
    public function padre(){
        return $this->belongsTo(Clan::class, 'clan_padre_id');
    }

    /*
     * Pueden haber muchos personajes del mismo clan
     */
    public function personajes(){
        return $this->hasMany(Personaje::class);
    }

    public function getDebilidadCompletaAttribute(): string
    {
        // 1. Usamos $this directamente para acceder a los datos de este clan
        $debilidad = $this->debilidad;
        $nombre = $this->nombre;

        // 2. Usamos la relación $this->padre que tú definiste arriba
        if (($nombre === 'Ghoul' || $nombre === 'Aparecido') && $this->padre) {
            $clanPadre = $this->padre;
            $debilidadPadre = $clanPadre->debilidad;

            if (!empty($debilidadPadre)) {
                if (!empty($debilidad)) {
                    $debilidad .= "\nTambién hereda la de su clan padre {$clanPadre->nombre}: " . $debilidadPadre;
                } else {
                    $debilidad = "Hereda la de su clan padre {$clanPadre->nombre}: " . $debilidadPadre;
                }
            }
        }

        return $debilidad ?? "Aún no se ha especificado una debilidad";
    }
}
