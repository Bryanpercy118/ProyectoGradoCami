<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Salon;

class SalonSeeder extends Seeder
{
    public function run(): void
    {
        $salones = [
            // Transición con dos secciones
            ['nombre' => 'Transición', 'grado' => 'Transición',        'seccion' => 'A'],
            ['nombre' => 'Transición', 'grado' => 'Transición',        'seccion' => 'B'],
            // Primaria (A)
            ['nombre' => '1ro de primaria', 'grado' => '1ro de primaria', 'seccion' => 'A'],
            ['nombre' => '2do de primaria', 'grado' => '2do de primaria', 'seccion' => 'A'],
            ['nombre' => '3ro de primaria', 'grado' => '3ro de primaria', 'seccion' => 'A'],
            ['nombre' => '4to de primaria', 'grado' => '4to de primaria', 'seccion' => 'A'],
            ['nombre' => '5to de primaria', 'grado' => '5to de primaria', 'seccion' => 'A'],
        ];

        foreach ($salones as $s) {
            Salon::firstOrCreate(
                ['grado' => $s['grado'], 'seccion' => $s['seccion']],
                ['nombre' => $s['nombre']]
            );
        }
    }
}
