<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ActualizarPasswordsSeeder extends Seeder
{
    /**
     * Actualiza las contraseñas de todos los usuarios a su cédula.
     */
    public function run(): void
    {
        $users = User::whereNotNull('cedula')->get();

        $count = 0;
        foreach ($users as $user) {
            $user->update([
                'password' => Hash::make($user->cedula),
            ]);
            $count++;
        }

        $this->command->info("✓ Se actualizaron {$count} contraseñas a sus cédulas correspondientes");
        $this->command->warn("⚠ Los usuarios deben usar su CÉDULA como contraseña");
    }
}
