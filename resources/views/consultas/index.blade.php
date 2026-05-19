@extends('layouts.app')

@section('main')
<div class="container py-4">
    <div class="card border-primary shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Listado de Consultas: {{ $paciente->primer_nombre }} {{ $paciente->primer_apellido }}</h4>
            <a href="{{ route('pacientes.show', $paciente->id_paciente) }}" class="btn btn-light btn-sm">Volver al Expediente</a>
        </div>
        <div class="card-body p-4">
            @if($consultas->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Fecha</th>
                                <th>Médico</th>
                                <th>Motivo de Consulta</th>
                                <th>Diagnóstico</th>
                                <th class="text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($consultas as $consulta)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($consulta->fecha_consulta)->format('d/m/Y H:i') }}</td>
                                    <td>Dr(a). {{ $consulta->medico->nombre }} {{ $consulta->medico->apellido }}</td>
                                    <td>{{ Str::limit($consulta->motivo_consulta, 50) }}</td>
                                    <td>{{ Str::limit($consulta->diagnostico, 50) }}</td>
                                    <td class="text-end">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('consultas.show', $consulta->id_consulta) }}" class="btn btn-sm btn-outline-info">Ver</a>
                                            <a href="{{ route('consultas.edit', $consulta->id_consulta) }}" class="btn btn-sm btn-outline-warning">Editar</a>
                                            <form action="{{ route('consultas.destroy', $consulta->id_consulta) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Seguro que deseas eliminar esta consulta?')">Eliminar</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5 text-muted">
                    <p>Este paciente no tiene consultas registradas aún.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
