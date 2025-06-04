<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evaluacion;
use PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EvaluacionExport;

class ReporteController extends Controller
{
    // Generar reporte en PDF
    public function generarPDF($id)
    {
        // Cargar las relaciones del proveedor y del responsable
        $evaluacion = Evaluacion::with(['proveedor', 'responsable'])->findOrFail($id);

        $pdf = PDF::loadView('reportes.evaluacion_pdf', [
            'evaluacion' => $evaluacion,
            'proveedorNombre' => $evaluacion->proveedor->nombreRazonSocial, // Acceder solo al nombre del proveedor
            'responsableNombre' => $evaluacion->responsable->nombre ?? 'N/A', // Acceder solo al nombre del responsable
        ]);

        return $pdf->download('detalle_evaluacion.pdf');
    }


    // Generar reporte en Excel
    public function generarExcel($id)
    {
        return Excel::download(new EvaluacionExport($id), 'detalle_evaluacion.xlsx');
    }
}
