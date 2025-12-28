<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Correr seeders en orden de dependencias
        $this->call([
            InstitucionSeeder::class,
            RoleSeeder::class,
            AreaSeeder::class,
            EstructuraAcademicaSeeder::class,
            ConfiguracionSeeder::class,
            RelacionesAcademicasSeeder::class,
            UsuariosEspecializadosSeeder::class,
            AsignacionesAcademicasSeeder::class,
            AsistenciaSeeder::class, // Fase 8
            TareaSeeder::class, // Fase 9
            ComunicacionSeeder::class, // Fase 10
            EventoSeeder::class, // Fase 11
            HorarioSeeder::class, // Fase 12
            AuditoriaSeeder::class, // Fase 13
        ]);
    }
}
