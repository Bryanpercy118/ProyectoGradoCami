<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subject;

class SubjectSeeder extends Seeder
{
    public function run(): void
    {
        $materias = [
            'Español','Caligrafía','Lectura','Matemáticas','Tablas','Número','Geometría',
            'Naturales','Ecológia','Inglés','Deporte','Arte','Laboratorio',
            'Ética','Democracia','Historia','Geografía','Informática','Religión',
        ];

        foreach ($materias as $nombre) {
            Subject::firstOrCreate(
                ['nombre' => $nombre],
                ['descripcion' => null]
            );
        }
    }
}
