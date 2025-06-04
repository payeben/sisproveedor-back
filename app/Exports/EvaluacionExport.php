<?php

namespace App\Exports;

use App\Models\Evaluacion;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EvaluacionExport implements FromCollection, WithHeadings
{
    protected $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function collection()
    {
        return Evaluacion::with('proveedor')->get()->map(function ($evaluacion) {
            return [
                'ID' => $evaluacion->id,
                'Proveedor' => $evaluacion->proveedor->nombreRazonSocial, // Acceder solo al nombre
                'Responsable' => $evaluacion->responsable->nombre,
                'Fecha' => $evaluacion->fecha,
                'Resultado' => $evaluacion->resultado,
                'Comentarios' => $evaluacion->comentarios,
                'Nivel de Criticidad' => $evaluacion->nivelCriticidad,
                'Frecuencia Definida' => $evaluacion->frecuenciaDefinida,
                'Resultado Cierre de Gestión' => $evaluacion->resultadoCierreGestion,
                'Resultado Enero' => $evaluacion->resultadoEnero,
                'Resultado Julio' => $evaluacion->resultadoJulio,
                'Promedio Anual' => $evaluacion->promedioAnual,
                'Fecha de Creación' => $evaluacion->created_at,
                'Última Actualización' => $evaluacion->updated_at,
            ];
        });
    }


    public function headings(): array
    {
        return [
            'ID',
            'Proveedor',
            'Responsable',
            'Fecha',
            'Resultado',
            'Comentarios',
            'Nivel de Criticidad',
            'Frecuencia Definida',
            'Resultado Cierre de Gestión',
            'Resultado Enero',
            'Resultado Julio',
            'Promedio Anual',
            'Fecha de Creación',
            'Última Actualización',
        ];
    }
}
