<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Expediente - {{ $paciente->documento_identidad }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #0056b3;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            color: #0056b3;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0 0;
            font-size: 14px;
            color: #666;
        }
        .section-title {
            background-color: #0056b3;
            color: white;
            padding: 5px 10px;
            font-size: 14px;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            width: 30%;
        }
        .consulta-card {
            border: 1px solid #0056b3;
            margin-bottom: 15px;
            page-break-inside: avoid;
        }
        .consulta-header {
            background-color: #e6f0fa;
            padding: 8px;
            border-bottom: 1px solid #0056b3;
            font-weight: bold;
        }
        .consulta-body {
            padding: 8px;
        }
        .consulta-body p {
            margin: 5px 0;
        }
        .consulta-body strong {
            color: #0056b3;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Historia Médica del Paciente</h1>
        <p>Generado el: {{ date('d/m/Y H:i') }}</p>
    </div>

    <div class="section-title">Datos Personales</div>
    <table>
        <tr>
            <th>Expediente Nº</th>
            <td>{{ $paciente->historiaMedica ? $paciente->historiaMedica->numero_expediente : 'Sin Historia' }}</td>
        </tr>
        <tr>
            <th>Nombre Completo</th>
            <td>{{ $paciente->primer_nombre }} {{ $paciente->segundo_nombre }} {{ $paciente->primer_apellido }} {{ $paciente->segundo_apellido }}</td>
        </tr>
        <tr>
            <th>Documento</th>
            <td>{{ $paciente->documento_identidad }}</td>
        </tr>
        <tr>
            <th>Fecha de Nacimiento</th>
            <td>{{ \Carbon\Carbon::parse($paciente->fecha_nacimiento)->format('d/m/Y') }}</td>
        </tr>
        <tr>
            <th>Género</th>
            <td>{{ $paciente->genero }}</td>
        </tr>
        <tr>
            <th>Teléfono</th>
            <td>{{ $paciente->telefono ?? 'No registrado' }}</td>
        </tr>
        <tr>
            <th>Tipo de Sangre</th>
            <td>{{ $paciente->historiaMedica->tipo_sangre ?? 'No registrado' }}</td>
        </tr>
    </table>

    @if($paciente->historiaMedica && $paciente->historiaMedica->antecedentes->count() > 0)
        <div class="section-title">Antecedentes Médicos</div>
        <ul>
            @foreach($paciente->historiaMedica->antecedentes as $ant)
                <li><strong>{{ $ant->tipo_antecedente }}:</strong> {{ $ant->descripcion }}</li>
            @endforeach
        </ul>
    @endif

    <div class="section-title">Historial de Consultas</div>
    @if($paciente->historiaMedica && $paciente->historiaMedica->consultas->count() > 0)
        @foreach($paciente->historiaMedica->consultas->sortByDesc('fecha_consulta') as $consulta)
            <div class="consulta-card">
                <div class="consulta-header">
                    Fecha: {{ \Carbon\Carbon::parse($consulta->fecha_consulta)->format('d/m/Y H:i') }} | Médico: Dr(a). {{ $consulta->medico->apellido ?? 'Desconocido' }}
                </div>
                <div class="consulta-body">
                    <p><strong>Motivo de Consulta:</strong> {{ $consulta->motivo_consulta }}</p>
                    <p><strong>Signos Vitales:</strong> {{ $consulta->signos_vitales ?? 'No registrados' }}</p>
                    <p><strong>Examen Físico:</strong> {{ $consulta->examen_fisico ?? 'No registrado' }}</p>
                    <p><strong>Diagnóstico:</strong> {{ $consulta->diagnostico }}</p>
                    <p><strong>Plan General:</strong> {{ $consulta->plan_tratamiento ?? 'Ninguno' }}</p>
                    <p><strong>Tratamiento Recetado:</strong> {{ $consulta->tratamiento_recetado ?? 'Ninguno' }}</p>
                    <p><strong>Exámenes Solicitados:</strong> {{ $consulta->examenes_solicitados ?? 'Ninguno' }}</p>
                </div>
            </div>
        @endforeach
    @else
        <p>No hay consultas registradas para este paciente.</p>
    @endif

</body>
</html>
