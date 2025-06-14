<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adopciones extends Model
{
    use HasFactory;

    protected $fillable = [
        'gato_id',
        'user_id',
        'fecha_adopcion',
    ];

    public function gato()
    {
        return $this->belongsTo(Gato::class);
    }

    public function adoptante()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
