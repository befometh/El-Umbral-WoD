<?php

namespace Database\Seeders;

use App\Models\Habilidad;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use function Laravel\Prompts\warning;

class HabilidadesSeeder extends Seeder
{
    public function run(): void {
        $ruta = database_path('/add/habilidades.json');
        if(!file_exists($ruta)) {
            dump("No se pudo crear la lista de habilidades");
            return;
        }
        $json = file_get_contents($ruta);
        $habilidades = json_decode($json, true);

        foreach($habilidades as $habilidad) {
            Habilidad::create([
                'nombre' => $habilidad['nombre'],
                'tipo' => $habilidad['tipo'],
                'descripcion' => $habilidad['descripcion']??null
                ]);
        }
        dump("Se ha creado la lista de habilidades con éxito");
    }

}
