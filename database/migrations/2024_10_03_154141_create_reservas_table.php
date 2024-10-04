<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reservas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('espacio_id');
            $table->unsignedBigInteger('user_id');
            $table->string('nombre_evento');
            $table->dateTime('fecha');
            $table->time('hora_inicio');
            $table->time('hora_fin');
            $table->timestamps();
        
            $table->foreign('espacio_id')->references('id')->on('espacios')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservas');
    }
};
