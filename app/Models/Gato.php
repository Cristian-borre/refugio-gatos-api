<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gato extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'edad',
        'raza',
        'collar',
        'estado',
    ];
}
