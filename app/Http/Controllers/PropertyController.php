<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function index()
    {
        $properties = Property::included()->filter()->sort()->getOrPaginate();
        return response()->json($properties);
    }

    public function edit(Property $property)
    {
        //
    }

    public function show(Property $property)
    {
        return response()->json($property);
    }

    public function update(Request $request, Property $property)
    {
        $property->update($request->all());
        return response()->json($property);
    }

    public function destroy(Property $property)
    {
        $property->delete();
        return response()->json(['message' => 'Propiedad eliminada con éxito']);
    }

}

