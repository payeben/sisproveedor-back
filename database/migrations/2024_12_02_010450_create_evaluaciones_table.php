<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEvaluacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluaciones', function (Blueprint $table) {
            $table->id(); // ID autoincremental
            $table->unsignedBigInteger('proveedor_id'); // Relación con proveedores
            $table->unsignedBigInteger('responsableEvaluacion'); // Relación con usuarios
            $table->date('fecha'); // Fecha de la evaluación
            $table->string('resultado')->nullable(); // Resultado de la evaluación
            $table->text('comentarios')->nullable(); // Comentarios adicionales
            $table->string('nivelCriticidad')->nullable(); // Nivel de criticidad
            $table->string('frecuenciaDefinida')->nullable(); // Frecuencia definida
            $table->string('resultadoCierreGestion')->nullable(); // Resultado de cierre de gestión
            $table->string('resultadoEnero')->nullable(); // Resultado en enero
            $table->string('resultadoJulio')->nullable(); // Resultado en julio
            $table->string('promedioAnual')->nullable(); // Promedio anual
            $table->timestamps(); // Campos created_at y updated_at

            // Claves foráneas
            $table->foreign('proveedor_id')->references('id')->on('proveedors')->onDelete('cascade');
            $table->foreign('responsableEvaluacion')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('evaluaciones');
    }
}
