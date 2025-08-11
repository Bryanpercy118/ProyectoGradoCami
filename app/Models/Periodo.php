<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periodo extends Model
{
    use HasFactory;
    protected $fillable = ['nombre', 'tipo', 'fecha_inicio', 'fecha_fin', 'activo'];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
    ];

    public function notas()
    {
        return $this->hasMany(Nota::class, 'periodo_id');
    }


    public function observaciones() {
        return $this->hasMany(ObservacionSeguimiento::class);
    }
}
