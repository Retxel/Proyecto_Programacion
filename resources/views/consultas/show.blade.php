@extends('layouts.app')

@section('main')
<div class="container py-4">
    <div class="card border-primary shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Detalle de Consulta Médica</h4>
            <a href="{{ route('pacientes.show', $consulta->historiaMedica->id_paciente) }}" class="btn btn-light btn-sm">Volver al Expediente</a>
        </div>
        <div class="card-body p-4">
            <div class="row mb-4 border-bottom pb-3">
                <div class="col-md-6">
                    <h5 class="text-secondary">Información del Paciente</h5>
                    @php $paciente = $consulta->historiaMedica->paciente; @endphp
                    <p class="mb-1"><strong>Nombre:</strong> {{ $paciente->primer_nombre }} {{ $paciente->primer_apellido }}</p>
                    <p class="mb-1"><strong>Documento:</strong> {{ $paciente->documento_identidad }}</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <h5 class="text-secondary">Información de la Consulta</h5>
                    <p class="mb-1"><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($consulta->fecha_consulta)->format('d/m/Y H:i') }}</p>
                    <p class="mb-1"><strong>Médico:</strong> Dr(a). {{ $consulta->medico->nombre }} {{ $consulta->medico->apellido }}</p>
                </div>
            </div>

            <div class="mb-4">
                <h5 class="text-primary"><i class="bi bi-patch-question"></i> Motivo de Consulta</h5>
                <p class="bg-light p-3 rounded border">{{ $consulta->motivo_consulta }}</p>
            </div>

            <div class="row mb-4">
                <div class="col-md-6">
                    <h5 class="text-info"><i class="bi bi-activity"></i> Signos Vitales</h5>
                    <div class="bg-light p-3 rounded border text-muted" style="min-height: 80px;">
                        {!! nl2br(e($consulta->signos_vitales ?? 'No registrados')) !!}
                    </div>
                </div>
                <div class="col-md-6">
                    <h5 class="text-info"><i class="bi bi-heart-pulse"></i> Examen Físico</h5>
                    <div class="bg-light p-3 rounded border text-muted" style="min-height: 80px;">
                        {!! nl2br(e($consulta->examen_fisico ?? 'No registrado')) !!}
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <h5 class="text-primary"><i class="bi bi-journal-medical"></i> Diagnóstico</h5>
                <p class="bg-light p-3 rounded border font-weight-bold">{{ $consulta->diagnostico }}</p>
            </div>

            <div class="mb-4">
                <h5 class="text-success"><i class="bi bi-card-checklist"></i> Plan de Tratamiento General</h5>
                <p class="bg-light p-3 rounded border">{{ $consulta->plan_tratamiento ?? 'Sin plan registrado' }}</p>
            </div>

            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card border-warning mb-3">
                        <div class="card-header bg-warning text-dark"><i class="bi bi-capsule"></i> Tratamiento Recetado (Medicinas)</div>
                        <div class="card-body bg-light">
                            <p class="mb-0">{!! nl2br(e($consulta->tratamiento_recetado ?? 'Ninguno')) !!}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card border-info mb-3">
                        <div class="card-header bg-info text-white"><i class="bi bi-file-earmark-medical"></i> Exámenes Solicitados</div>
                        <div class="card-body bg-light">
                            <p class="mb-0">{!! nl2br(e($consulta->examenes_solicitados ?? 'Ninguno')) !!}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4 border-top pt-3">
                <a href="{{ route('consultas.edit', $consulta->id_consulta) }}" class="btn btn-warning"><i class="bi bi-pencil"></i> Editar Consulta</a>
                <form action="{{ route('consultas.destroy', $consulta->id_consulta) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('¿Seguro que deseas eliminar esta consulta?')"><i class="bi bi-trash"></i> Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
