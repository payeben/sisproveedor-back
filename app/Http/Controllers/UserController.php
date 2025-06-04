<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Listar todos los usuarios
    public function index()
    {
        return response()->json(User::with('rol')->get(), 200);
    }

    // Crear un nuevo usuario
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'telefono' => 'nullable|string|max:20',
            'password' => 'required|string|min:6',
            'rol_id' => 'required|exists:rols,id',
        ]);

        $data = $request->all();
        $data['password'] = bcrypt($data['password']); // Encriptar la contraseña

        $user = User::create($data);

        return response()->json([
            'message' => 'Usuario creado con éxito',
            'data' => $user->load('rol') // Cargar la relación con Rol
        ], 201);
    }

    // Mostrar un usuario específico
    public function show($id)
    {
        $user = User::with('rol')->find($id);

        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        return response()->json($user, 200);
    }

    // Actualizar un usuario
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        $request->validate([
            'nombre' => 'string|max:255',
            'apellido' => 'string|max:255',
            'email' => 'string|email|max:255|unique:users,email,' . $user->id,
            'telefono' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:6',
            'rol_id' => 'exists:rols,id',
        ]);

        $data = $request->all();

        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']); // Encriptar la nueva contraseña
        }

        $user->update($data);

        return response()->json([
            'message' => 'Usuario actualizado con éxito',
            'data' => $user->load('rol') // Cargar la relación con Rol
        ], 200);
    }

    // Eliminar un usuario
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        $user->delete();

        return response()->json([
            'message' => 'Usuario eliminado con éxito',
            'id' => $id
        ], 200);
    }
}
