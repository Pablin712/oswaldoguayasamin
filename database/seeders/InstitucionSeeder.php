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
            'tipo' => 'fiscal',
            'nivel' => 'Educación General Básica y Bachillerato',
            'jornada' => 'matutina',
            'provincia' => 'Galápagos',
            'ciudad' => 'Puerto Ayora',
            'canton' => 'Santa Cruz',
            'parroquia' => 'Santa Rosa',
            'direccion' => 'Av. Charles Darwin y Tomás de Berlanga',
            'telefono' => '(05) 2520-000',
            'email' => 'contacto@oswaldoguayasamin.edu.ec',
            'sitio_web' => 'https://www.oswaldoguayasamin.edu.ec',
            'rector' => 'Dr. Carlos Mendoza López',
            'vicerrector' => 'Msc. María Elena Torres',
            'inspector' => 'Lic. Pedro Ramírez Castro',
            // logo: null - se puede subir desde la interfaz
        ]);

        Institucion::create([
            'nombre' => 'Unidad Educativa Fiscal Galápagos',
            'codigo_amie' => '20H00002',
            'tipo' => 'fiscal',
            'nivel' => 'Educación General Básica',
            'jornada' => 'vespertina',
            'provincia' => 'Galápagos',
            'ciudad' => 'Puerto Baquerizo Moreno',
            'canton' => 'San Cristóbal',
            'parroquia' => 'Puerto Baquerizo Moreno',
            'direccion' => 'Calle Hernández y Melville',
            'telefono' => '(05) 2521-155',
            'email' => 'contacto@uefgalapagos.edu.ec',
            'sitio_web' => 'https://www.uefgalapagos.edu.ec',
            'rector' => 'Msc. Ana Patricia Moreno',
            'vicerrector' => 'Lic. Roberto Díaz Sánchez',
            'inspector' => 'Lic. Carmen Lucía Vera',
            // logo: null - se puede subir desde la interfaz
        ]);
    }
}
