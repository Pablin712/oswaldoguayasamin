<?php

namespace Database\Seeders;

use App\Models\Area;
use Illuminate\Database\Seeder;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $areas = [
            [
                'nombre' => 'Matemáticas',
                'descripcion' => 'Área de ciencias exactas que incluye álgebra, geometría, cálculo, estadística y física',
                'estado' => 'activa',
            ],
            [
                'nombre' => 'Lengua y Literatura',
                'descripcion' => 'Área de comunicación y lenguaje que incluye gramática, lectura, escritura, literatura e idiomas extranjeros',
                'estado' => 'activa',
            ],
            [
                'nombre' => 'Ciencias Naturales',
                'descripcion' => 'Área que incluye biología, química y ciencias de la tierra',
                'estado' => 'activa',
            ],
            [
                'nombre' => 'Ciencias Sociales',
                'descripcion' => 'Área que incluye historia, geografía, filosofía, educación para la ciudadanía y emprendimiento',
                'estado' => 'activa',
            ],
            [
                'nombre' => 'Educación Física',
                'descripcion' => 'Área dedicada al desarrollo físico, deportivo y recreativo de los estudiantes',
                'estado' => 'activa',
            ],
            [
                'nombre' => 'Educación Cultural y Artística',
                'descripcion' => 'Área que incluye música, artes plásticas, teatro, danza e informática',
                'estado' => 'activa',
            ],
        ];

        foreach ($areas as $area) {
            Area::create($area);
        }
    }
}
