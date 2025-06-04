<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use Illuminate\Http\Request;

class RolController extends Controller
{
    // Listar todos los roles
    public function index()
    {
        return response()->json(Rol::all(), 200);
    }

    // Crear un nuevo rol
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:rols,nombre',
            'descripcion' => 'nullable|string|max:1000',
        ]);

        $rol = Rol::create($request->all());

        return response()->json([
            'message' => 'Rol creado con éxito',
            'data' => $rol
        ], 201);
    }

    // Mostrar un rol específico
    public function show($id)
    {
        $rol = Rol::find($id);

        if (!$rol) {
            return response()->json(['message' => 'Rol no encontrado'], 404);
        }

        return response()->json($rol, 200);
    }

    // Actualizar un rol
    public function update(Request $request, $id)
    {
        $rol = Rol::find($id);

        if (!$rol) {
            return response()->json(['message' => 'Rol no encontrado'], 404);
        }

        $request->validate([
            'nombre' => 'string|max:255|unique:rols,nombre,' . $rol->id,
            'descripcion' => 'nullable|string|max:1000',
        ]);

        $rol->update($request->all());

        return response()->json([
            'message' => 'Rol actualizado con éxito',
            'data' => $rol
        ], 200);
    }

    // Eliminar un rol
    public function destroy($id)
    {
        $rol = Rol::find($id);

        if (!$rol) {
            return response()->json(['message' => 'Rol no encontrado'], 404);
        }

        $rol->delete();

        return response()->json([
            'message' => 'Rol eliminado con éxito',
            'id' => $id
        ], 200);
    }
}
