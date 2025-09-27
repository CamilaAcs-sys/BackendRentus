<?php

namespace App\Http\Controllers;

use App\Models\RentalRequest;
use Illuminate\Http\Request;

class RentalRequestController extends Controller
{
    public function index()
    {
        $rentalRequests = RentalRequest::included()->filter()->sort()->getOrPaginate();
        return response()->json($rentalRequests);
    }

    public function edit(RentalRequest $rentalRequest)
    {
        //
    }
    public function show(RentalRequest $rentalRequest)
    {
      return response()->json($rentalRequest);
    }

    public function update(Request $request, RentalRequest $rentalRequest)
    {
       $rentalRequest->update($request->all());
      return response()->json($rentalRequest);
    }

    public function destroy(RentalRequest $rentalRequest)
    {
       $rentalRequest->delete();
       return response()->json(['message' => 'Solicitud de arriendo eliminada con éxito']);
    }

}
