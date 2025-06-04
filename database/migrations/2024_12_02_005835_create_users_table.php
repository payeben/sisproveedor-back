<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // ID autoincremental
            $table->string('nombre'); // Nombre del usuario
            $table->string('apellido'); // Apellido del usuario
            $table->string('email')->unique(); // Correo electrónico único
            $table->string('telefono')->nullable(); // Teléfono (opcional)
            $table->string('password'); // Contraseña
            $table->unsignedBigInteger('rol_id'); // Relación con la tabla roles
            $table->rememberToken(); // Token de "remember me"
            $table->timestamps(); // Campos created_at y updated_at

            // Clave foránea para rol_id
            $table->foreign('rol_id')->references('id')->on('rols')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
