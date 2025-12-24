<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventoCurso extends Model
{
    use HasFactory;

    protected $table = 'evento_curso';

    protected $fillable = [
        'evento_id',
        'paralelo_id',
    ];

    // Relaciones
    public function evento()
    {
        return $this->belongsTo(Evento::class);
    }

    public function paralelo()
    {
        return $this->belongsTo(Paralelo::class);
    }
}
