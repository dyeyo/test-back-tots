<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    use HasFactory;
    protected $table = 'reservas';

    protected $fillable = [
        'espacio_id',
        'user_id',
        'nombre_evento',
        'fecha',
        'hora_inicio',
        'hora_fin',
    ];

    public function espacio()
    {
        return $this->belongsTo(Espacio::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
