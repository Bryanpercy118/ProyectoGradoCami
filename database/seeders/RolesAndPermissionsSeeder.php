<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Crear roles si no existen
        $admin = Role::firstOrCreate(['name' => 'administrador']);
        $profesor = Role::firstOrCreate(['name' => 'profesor']);
        $estudiante = Role::firstOrCreate(['name' => 'estudiante']);

        // Asignar roles a usuarios existentes (puedes ajustar por ID o email)
        $adminUser = User::where('email', 'admin@demo.com')->first();
        if ($adminUser) {
            $adminUser->assignRole($admin);
        }

        $profesorUser = User::where('email', 'profesor@demo.com')->first();
        if ($profesorUser) {
            $profesorUser->assignRole($profesor);
        }

        $estudianteUser = User::where('email', 'estudiante@demo.com')->first();
        if ($estudianteUser) {
            $estudianteUser->assignRole($estudiante);
        }

        // También puedes crear usuarios nuevos aquí si lo deseas
        if (!User::where('email', 'admin@demo.com')->exists()) {
            $adminUser = User::create([
                'name' => 'Admin',
                'email' => 'admin@demo.com',
                'password' => bcrypt('password')
            ]);
            $adminUser->assignRole($admin);
        }
    }
}
