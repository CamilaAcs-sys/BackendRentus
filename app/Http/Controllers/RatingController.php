<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function index()
    {
        $ratings = Rating::included()->filter()->sort()->getOrPaginate();
        return response()->json($ratings);
    }

    public function edit(Rating $rating)
    {
        //
    }
    public function show(Rating $rating)
    {
      return response()->json($rating);
    }

    public function update(Request $request, Rating $rating)
    {
       $rating->update($request->all());
      return response()->json($rating);
    }

    public function destroy(Rating $rating)
    {
       $rating->delete();
       return response()->json(['message' => 'Reseña eliminada con éxito']);
    }

}
