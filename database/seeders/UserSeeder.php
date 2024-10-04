<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Diego Vallejo',
            'email' => 'diego@gmail.com',
            'password' => Hash::make('123456789'), 
            'idAdmin' => 1
        ]);

        User::create([
            'name' => 'Ana Gómez',
            'email' => 'ana@gmail.com',
            'password' => Hash::make('123456789'),
            'idAdmin' => 2
        ]);

        User::create([
            'name' => 'Luis Benavides',
            'email' => 'luis@gmail.com',
            'password' => Hash::make('123456789'),
            'idAdmin' => 2
        ]);

        User::create([
            'name' => 'María Fernández',
            'email' => 'maria@gmail.com',
            'password' => Hash::make('123456789'),
            'idAdmin' => 2
        ]);

        User::create([
            'name' => 'Carlos vallejo',
            'email' => 'carlos@gmail.com',
            'password' => Hash::make('123456789'),
            'idAdmin' => 2
        ]);
    }
}
