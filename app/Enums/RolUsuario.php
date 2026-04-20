<?php
namespace App\Enums;

enum rolUsuario: int
{
    case ANTEDILUVIANO = 1;
    case MATUSALEN = 2;
    case VASTAGO = 3;
    case GHOUL = 4;

    //Método para obtener el nombre de la clase
    public function label(): string
    {
        return match ($this) {
            self::ANTEDILUVIANO => 'Antediluviano',
            self::MATUSALEN => 'Matusalén',
            self::VASTAGO => 'Vastago',
            self::GHOUL => 'Ghoul'
        };
    }
}
