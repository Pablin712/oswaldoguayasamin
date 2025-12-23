<?php

namespace Database\Seeders;

use App\Models\Institucion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InstitucionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Institucion::create([
            'nombre' => 'Unidad Educativa Oswaldo Guayasamín',
            'codigo_amie' => '20H00001',
            'direccion' => 'Galápagos, Ecuador',
            'telefono' => '(05) 2520-000',
            'email' => 'contacto@oswaldoguayasamin.edu.ec',
            'sitio_web' => 'https://www.oswaldoguayasamin.edu.ec',
        ]);
    }
}
