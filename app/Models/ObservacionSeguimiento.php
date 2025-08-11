<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObservacionSeguimiento extends Model
{
    use HasFactory;
    protected $fillable = ['estudiante_id', 'docente_id', 'periodo_id', 'contenido'];

    public function estudiante() {
        return $this->belongsTo(User::class, 'estudiante_id');
    }

    public function docente() {
        return $this->belongsTo(User::class, 'docente_id');
    }

    public function periodo() {
        return $this->belongsTo(Periodo::class);
    }
}
