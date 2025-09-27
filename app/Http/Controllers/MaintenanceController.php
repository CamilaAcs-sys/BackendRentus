<?php

namespace App\Http\Controllers;
use App\Models\Maintenance;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{

    public function index()
    {
        $maintenances = Maintenance::included()->filter()->sort()->getOrPaginate();
        return response()->json($maintenances);
    }

    public function edit(Maintenance $maintenance)
    {
        //
    }

    public function show(Maintenance $maintenance)
    {
         return response()->json($maintenance);
    }

    public function update(Request $request, Maintenance $maintenance)
    {
          $maintenance->update($request->all());
         return response()->json($maintenance);
    }

    public function destroy(Maintenance $maintenance)
    {
         $maintenance->delete();
         return response()->json(['message' => 'Mantenimiento eliminado con éxito']);
    }

}


