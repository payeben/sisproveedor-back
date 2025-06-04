<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluacion extends Model
{
    use HasFactory;

    // Especificar el nombre correcto de la tabla
    protected $table = 'evaluaciones';

    // Definir los campos que se pueden asignar masivamente
    protected $fillable = [
        'proveedor_id', // Relación con Proveedor
        'responsableEvaluacion', // Usuario responsable de la evaluación
        'fecha', // Fecha de la evaluación
        'resultado', // Resultado de la evaluación
        'comentarios', // Comentarios adicionales
        'nivelCriticidad', // Nivel de criticidad
        'frecuenciaDefinida', // Frecuencia definida para la evaluación
        'resultadoCierreGestion', // Resultado de cierre de gestión
        'resultadoEnero', // Resultado del mes de enero
        'resultadoJulio', // Resultado del mes de julio
        'promedioAnual', // Promedio anual de resultados
    ];

    /**
     * Relación con el modelo Proveedor.
     * Una evaluación pertenece a un proveedor.
     */
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'proveedor_id');
    }

    /**
     * Relación con el modelo User (Usuario).
     * Una evaluación tiene un responsable (usuario).
     */
    public function responsable()
    {
        return $this->belongsTo(User::class, 'responsableEvaluacion');
    }
}
