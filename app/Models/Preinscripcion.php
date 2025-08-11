<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Preinscripcion extends Model
{
    use HasFactory;

    protected $fillable = ['fecha_inicio', 'fecha_fin', 'estado', 'cupo'];

    protected $appends = ['estado_calculado', 'es_activa', 'cupo_disponible'];

    protected $casts = [
        'fecha_inicio' => 'date:Y-m-d',
        'fecha_fin' => 'date:Y-m-d',
        'cupo' => 'integer',
    ];

    // Relaciones
    public function aspirantes()
    {
        return $this->hasMany(Aspirante::class);
    }

    // Estado calculado (visual)
    public function getEstadoCalculadoAttribute()
    {
        $hoy = now();
        if ($hoy->lt($this->fecha_inicio)) return 'inactiva';
        if ($hoy->between($this->fecha_inicio, $this->fecha_fin)) return 'activa';
        return 'finalizada';
    }

    // Estado activo (lógica)
    public function getEsActivaAttribute()
    {
        $hoy = now();
        return $hoy->between($this->fecha_inicio, $this->fecha_fin);
    }

    // Verifica si hay cupo disponible
    public function getCupoDisponibleAttribute()
    {
        return $this->aspirantes()->count() < $this->cupo;
    }

    public function cupos()
    {
        return $this->hasMany(PreinscripcionCupo::class);
    }

}
