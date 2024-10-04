<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Espacio;

/**
 * @OA\OpenApi(
 *     @OA\Info(
 *         title="API de Espacios",
 *         version="1.0.0"
 *     ),
 *     @OA\SecurityScheme(
 *         securityScheme="bearerAuth",
 *         type="http",
 *         scheme="bearer",
 *         bearerFormat="JWT",
 *         description="Ingrese el token de autenticación con el prefijo `Bearer`"
 *     )
 * )
 */
class EspacioController extends Controller
{

    /**
     * @OA\Get(
     *     path="/api/espacios",
     *     summary="Obtener una lista de espacios",
     *     description="Retorna una lista de espacios filtrados por tipo, capacidad y disponibilidad en un rango de fechas.",
     *     tags={"Espacios"},
     *     security={{ "bearerAuth": {} }},
     *     @OA\Parameter(
     *         name="tipo",
     *         in="query",
     *         description="Filtra los espacios por tipo",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="capacidad",
     *         in="query",
     *         description="Filtra los espacios con capacidad mínima especificada",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="fecha_inicio",
     *         in="query",
     *         description="Fecha de inicio para filtrar la disponibilidad",
     *         required=false,
     *         @OA\Schema(type="string", format="date")
     *     ),
     *     @OA\Parameter(
     *         name="fecha_fin",
     *         in="query",
     *         description="Fecha de fin para filtrar la disponibilidad",
     *         required=false,
     *         @OA\Schema(type="string", format="date")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de espacios filtrados",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Espacio"))
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Token no proporcionado",
     *         @OA\JsonContent(@OA\Property(property="error", type="string", example="Token not provided"))
     *     )
     * )
    */
    public function index(Request $request)
    {
        $token = $request->header('Authorization');
        if (!$token) {
            return response()->json(['error' => 'Token not provided'], 401);
        }
        $tipoEspacio = $request->query('tipo');
        $capacidad = $request->query('capacidad');
        $fechaInicio = $request->query('fecha_inicio');
        $fechaFin = $request->query('fecha_fin');

        $query = Espacio::query();

        if ($tipoEspacio) {
            $query->where('tipo', $tipoEspacio);
        }

        if ($capacidad) {
            $query->where('capacidad', '>=', $capacidad);
        }

        if ($fechaInicio && $fechaFin) {
            $query->whereDoesntHave('reservas', function ($subQuery) use ($fechaInicio, $fechaFin) {
                $subQuery->where(function ($query) use ($fechaInicio, $fechaFin) {
                    $query->whereBetween('fecha', [$fechaInicio, $fechaFin]);
                });
            });
        }

        $espacios = $query->get();

        return response()->json($espacios);
    }
    
      /**
     * @OA\Post(
     *     path="/api/espacios",
     *     summary="Crear un nuevo espacio",
     *     description="Crea un nuevo espacio con los datos proporcionados.",
     *     tags={"Espacios"},
     *     security={{ "bearerAuth": {} }},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Espacio")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Espacio creado exitosamente",
     *         @OA\JsonContent(ref="#/components/schemas/Espacio")
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Token no proporcionado",
     *         @OA\JsonContent(@OA\Property(property="error", type="string", example="Token not provided"))
     *     )
     * )
     */
    public function store(Request $request)
    {
        $token = $request->header('Authorization');
        if (!$token) {
            return response()->json(['error' => 'Token not provided'], 401);
        }
        $espacio = Espacio::create($request->all());
        return response()->json($espacio, 201);
    }
    
      /**
     * @OA\Get(
     *     path="/api/espacios/{id}",
     *     summary="Obtener detalles de un espacio",
     *     description="Retorna los detalles de un espacio específico basado en su ID.",
     *     tags={"Espacios"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del espacio a obtener",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalles del espacio",
     *         @OA\JsonContent(ref="#/components/schemas/Espacio")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Espacio no encontrado",
     *         @OA\JsonContent(@OA\Property(property="error", type="string", example="Espacio no encontrado"))
     *     )
     * )
     */
    public function show($id)
    {
        return Espacio::findOrFail($id);
    }
    
      /**
     * @OA\Put(
     *     path="/api/espacios/{id}",
     *     summary="Actualizar un espacio",
     *     description="Actualiza los datos de un espacio existente.",
     *     tags={"Espacios"},
     *     security={{ "bearerAuth": {} }},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del espacio a actualizar",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Espacio")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Espacio actualizado exitosamente",
     *         @OA\JsonContent(ref="#/components/schemas/Espacio")
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Token no proporcionado",
     *         @OA\JsonContent(@OA\Property(property="error", type="string", example="Token not provided"))
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Espacio no encontrado",
     *         @OA\JsonContent(@OA\Property(property="error", type="string", example="Espacio no encontrado"))
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $token = $request->header('Authorization');
        if (!$token) {
            return response()->json(['error' => 'Token not provided'], 401);
        }
        $espacio = Espacio::findOrFail($id);
        $espacio->update($request->all());
        return response()->json($espacio, 200);
    }
    
    
     /**
     * @OA\Delete(
     *     path="/api/espacios/{id}",
     *     summary="Eliminar un espacio",
     *     description="Elimina un espacio basado en su ID.",
     *     tags={"Espacios"},
     *     security={{ "bearerAuth": {} }},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del espacio a eliminar",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Espacio eliminado exitosamente",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Token no proporcionado",
     *         @OA\JsonContent(@OA\Property(property="error", type="string", example="Token not provided"))
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Espacio no encontrado",
     *         @OA\JsonContent(@OA\Property(property="error", type="string", example="Espacio no encontrado"))
     *     )
     * )
     */
    public function destroy(Request $request,$id)
    {
        $token = $request->header('Authorization');
        if (!$token) {
            return response()->json(['error' => 'Token not provided'], 401);
        }
        Espacio::destroy($id);
        return response()->json(null, 204);
    }
    
}
