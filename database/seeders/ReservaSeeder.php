<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Reserva;
use App\Models\User;
use App\Models\Espacio;

class ReservaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user1 = User::where('email', 'diego@gmail.com')->first();
        $espacio1 = Espacio::where('nombre', 'Salón Principal')->first();

        Reserva::create([
            'user_id' => $user1->id,
            'espacio_id' => $espacio1->id,
            'nombre_evento' => 'Reunión de Proyectos',
            'fecha' => '2024-10-10',
            'hora_inicio' => '10:00',
            'hora_fin' => '12:00',
        ]);

        $user2 = User::where('email', 'ana@gmail.com')->first();
        $espacio2 = Espacio::where('nombre', 'Sala de Reuniones')->first();

        Reserva::create([
            'user_id' => $user2->id,
            'espacio_id' => $espacio2->id,
            'nombre_evento' => 'Presentación de Ventas',
            'fecha' => '2024-10-11',
            'hora_inicio' => '14:00',
            'hora_fin' => '15:00',
        ]);

        $user3 = User::where('email', 'luis@gmail.com')->first();
        $espacio3 = Espacio::where('nombre', 'Auditorio')->first();

        Reserva::create([
            'user_id' => $user3->id,
            'espacio_id' => $espacio3->id,
            'nombre_evento' => 'Conferencia Anual',
            'fecha' => '2024-10-12',
            'hora_inicio' => '09:00',
            'hora_fin' => '11:00',
        ]);
    }
}
