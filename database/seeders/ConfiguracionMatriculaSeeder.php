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
        // Institución 1: Unidad Educativa Oswaldo Guayasamín (Fiscal)
        ConfiguracionMatricula::updateOrCreate(
            ['institucion_id' => 1],
            [
                'tipo_institucion' => 'fiscal',
                'monto_primera_matricula' => 0.00,  // Gratuita
                'monto_segunda_matricula' => 0.00,  // Gratuita
            ]
        );

        // Institución 2: Unidad Educativa Fiscal Galápagos (Fiscomisional - cobra algo)
        ConfiguracionMatricula::updateOrCreate(
            ['institucion_id' => 2],
            [
                'tipo_institucion' => 'fiscomisional',
                'monto_primera_matricula' => 35.00,
                'monto_segunda_matricula' => 50.00,
            ]
        );

        // Si hay más instituciones, configurarlas también
        $institucion3 = Institucion::find(3);
        if ($institucion3) {
            ConfiguracionMatricula::updateOrCreate(
                ['institucion_id' => 3],
                [
                    'tipo_institucion' => 'particular',
                    'monto_primera_matricula' => 150.00,
                    'monto_segunda_matricula' => 200.00,
                ]
            );
        }
    }
}
