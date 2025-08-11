<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Crear los roles si no existen
        $adminRole     = Role::firstOrCreate(['name' => 'administrador']);
        $profesorRole  = Role::firstOrCreate(['name' => 'profesor']);
        $estudianteRole = Role::firstOrCreate(['name' => 'estudiante']);

        // Usuario principal
        $admin = User::create([
            'name' => 'Administrador',
            'email' => 'admin@demo.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'), // password
            'gender' => 'male',
            'active' => 1,
            'remember_token' => Str::random(10),
        ]);
        $admin->assignRole($adminRole);

        // Profesor
        $profesor = User::create([
            'name' => 'Profesor Demo',
            'email' => 'profesor@demo.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'gender' => 'male',
            'active' => 1,
            'remember_token' => Str::random(10),
        ]);
        $profesor->assignRole($profesorRole);

        // Estudiante
        $estudiante = User::create([
            'name' => 'Estudiante Demo',
            'email' => 'estudiante@demo.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'gender' => 'female',
            'active' => 1,
            'remember_token' => Str::random(10),
        ]);
        $estudiante->assignRole($estudianteRole);

        // 6 usuarios más con roles aleatorios
        User::factory(6)->create()->each(function ($user) use ($adminRole, $profesorRole, $estudianteRole) {
            $user->assignRole(collect([$adminRole, $profesorRole, $estudianteRole])->random());
        });
    }
}
