<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private function setCorsHeaders()
    {
        header("Access-Control-Allow-Origin: http://frontend.local");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization");

        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(200);
            exit();
        }
    }

    public function index()
    {
        $this->setCorsHeaders(); // <-- aplicas CORS aquí
        $users = User::included()->filter()->sort()->getOrPaginate();
        return response()->json($users);
    }

    public function show(User $user)
    {
        $this->setCorsHeaders(); // <-- y aquí
        return response()->json($user);
    }

    public function update(Request $request, User $user)
    {
        $this->setCorsHeaders(); // <-- aquí también
        $user->update($request->all());
        return response()->json($user);
    }

    public function destroy(User $user)
    {
        $this->setCorsHeaders(); // <-- y aquí
        $user->delete();
        return response()->json(['message' => 'Usuario eliminado con éxito']);
    }
}
