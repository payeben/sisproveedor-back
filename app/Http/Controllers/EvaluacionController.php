<?php

namespace App\Http\Controllers;

use App\Models\Evaluacion;
use Illuminate\Http\Request;

class EvaluacionController extends Controller
{
    // Listar todas las evaluaciones con paginación
    public function index()
    {
        return Evaluacion::with('proveedor', 'responsable')->paginate(10); // Devuelve 10 registros por página
    }

    // Crear una nueva evaluación
    public function store(Request $request)
    {
        $request->validate([
            'proveedor_id' => 'required|exists:proveedors,id',
            'responsableEvaluacion' => 'required|exists:users,id',
            'fecha' => 'required|date',
            'resultado' => 'required|integer|min:1|max:10',
            'comentarios' => 'nullable|string|max:1000',
            'nivelCriticidad' => 'required|string|in:Baja,Media,Alta',
            'frecuenciaDefinida' => 'required|string|in:Mensual,Trimestral,Semestral,Anual',
        ]);

        $proveedorId = $request->proveedor_id;
        $currentYear = date('Y');

        // Resultado de Enero: Evaluaciones en enero del año actual
        $resultadoEnero = Evaluacion::where('proveedor_id', $proveedorId)
            ->whereYear('fecha', $currentYear)
            ->whereMonth('fecha', 1)
            ->avg('resultado') ?? 0;

        // Resultado de Julio: Promedio de enero a julio del año actual
        $resultadoJulio = Evaluacion::where('proveedor_id', $proveedorId)
            ->whereYear('fecha', $currentYear)
            ->whereBetween('fecha', ["$currentYear-01-01", "$currentYear-07-31"])
            ->avg('resultado') ?? 0;

        // Resultado de Cierre de Gestión: Promedio de enero a junio y julio a diciembre
        $cierreEneroJunio = Evaluacion::where('proveedor_id', $proveedorId)
            ->whereYear('fecha', $currentYear)
            ->whereBetween('fecha', ["$currentYear-01-01", "$currentYear-06-30"])
            ->avg('resultado') ?? 0;

        $cierreJulioDiciembre = Evaluacion::where('proveedor_id', $proveedorId)
            ->whereYear('fecha', $currentYear)
            ->whereBetween('fecha', ["$currentYear-07-01", "$currentYear-12-31"])
            ->avg('resultado') ?? 0;

        $resultadoCierreGestion = ($cierreEneroJunio + $cierreJulioDiciembre) / 2;

        // Promedio Anual: Todas las evaluaciones del año actual
        $promedioAnual = Evaluacion::where('proveedor_id', $proveedorId)
            ->whereYear('fecha', $currentYear)
            ->avg('resultado') ?? 0;

        // Crear la evaluación
        $evaluacion = Evaluacion::create([
            'proveedor_id' => $proveedorId,
            'responsableEvaluacion' => $request->responsableEvaluacion,
            'fecha' => $request->fecha,
            'resultado' => $request->resultado,
            'comentarios' => $request->comentarios,
            'nivelCriticidad' => $request->nivelCriticidad,
            'frecuenciaDefinida' => $request->frecuenciaDefinida,
            'resultadoCierreGestion' => $resultadoCierreGestion,
            'resultadoEnero' => $resultadoEnero,
            'resultadoJulio' => $resultadoJulio,
            'promedioAnual' => $promedioAnual,
        ]);

        return response()->json($evaluacion, 201);
    }



    // Mostrar una evaluación específica
    public function show($id)
    {
        $evaluacion = Evaluacion::with('proveedor', 'responsable')->find($id);

        if (!$evaluacion) {
            return response()->json(['message' => 'Evaluación no encontrada'], 404);
        }

        return response()->json($evaluacion, 200);
    }

    // Actualizar una evaluación
    public function update(Request $request, $id)
    {
        $evaluacion = Evaluacion::find($id);

        if (!$evaluacion) {
            return response()->json(['message' => 'Evaluación no encontrada'], 404);
        }

        $request->validate([
            'proveedor_id' => 'exists:proveedors,id',
            'responsableEvaluacion' => 'exists:users,id',
            'fecha' => 'date',
            'resultado' => 'nullable|string|max:255',
            'comentarios' => 'nullable|string',
            'nivelCriticidad' => 'nullable|string|max:255',
            'frecuenciaDefinida' => 'nullable|string|max:255',
            'resultadoCierreGestion' => 'nullable|string|max:255',
            'resultadoEnero' => 'nullable|string|max:255',
            'resultadoJulio' => 'nullable|string|max:255',
            'promedioAnual' => 'nullable|string|max:255',
        ]);

        $evaluacion->update($request->all());

        return response()->json([
            'message' => 'Evaluación actualizada con éxito',
            'data' => $evaluacion->load('proveedor', 'responsable') // Cargar relaciones
        ], 200);
    }

    // Eliminar una evaluación
    public function destroy($id)
    {
        $evaluacion = Evaluacion::find($id);

        if (!$evaluacion) {
            return response()->json(['message' => 'Evaluación no encontrada'], 404);
        }

        $deletedId = $evaluacion->id;
        $evaluacion->delete();

        return response()->json([
            'message' => 'Evaluación eliminada con éxito',
            'id' => $deletedId
        ], 200);
    }
}
