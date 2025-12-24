<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AuditoriaAcceso;
use App\Models\User;
use Carbon\Carbon;

class AuditoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Creando registros de auditoría...');

        $usuarios = User::all();

        if ($usuarios->isEmpty()) {
            $this->command->warn('No hay usuarios registrados. Saltando AuditoriaSeeder.');
            return;
        }

        $acciones = ['login', 'logout', 'create', 'update', 'delete', 'view'];
        $tablas = [
            'users', 'estudiantes', 'docentes', 'padres',
            'calificaciones', 'asistencias', 'tareas', 'mensajes',
            'eventos', 'matriculas', 'horarios'
        ];

        $ips = [
            '192.168.1.100', '192.168.1.101', '192.168.1.102',
            '10.0.0.50', '10.0.0.51', '172.16.0.10'
        ];

        $userAgents = [
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 Chrome/120.0.0.0',
            'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) Safari/605.1.15',
            'Mozilla/5.0 (X11; Linux x86_64) Firefox/121.0',
            'Mozilla/5.0 (iPad; CPU OS 17_0 like Mac OS X) Safari/604.1',
        ];

        // Generar registros de auditoría de los últimos 30 días
        $fechaInicio = Carbon::now()->subDays(30);
        $cantidadRegistros = 200;

        for ($i = 0; $i < $cantidadRegistros; $i++) {
            $usuario = $usuarios->random();
            $accion = fake()->randomElement($acciones);
            $fechaAuditoria = $fechaInicio->copy()->addMinutes(rand(0, 43200)); // Random en 30 días

            $datosAnteriores = null;
            $datosNuevos = null;
            $tabla = null;
            $registroId = null;
            $descripcion = null;

            // Generar datos según el tipo de acción
            if ($accion === 'login') {
                $descripcion = "Inicio de sesión exitoso";
            } elseif ($accion === 'logout') {
                $descripcion = "Cierre de sesión";
            } elseif ($accion === 'create') {
                $tabla = fake()->randomElement($tablas);
                $registroId = rand(1, 100);
                $datosNuevos = $this->generarDatosEjemplo($tabla);
                $descripcion = "Creación de registro en {$tabla}";
            } elseif ($accion === 'update') {
                $tabla = fake()->randomElement($tablas);
                $registroId = rand(1, 100);
                $datosAnteriores = $this->generarDatosEjemplo($tabla);
                $datosNuevos = $this->generarDatosEjemplo($tabla, true);
                $descripcion = "Actualización de registro en {$tabla}";
            } elseif ($accion === 'delete') {
                $tabla = fake()->randomElement($tablas);
                $registroId = rand(1, 100);
                $datosAnteriores = $this->generarDatosEjemplo($tabla);
                $descripcion = "Eliminación de registro en {$tabla}";
            } elseif ($accion === 'view') {
                $tabla = fake()->randomElement($tablas);
                $registroId = rand(1, 100);
                $descripcion = "Visualización de registro en {$tabla}";
            }

            AuditoriaAcceso::create([
                'user_id' => $usuario->id,
                'accion' => $accion,
                'tabla_afectada' => $tabla,
                'registro_id' => $registroId,
                'ip_address' => fake()->randomElement($ips),
                'user_agent' => fake()->randomElement($userAgents),
                'datos_anteriores' => $datosAnteriores,
                'datos_nuevos' => $datosNuevos,
                'descripcion' => $descripcion,
                'created_at' => $fechaAuditoria,
            ]);
        }

        $totalAuditorias = AuditoriaAcceso::count();
        $this->command->info("✓ Registros de auditoría creados: {$totalAuditorias}");

        // Estadísticas por acción
        $this->command->info("\nDistribución por acción:");
        foreach ($acciones as $accion) {
            $count = AuditoriaAcceso::where('accion', $accion)->count();
            $this->command->info("  - {$accion}: {$count} registros");
        }
    }

    /**
     * Generar datos de ejemplo según la tabla
     */
    private function generarDatosEjemplo($tabla, $esModificacion = false)
    {
        $datos = [];

        switch ($tabla) {
            case 'calificaciones':
                $datos = [
                    'nota_final' => $esModificacion ? fake()->randomFloat(2, 5, 10) : fake()->randomFloat(2, 6, 10),
                    'estado' => $esModificacion ? 'publicada' : 'registrada',
                ];
                break;

            case 'asistencias':
                $datos = [
                    'estado' => $esModificacion ? 'justificado' : fake()->randomElement(['presente', 'ausente']),
                    'observaciones' => $esModificacion ? 'Justificación médica' : null,
                ];
                break;

            case 'tareas':
                $datos = [
                    'titulo' => fake()->sentence(4),
                    'fecha_entrega' => $esModificacion
                        ? fake()->dateTimeBetween('+1 week', '+2 weeks')->format('Y-m-d')
                        : fake()->dateTimeBetween('+3 days', '+1 week')->format('Y-m-d'),
                ];
                break;

            case 'usuarios':
            case 'users':
                $datos = [
                    'name' => fake()->name(),
                    'email' => fake()->email(),
                    'estado' => 'activo',
                ];
                break;

            case 'mensajes':
                $datos = [
                    'asunto' => fake()->sentence(5),
                    'es_leido' => $esModificacion ? true : false,
                ];
                break;

            default:
                $datos = [
                    'campo_ejemplo' => fake()->word(),
                    'valor' => fake()->numberBetween(1, 100),
                ];
        }

        return $datos;
    }
}
