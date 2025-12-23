<?php

namespace Database\Seeders;

use App\Models\Configuracion;
use App\Models\Institucion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConfiguracionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $institucion = Institucion::first();

        if (!$institucion) {
            $this->command->warn('No hay instituciones registradas. Ejecuta InstitucionSeeder primero.');
            return;
        }

        $configuraciones = [
            // Calificaciones
            [
                'institucion_id' => $institucion->id,
                'clave' => 'escala_calificacion_minima',
                'valor' => '0',
                'tipo' => 'numero',
                'categoria' => 'calificaciones',
                'descripcion' => 'Nota mínima en la escala de calificación',
            ],
            [
                'institucion_id' => $institucion->id,
                'clave' => 'escala_calificacion_maxima',
                'valor' => '10',
                'tipo' => 'numero',
                'categoria' => 'calificaciones',
                'descripcion' => 'Nota máxima en la escala de calificación',
            ],
            [
                'institucion_id' => $institucion->id,
                'clave' => 'nota_minima_aprobacion',
                'valor' => '7',
                'tipo' => 'numero',
                'categoria' => 'calificaciones',
                'descripcion' => 'Nota mínima para aprobar una materia',
            ],
            [
                'institucion_id' => $institucion->id,
                'clave' => 'dias_edicion_calificaciones',
                'valor' => '7',
                'tipo' => 'numero',
                'categoria' => 'calificaciones',
                'descripcion' => 'Días permitidos para editar calificaciones después de registrarlas',
            ],
            // Asistencia
            [
                'institucion_id' => $institucion->id,
                'clave' => 'limite_inasistencias',
                'valor' => '25',
                'tipo' => 'numero',
                'categoria' => 'asistencia',
                'descripcion' => 'Porcentaje máximo de inasistencias permitidas',
            ],
            // Seguridad
            [
                'institucion_id' => $institucion->id,
                'clave' => 'minutos_inactividad_sesion',
                'valor' => '30',
                'tipo' => 'numero',
                'categoria' => 'seguridad',
                'descripcion' => 'Minutos de inactividad antes de cerrar sesión automáticamente',
            ],
            [
                'institucion_id' => $institucion->id,
                'clave' => 'intentos_maximos_login',
                'valor' => '5',
                'tipo' => 'numero',
                'categoria' => 'seguridad',
                'descripcion' => 'Número máximo de intentos fallidos de inicio de sesión',
            ],
            // Sistema
            [
                'institucion_id' => $institucion->id,
                'clave' => 'modo_mantenimiento',
                'valor' => 'false',
                'tipo' => 'booleano',
                'categoria' => 'sistema',
                'descripcion' => 'Activar modo de mantenimiento del sistema',
            ],
            [
                'institucion_id' => $institucion->id,
                'clave' => 'registros_por_pagina',
                'valor' => '15',
                'tipo' => 'numero',
                'categoria' => 'sistema',
                'descripcion' => 'Número de registros a mostrar por página',
            ],
        ];

        foreach ($configuraciones as $configuracion) {
            Configuracion::create($configuracion);
        }
    }
}
