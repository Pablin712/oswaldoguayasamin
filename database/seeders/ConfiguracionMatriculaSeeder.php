<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ConfiguracionMatricula;
use App\Models\Institucion;

class ConfiguracionMatriculaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener instituciones
        $instituciones = Institucion::all();

        foreach ($instituciones as $institucion) {
            ConfiguracionMatricula::firstOrCreate(
                ['institucion_id' => $institucion->id],
                [
                    'tipo_institucion' => 'fiscal', // Cambiar según corresponda
                    'monto_primera_matricula' => 0,  // Gratuita para fiscal
                    'monto_segunda_matricula' => 25.00, // Ejemplo: $25 por segunda matrícula
                ]
            );
        }

        // Ejemplo: Configurar segunda institución como fiscomisional
        $institucion2 = Institucion::find(2);
        if ($institucion2) {
            ConfiguracionMatricula::updateOrCreate(
                ['institucion_id' => $institucion2->id],
                [
                    'tipo_institucion' => 'fiscomisional',
                    'monto_primera_matricula' => 50.00,
                    'monto_segunda_matricula' => 75.00,
                ]
            );
        }
    }
}
