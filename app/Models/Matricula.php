<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Matricula extends Model
{
    protected $fillable = [
        'alumno_user_id','salon_id','year','estado','folio','observaciones',
        'preinscripcion_id','aspirante_id',
    ];

    public function alumno()
    {
        return $this->belongsTo(\App\Models\User::class, 'alumno_user_id');
    }

    public function salon()
    {
        return $this->belongsTo(\App\Models\Salon::class);
    }

    public function aspirante()
    {
        return $this->belongsTo(\App\Models\Aspirante::class);
    }

    public function preinscripcion()
    {
        return $this->belongsTo(\App\Models\Preinscripcion::class);
    }
}
