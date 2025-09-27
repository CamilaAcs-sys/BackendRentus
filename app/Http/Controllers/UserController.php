<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
        public function index()
    {
        $users = User::included()->filter()->sort()->getOrPaginate();
        return response()->json($users);
    }

    public function edit(User $user)
    {
        //
    }

    public function show(User $user)
    {
      return response()->json($user);
    }

    public function update(Request $request, User $user)
    {
      $user->update($request->all());
      return response()->json($user);
    }

    public function destroy(User $user)
    {
       $user->delete();
      return response()->json(['message' => 'Usuario eliminado con éxito']);
    }

}
