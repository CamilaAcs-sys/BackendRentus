<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function index()
    {
        // $ratings = Rating::included()->get();
        // return response()->json($ratings);

        $ratings = Rating::included()->filter()->get();
        return response()->json($ratings);
    }

    public function show(Rating $rating)
    {
        //
    }

    public function edit(Rating $rating)
    {
        //
    }

    public function update(Request $request, Rating $rating)
    {
        //
    }

    public function destroy(Rating $rating)
    {
        //
    }
}
