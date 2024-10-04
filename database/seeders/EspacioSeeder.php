<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Espacio;

class EspacioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Espacio::create([
            'nombre' => 'Salón Principal',
            'descripcion' => 'Un amplio salón ideal para eventos.',
            'capacidad' => 100,
            'tipo' => 'salón',
            'fotos' => json_encode(['salon1.jpg', 'salon2.jpg']),
            'horarios_disponibles' => json_encode(['09:00', '13:00', '17:00']),
        ]);

        Espacio::create([
            'nombre' => 'Sala de Reuniones',
            'descripcion' => 'Sala pequeña para reuniones privadas.',
            'capacidad' => 10,
            'tipo' => 'sala',
            'fotos' => json_encode(['sala1.jpg', 'sala2.jpg']),
            'horarios_disponibles' => json_encode(['10:00', '14:00']),
        ]);

        Espacio::create([
            'nombre' => 'Auditorio',
            'descripcion' => 'Auditorio con capacidad para 300 personas.',
            'capacidad' => 300,
            'tipo' => 'auditorio',
            'fotos' => json_encode(['auditorio1.jpg', 'auditorio2.jpg']),
            'horarios_disponibles' => json_encode(['08:00', '15:00']),
        ]);

        Espacio::create([
            'nombre' => 'Terraza',
            'descripcion' => 'Espacio al aire libre con vista panorámica.',
            'capacidad' => 50,
            'tipo' => 'exterior',
            'fotos' => json_encode(['terraza1.jpg']),
            'horarios_disponibles' => json_encode(['16:00']),
        ]);

        Espacio::create([
            'nombre' => 'Cafetería',
            'descripcion' => 'Espacio para charlas informales y café.',
            'capacidad' => 30,
            'tipo' => 'café',
            'fotos' => json_encode(['cafeteria1.jpg']),
            'horarios_disponibles' => json_encode(['09:00', '11:00', '14:00']),
        ]);
    }
}
