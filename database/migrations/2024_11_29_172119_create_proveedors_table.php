<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proveedors', function (Blueprint $table) {
            $table->id();
            $table->string('nombreRazonSocial');
            $table->string('NIT')->unique();
            $table->string('direccion')->nullable();
            $table->string('telefono')->nullable();
            $table->string('personaContacto')->nullable();
            $table->string('celular')->nullable();
            $table->string('encargadoCobranza')->nullable();
            $table->string('correoElectronico')->unique();
            $table->string('productoServicio');
            $table->boolean('proveedorNuevo')->default(true);
            $table->string('tipoProveedor');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proveedors');
    }
};
