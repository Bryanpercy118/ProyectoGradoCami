<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'email', 'password', 'gender', 'active', 
    ];

    protected $hidden = ['password','remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'active' => 'boolean', 
    ];

   
     // Relaciones académicas:

      // Notas donde este usuario ES alumno
    public function notasComoEstudiante()
    {
        return $this->hasMany(\App\Models\Nota::class, 'estudiante_id');
    }

    // Notas cargadas por este usuario cuando ES docente
    public function notasComoDocente()
    {
        return $this->hasMany(\App\Models\Nota::class, 'docente_id');
    }

    // Matrículas (cuando es alumno)
    public function matriculas()
    {
        return $this->hasMany(\App\Models\Matricula::class, 'alumno_user_id');
    }

    // Asignaciones (cuando es docente)
    public function asignacionesComoDocente()
    {
        return $this->hasMany(\App\Models\Asignacion::class, 'teacher_id');
    }

    // Observaciones (docente → crea)
    public function observacionesComoDocente()
    {
        return $this->hasMany(\App\Models\ObservacionSeguimiento::class, 'docente_id');
    }

    // Observaciones (alumno → recibe)
    public function observacionesComoEstudiante()
    {
        return $this->hasMany(\App\Models\ObservacionSeguimiento::class, 'estudiante_id');
    }

    // Historias clínicas / terapias (si aplica a alumno)
    public function historiasClinicas()
    {
        return $this->hasMany(\App\Models\HistoriaClinica::class, 'estudiante_id');
    }

    // Helper: matrícula activa por año (rápido para dashboard alumno)
    public function matriculaDelAnio(int $year = null)
    {
        $year = $year ?? now()->year;
        return $this->matriculas()
            ->where('year', $year)
            ->where('estado', 'matriculado')
            ->with('salon')
            ->first();
    }
}
