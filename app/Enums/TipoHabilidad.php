<?php

namespace App\Enums;

enum TipoHabilidad: int
{
    case TALENTO = 1;
    case TECNICA = 2;
    case CONOCIMIENTO = 3;

    // Método en inglés para la lógica técnica
    public function label(): string
    {
        return match ($this) {
            self::TALENTO => 'Talento',
            self::TECNICA => 'Técnica',
            self::CONOCIMIENTO => 'Conocimiento',
        };
    }
    public static function labels(): array
    {
        return array_map(fn($t) => $t->label(), self::cases());
    }
}
