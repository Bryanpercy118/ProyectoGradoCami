<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Salon;
use App\Models\Preinscripcion;
use App\Models\PreinscripcionCupo;
use Carbon\Carbon;

class PreinscripcionCupoSeeder extends Seeder
{
    public function run(): void
    {
        $hoy = Carbon::today();
        $fin = $hoy->copy()->addDays(30);

        $pre = Preinscripcion::whereDate('fecha_inicio', '<=', $hoy)
            ->whereDate('fecha_fin', '>=', $hoy)
            ->first();

        if (!$pre) {
            $pre = Preinscripcion::create([
                'fecha_inicio' => $hoy->toDateString(),
                'fecha_fin'    => $fin->toDateString(),
                'estado'       => 'activa',
            ]);
        }

        foreach (Salon::all() as $salon) {
            PreinscripcionCupo::firstOrCreate(
                ['preinscripcion_id' => $pre->id, 'salon_id' => $salon->id],
                ['cupo_total' => 30]
            );
        }
    }
}
