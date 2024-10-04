<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Espacio",
 *     type="object",
 *     title="Espacio",
 *     required={"tipo", "capacidad"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="tipo", type="string", example="Sala de Conferencias"),
 *     @OA\Property(property="capacidad", type="integer", example=50),
 *     @OA\Property(property="ubicacion", type="string", example="Edificio A, Piso 3"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2023-01-01T00:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2023-01-10T10:00:00Z")
 * )
 */

class Espacio extends Model
{
    use HasFactory;

    protected $table = 'espacios';

    protected $fillable = [
        'nombre',
        'descripcion',
        'capacidad',
        'fotos',
        'tipo',
        'horarios_disponibles',
    ];

    protected $casts = [
        'fotos' => 'array',
        'horarios_disponibles' => 'array',
    ];

    public function reservas()
    {
        return $this->hasMany(Reserva::class);
    }
}
