<?php

namespace Database\Seeders;

use App\Models\Disciplina;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DisciplinasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    protected $rutaDefault = '/logo/disciplinaDefault.png';

    public function run(): void
    {
        $ruta = database_path('/add/disciplinas.json');
        if(!file_exists($ruta)) {
            dump("No se pudo crear la lista de habilidades");
            return;
        }
        $json = file_get_contents($ruta);
        $disciplinas = json_decode($json, true);

        foreach($disciplinas as $disciplina) {
            Disciplina::create([
                'nombre' => $disciplina['nombre'],
                'descripcion' => $disciplina['descripcion'],
                'visible' => $disciplina['visible']??false,
                'logo' => $disciplina['logo']??$this->rutaDefault
            ]);
        }
        dump("Se ha creado la lista de habilidades con éxito");
    }
}
