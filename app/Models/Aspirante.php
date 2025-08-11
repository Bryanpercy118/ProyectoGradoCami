<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aspirante extends Model
{
    use HasFactory;

    protected $fillable = [
        'preinscripcion_id',
        'salon_id',                
        'nombre_estudiante',
        'fecha_nacimiento',
        'discapacidad',
        'grado_solicitado',
        'nombre_acudiente',
        'correo_acudiente',
        'telefono_acudiente',
        'datos_acudiente',
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date:Y-m-d',
        'datos_acudiente' => 'array', // Se convertirá automáticamente en JSON al guardar
    ];

    public function preinscripcion()
    {
        return $this->belongsTo(Preinscripcion::class);
    }

    public function salon()
    {
        return $this->belongsTo(Salon::class);
    }

}
