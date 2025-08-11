<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nota extends Model
{
    protected $table = 'notas';

    protected $fillable = [
        'estudiante_id',
        'docente_id',
        'periodo_id',
        'subject_id',
        'year',
        'nota',
    ];

    protected $casts = [
        'nota' => 'float',
        'year' => 'integer',
    ];

    // Relaciones
    public function estudiante()
    {
        return $this->belongsTo(\App\Models\User::class, 'estudiante_id');
    }

    public function docente()
    {
        return $this->belongsTo(\App\Models\User::class, 'docente_id');
    }

    public function periodo()
    {
        return $this->belongsTo(\App\Models\Periodo::class, 'periodo_id');
    }

    public function subject()
    {
        return $this->belongsTo(\App\Models\Subject::class, 'subject_id');
    }
}
