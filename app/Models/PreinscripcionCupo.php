<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreinscripcionCupo extends Model
{
    use HasFactory;

    protected $fillable = [
        'preinscripcion_id',
        'salon_id',
        'cupo_total',
    ];

    public function preinscripcion()
    {
        return $this->belongsTo(Preinscripcion::class);
    }

    public function salon()
    {
        return $this->belongsTo(Salon::class);
    }

    public function cupoDisponible()
    {
        $ocupados = Aspirante::where('salon_id', $this->salon_id)
            ->where('preinscripcion_id', $this->preinscripcion_id)
            ->count();

        return $this->cupo_total - $ocupados;
    }
}
