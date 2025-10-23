<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Muestra la lista de usuarios.
     */
    public function index()
    {
        $users = User::included()->filter()->sort()->getOrPaginate();
        return response()->json($users);
    }

    /**
     * Muestra un usuario específico.
     */
    public function show(User $user)
    {
        return response()->json($user);
    }

    /**
     * Actualiza la información de un usuario.
     */
    public function update(Request $request, User $user)
    {
        $user->update($request->all());
        return response()->json([
            'message' => 'Usuario actualizado con éxito',
            'data' => $user
        ]);
    }

    /**
     * Elimina un usuario.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['message' => 'Usuario eliminado con éxito']);
    }
}
