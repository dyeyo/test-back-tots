<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservaController extends Controller
{


    public function index(Request $request)
    {
        $userId = auth()->user()->id;
        $token = $request->header('Authorization');
        if (!$token) {
            return response()->json(['error' => 'Token not provided'], 401);
        }
        return Reserva::where('user_id', $userId)->get();
    }

    public function store(Request $request)
    {
        $token = $request->header('Authorization');
        if (!$token) {
            return response()->json(['error' => 'Token not provided'], 401);
        }
        $request->validate([
            'espacio_id' => 'required',
            'nombre_evento' => 'required',
            'fecha' => 'required',
            'hora_inicio' => 'required',
            'hora_fin' => 'required',
        ]);

        $reservas = Reserva::where('espacio_id', $request->espacio_id)
                    ->where('fecha', $request->fecha)
                    ->where(function ($query) use ($request) {
                        $query->whereBetween('hora_inicio', 
                                [$request->hora_inicio, $request->hora_fin])
                            ->orWhereBetween('hora_fin', 
                                [$request->hora_inicio, $request->hora_fin]);
                    })->exists();

        if ($reservas) {
            return response()->json(['error' => 'El espacio ya está reservado en este horario.'], 400);
        }

        $reserva = Reserva::create([
            'espacio_id' => $request->espacio_id,
            'user_id' => auth()->id(),
            'nombre_evento' => $request->nombre_evento,
            'fecha' => $request->fecha,
            'hora_inicio' => $request->hora_inicio,
            'hora_fin' => $request->hora_fin,
        ]);

        return response()->json($reserva, 201);
    }

    public function show(Request $request, $id)
    {
        $token = $request->header('Authorization');
        if (!$token) {
            return response()->json(['error' => 'Token not provided'], 401);
        }
        return Reserva::where('user_id', auth()->id())->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $token = $request->header('Authorization');
        if (!$token) {
            return response()->json(['error' => 'Token not provided'], 401);
        }
        $reserva = Reserva::where('user_id', auth()->id())->findOrFail($id);
        $reserva->update($request->all());
        return response()->json($reserva, 200);
    }

    public function destroy(Request $request,$id)
    {
        $token = $request->header('Authorization');
        if (!$token) {
            return response()->json(['error' => 'Token not provided'], 401);
        }
        $reserva = Reserva::where('user_id', auth()->id())->findOrFail($id);
        $reserva->delete();
        return response()->json(null, 204);
    }

}
