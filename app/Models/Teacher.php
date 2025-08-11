<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = ['nombre', 'email', 'telefono', 'salon_id'];

    public function salon()
    {
        return $this->belongsTo(Salon::class);
    }
}
