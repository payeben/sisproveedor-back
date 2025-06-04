<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    public function index()
    {
        return Proveedor::paginate(10); // Devuelve 10 registros por página
    }


    public function store(Request $request)
    {
        $request->validate([
            'nombreRazonSocial' => 'required|string|max:255',
            'NIT' => 'required|string|max:20|unique:proveedors,NIT',
            'direccion' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'personaContacto' => 'nullable|string|max:255',
            'celular' => 'nullable|string|max:20',
            'encargadoCobranza' => 'nullable|string|max:255',
            'correoElectronico' => 'required|string|email|max:255|unique:proveedors,correoElectronico',
            'productoServicio' => 'required|string|max:255',
            'proveedorNuevo' => 'required|boolean',
            'tipoProveedor' => 'required|string|max:255',
        ]);

        $proveedor = Proveedor::create($request->all());

        return response()->json([
            'message' => 'Proveedor creado con éxito',
            'data' => $proveedor
        ], 201);
    }


    public function show($id)
    {
        $proveedor = Proveedor::find($id);

        if (!$proveedor) {
            return response()->json(['message' => 'Proveedor no encontrado'], 404);
        }

        return response()->json($proveedor, 200);
    }



    public function update(Request $request, $id)
    {
        // Buscar el proveedor por ID
        $proveedor = Proveedor::find($id);

        // Verificar si el proveedor existe
        if (!$proveedor) {
            return response()->json(['message' => 'Proveedor no encontrado'], 404);
        }

        // Validar los datos de la solicitud
        $request->validate([
            'nombreRazonSocial' => 'string|max:255',
            'NIT' => 'string|max:20|unique:proveedors,NIT,' . $proveedor->id,
            'direccion' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'personaContacto' => 'nullable|string|max:255',
            'celular' => 'nullable|string|max:20',
            'encargadoCobranza' => 'nullable|string|max:255',
            'correoElectronico' => 'string|email|max:255|unique:proveedors,correoElectronico,' . $proveedor->id,
            'productoServicio' => 'string|max:255',
            'proveedorNuevo' => 'boolean',
            'tipoProveedor' => 'string|max:255',
        ]);

        // Actualizar el proveedor con los datos de la solicitud
        $proveedor->update($request->all());

        // Devolver la respuesta con el proveedor actualizado
        return response()->json([
            'message' => 'Proveedor actualizado con éxito',
            'data' => $proveedor
        ], 200);
    }


    public function destroy($id)
    {
        // Buscar el proveedor por ID
        $proveedor = Proveedor::find($id);

        // Verificar si el proveedor existe
        if (!$proveedor) {
            return response()->json(['message' => 'Proveedor no encontrado'], 404);
        }

        // Guardar el ID antes de eliminar
        $deletedId = $proveedor->id;

        // Eliminar el proveedor
        $proveedor->delete();

        // Devolver la respuesta con el ID eliminado
        return response()->json([
            'message' => 'Proveedor eliminado con éxito',
            'id' => $deletedId
        ], 200);
    }



}
