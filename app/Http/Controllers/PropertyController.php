<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function index()
    {
        // $properties = Property::included()->get();
        // return response()->json($properties);

        $properties = Property::included()->filter()->get();
        return response()->json($properties);
    }

    public function show(Property $property)
    {
        //
    }

    public function edit(Property $property)
    {
        //
    }

    public function update(Request $request, Property $property)
    {
        //
    }

    public function destroy(Property $property)
    {
        //
    }
}

