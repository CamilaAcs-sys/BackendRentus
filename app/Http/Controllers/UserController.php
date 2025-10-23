<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Exception;

class UserController extends Controller
{
    /**
     * Muestra la lista de usuarios.
     */
    public function index()
    {
        $users = User::included()->filter()->sort()->getOrPaginate();

        return response()->json([
            'success' => true,
            'data' => $users
        ]);
    }

    /**
     * Muestra un usuario específico.
     */
    public function show(User $user)
    {
        return response()->json([
            'success' => true,
            'data' => $user
        ]);
    }

    /**
     * Actualiza la información de un usuario.
     */
    public function update(Request $request, User $user)
    {
        try {
            $validated = $request->validate([
                'name' => 'sometimes|string|max:255',
                'email' => [
                    'sometimes', 'email', 'max:255',
                    Rule::unique('users')->ignore($user->id)
                ],
                'password' => 'nullable|string|min:8',
                'phone' => 'sometimes|string|max:20',
                'address' => 'sometimes|string|max:255',
                'id_documento' => 'sometimes|string|max:50',
                'status' => 'sometimes|string|in:activo,inactivo'
            ]);

            // Si envían una nueva contraseña, la hasheamos
            if (!empty($validated['password'])) {
                $validated['password'] = Hash::make($validated['password']);
            }

            $user->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Usuario actualizado con éxito',
                'data' => $user
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el usuario',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Elimina un usuario.
     */
    public function destroy(User $user)
    {
        try {
            $user->delete();

            return response()->json([
                'success' => true,
                'message' => 'Usuario eliminado con éxito'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el usuario',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
