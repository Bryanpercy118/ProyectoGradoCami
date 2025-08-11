<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Salon extends Model
{
    protected $fillable = ['nombre', 'grado', 'seccion'];

    public function docentes()
    {
        return $this->hasMany(Teacher::class);
    }

    public function notas()
    {
        return $this->hasMany(Nota::class);
    }


}
