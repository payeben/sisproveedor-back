<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;
    protected $table = 'proveedors';
    protected $fillable = [
        'nombreRazonSocial',
        'NIT',
        'direccion',
        'telefono',
        'personaContacto',
        'celular',
        'encargadoCobranza',
        'correoElectronico',
        'productoServicio',
        'proveedorNuevo',
        'tipoProveedor',
    ];
}
