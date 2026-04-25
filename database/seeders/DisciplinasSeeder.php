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
            $nuevaDisciplina = Disciplina::create([
                'nombre' => $disciplina['nombre'],
                'descripcion' => $disciplina['descripcion'],
                'visible' => $disciplina['visible']??false,
                'logo' => $disciplina['logo']??$this->rutaDefault            ]);

            if(isset($disciplina['puntos']) && is_array($disciplina['puntos'])) {
                foreach($disciplina['puntos'] as $punto) {
                    $nuevaDisciplina -> puntos()->create([
                        'nombre' => $punto['nombre'],
                        'nivel' => $punto['nivel'],
                        'descripcion' => $punto['descripcion'] ?? null,
                        'sistema' => $punto['sistema'] ?? null,
                        'pool_dados_lanzados' => $punto['pool_dados_lanzados'] ?? null,
                        'pool_stats_pasivos' => $punto['pool_stats_pasivos'] ?? null,
                        'pool_stats_activos' => $punto['pool_stats_activos']?? null,
                        'comportamiento' => $punto['comportamiento'],
                        'duracion' => $punto['duracion'],
                        'costes' => $punto['costes']??null,
                        'msj_info' => $punto['msj_info']??null,
                        'visible' => $punto['visible']??false,
                    ]);
                }            }
        }
        dump("Se ha creado la lista de habilidades con éxito");
    }
}
