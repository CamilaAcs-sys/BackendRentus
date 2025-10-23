<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PropertyController extends Controller
{
    /**
     * Listar propiedades (con filtros, orden y paginación opcional)
     */
    public function index()
    {
        $properties = Property::included()->filter()->sort()->getOrPaginate();
        return response()->json($properties, 200);
    }

    /**
     * Crear una nueva propiedad
     */
    public function store(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'address' => 'required|string|max:255',
        'city' => 'required|string|max:100',
        'status' => 'required|string|max:50',
        'monthly_price' => 'required|numeric|min:0',
        'area_m2' => 'nullable|numeric|min:0',
        'num_bedrooms' => 'nullable|integer|min:0',
        'num_bathrooms' => 'nullable|integer|min:0',
        'included_services' => 'nullable|string',
        'publication_date' => 'nullable|date',
        'image_url' => 'nullable|string|max:255',
        'user_id' => 'required|exists:users,id',
    ]);

    $property = Property::create($validated);

   return response()->json([
    'success' => true,
    'message' => 'Propiedad creada con éxito',
    'data' => $property
], 201);

}


    /**
     * Mostrar una propiedad específica
     */
    public function show($id)
    {
        try {
            $property = Property::included()->findOrFail($id);
            return response()->json($property, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Propiedad no encontrada'], 404);
        }
    }

    /**
     * Editar una propiedad (solo retorna datos, útil para formularios)
     */
    public function edit(Property $property)
    {
        return response()->json($property, 200);
    }

    /**
     * Actualizar una propiedad existente
     */
    public function update(Request $request, Property $property)
    {
        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'status' => 'nullable|string|max:50',
            'monthly_price' => 'sometimes|required|numeric|min:0',
            'area_m2' => 'nullable|numeric|min:0',
            'num_bedrooms' => 'nullable|integer|min:0',
            'num_bathrooms' => 'nullable|integer|min:0',
            'included_services' => 'nullable|string',
            'publication_date' => 'nullable|date',
            'image_url' => 'nullable|string|max:255',
            'user_id' => 'nullable|integer|exists:users,id',
        ]);

        $property->update($request->all());

        return response()->json([
            'message' => 'Propiedad actualizada correctamente',
            'data' => $property
        ], 200);
    }

    /**
     * Eliminar una propiedad
     */
    public function destroy(Property $property)
    {
        $property->delete();

        return response()->json([
            'message' => 'Propiedad eliminada con éxito'
        ], 200);
    }
}
