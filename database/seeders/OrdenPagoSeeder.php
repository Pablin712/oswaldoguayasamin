<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Institucion;
use App\Models\OrdenPago;
use App\Models\Matricula;
use Carbon\Carbon;

class OrdenPagoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $instituciones = Institucion::all();

        foreach ($instituciones as $institucion) {
            // Obtener matrículas de esta institución
            $matriculas = Matricula::whereHas('estudiante.user', function($query) use ($institucion) {
                $query->where('institucion_id', $institucion->id);
            })->get();

            if ($matriculas->isEmpty()) {
                $this->command->warn("No hay matrículas para {$institucion->nombre}. Saltando órdenes de pago.");
                continue;
            }

            // Tomar hasta 5 matrículas
            $matriculasSeleccionadas = $matriculas->take(5);

            foreach ($matriculasSeleccionadas as $index => $matricula) {
                $estados = ['pendiente', 'aprobada', 'rechazada'];
                $tipos = ['primera_matricula', 'segunda_matricula'];
                $montos = [0.00, 35.00, 50.00];

                OrdenPago::create([
                    'matricula_id' => $matricula->id,
                    'tipo_pago' => $tipos[array_rand($tipos)],
                    'monto' => $montos[array_rand($montos)],
                    'estado' => $estados[array_rand($estados)],
                    'comprobante_path' => $index % 2 == 0 ? "comprobantes/comprobante_{$index}.pdf" : null,
                    'created_at' => Carbon::now()->subDays(rand(1, 15)),
                ]);
            }
        }

        $this->command->info('✓ Órdenes de pago creadas exitosamente.');
    }
}
