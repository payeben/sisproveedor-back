<!DOCTYPE html>
<html>
<head>
    <title>Detalle de la Evaluación</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #003A72;
            color: white;
        }
    </style>
</head>
<body>
<h2>Detalle de la Evaluación</h2>
<table>
    <tr><th>ID</th><td>{{ $evaluacion->id }}</td></tr>
    <tr><th>Proveedor</th><td>{{ $proveedorNombre }}</td></tr>
    <tr><th>Responsable</th><td>{{ $responsableNombre }}</td></tr>
    <tr><th>Fecha</th><td>{{ $evaluacion->fecha }}</td></tr>
    <tr><th>Resultado</th><td>{{ $evaluacion->resultado }}</td></tr>
    <tr><th>Comentarios</th><td>{{ $evaluacion->comentarios }}</td></tr>
    <tr><th>Nivel de Criticidad</th><td>{{ $evaluacion->nivelCriticidad }}</td></tr>
    <tr><th>Frecuencia Definida</th><td>{{ $evaluacion->frecuenciaDefinida }}</td></tr>
    <tr><th>Resultado Cierre de Gestión</th><td>{{ $evaluacion->resultadoCierreGestion }}</td></tr>
    <tr><th>Resultado Enero</th><td>{{ $evaluacion->resultadoEnero }}</td></tr>
    <tr><th>Resultado Julio</th><td>{{ $evaluacion->resultadoJulio }}</td></tr>
    <tr><th>Promedio Anual</th><td>{{ $evaluacion->promedioAnual }}</td></tr>
    <tr><th>Fecha de Creación</th><td>{{ $evaluacion->created_at }}</td></tr>
    <tr><th>Última Actualización</th><td>{{ $evaluacion->updated_at }}</td></tr>
</table>
</body>
</html>
