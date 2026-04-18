<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Clan;
use Illuminate\Support\Facades\File;

class ClanesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    protected $imgDefault = "/logo/default.png";

    public function run(): void
    {
        $ruta = database_path('/add/clanes.json');
        if(!File::exists($ruta)) {
            return;
        } else{
            $json = File::get($ruta);
            $clanes = json_decode($json, true);

            if(!is_array($clanes)) return; //Por si el array no tiene el formato adecuado

            //Si el archivo está establecido recorremos la lista de datos
            foreach($clanes as $clan) {
                Clan::updateOrCreate([
                    'nombre' => $clan['nombre'],
                ],[
                    'descripcion' => $clan['descripcion']??null,
                    'apodo' => $clan['apodo']??null,
                    'faccion' => $clan['faccion']??null,
                    'debilidad' => $clan['debilidad']??null,
                    'visible' => $clan['visible']??false,
                    'logo' => $clan['logo']??$this->imgDefault,
                ]);
            }

            //3. Verificamos si hay un  clan padre asociado
            foreach($clanes as $clan) {
                if(!empty($clan["clan_padre_nombre"])){
                    $hijo = Clan::where('nombre', $clan["nombre"])->first();
                    $padre = Clan::where('nombre', $clan["clan_padre_nombre"])->first();

                    if($hijo && $padre){
                        $hijo->update(['clan_padre_id' => $padre->id]);
                    }
                }
            }
        }
    }
}
