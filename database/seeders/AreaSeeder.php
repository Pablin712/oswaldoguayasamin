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
                'descripcion' => 'Área de ciencias exactas que incluye álgebra, geometría, cálculo y estadística',
                'estado' => 'activa',
            ],
            [
                'nombre' => 'Lengua y Literatura',
                'descripcion' => 'Área de comunicación y lenguaje que incluye gramática, lectura, escritura y literatura',
                'estado' => 'activa',
            ],
            [
                'nombre' => 'Ciencias Naturales',
                'descripcion' => 'Área que incluye biología, física, química y ciencias de la tierra',
                'estado' => 'activa',
            ],
            [
                'nombre' => 'Ciencias Sociales',
                'descripcion' => 'Área que incluye historia, geografía, cívica y estudios sociales',
                'estado' => 'activa',
            ],
            [
                'nombre' => 'Lengua Extranjera',
                'descripcion' => 'Área dedicada al aprendizaje de idiomas extranjeros como inglés, francés, etc.',
                'estado' => 'activa',
            ],
            [
                'nombre' => 'Educación Física',
                'descripcion' => 'Área dedicada al desarrollo físico y deportivo de los estudiantes',
                'estado' => 'activa',
            ],
            [
                'nombre' => 'Educación Cultural y Artística',
                'descripcion' => 'Área que incluye música, artes plásticas, teatro y danza',
                'estado' => 'activa',
            ],
            [
                'nombre' => 'Emprendimiento y Gestión',
                'descripcion' => 'Área dedicada al desarrollo de habilidades empresariales y de gestión',
                'estado' => 'activa',
            ],
            [
                'nombre' => 'Educación para la Ciudadanía',
                'descripcion' => 'Área enfocada en formación ciudadana, ética y valores',
                'estado' => 'activa',
            ],
            [
                'nombre' => 'Informática',
                'descripcion' => 'Área dedicada a la tecnología de la información y computación',
                'estado' => 'activa',
            ],
        ];

        foreach ($areas as $area) {
            Area::create($area);
        }
    }
}
