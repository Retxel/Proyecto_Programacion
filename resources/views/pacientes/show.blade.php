@extends('layouts.app')

@section('main')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Expediente del Paciente</h2>
        <div>
            <a href="{{ route('pacientes.exportPdf', $paciente->id_paciente) }}" class="btn btn-danger me-2"><i class="bi bi-file-earmark-pdf"></i> Exportar PDF</a>
            <a href="{{ route('pacientes.consultas.create', $paciente->id_paciente) }}" class="btn btn-success me-2">Nueva Consulta</a>
            <a href="{{ route('pacientes.index') }}" class="btn btn-outline-secondary">Volver al Listado</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card border-info shadow-sm h-100">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Datos Personales</h5>
                </div>
                <div class="card-body">
                    <p><strong>Nombre:</strong> {{ $paciente->primer_nombre }} {{ $paciente->segundo_nombre }} {{ $paciente->primer_apellido }} {{ $paciente->segundo_apellido }}</p>
                    <p><strong>Documento:</strong> {{ $paciente->documento_identidad }}</p>
                    <p><strong>Fecha Nacimiento:</strong> {{ \Carbon\Carbon::parse($paciente->fecha_nacimiento)->format('d/m/Y') }}</p>
                    <p><strong>Género:</strong> {{ $paciente->genero }}</p>
                    <p><strong>Teléfono:</strong> {{ $paciente->telefono ?? 'N/A' }}</p>
                    <p><strong>Correo:</strong> {{ $paciente->correo ?? 'N/A' }}</p>
                    @if($paciente->historiaMedica)
                        <hr>
                        <p><strong>Nº Expediente:</strong> {{ $paciente->historiaMedica->numero_expediente }}</p>
                        <p><strong>Tipo de Sangre:</strong> {{ $paciente->historiaMedica->tipo_sangre ?? 'No registrado' }}</p>
                        
                        @if($paciente->historiaMedica->antecedentes->count() > 0)
                            <hr>
                            <h6 class="text-primary mt-2">Antecedentes</h6>
                            <ul class="list-unstyled mb-0">
                                @foreach($paciente->historiaMedica->antecedentes as $ant)
                                    <li><strong>{{ $ant->tipo_antecedente }}:</strong> {{ $ant->descripcion }}</li>
                                @endforeach
                            </ul>
                        @endif
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-8 mb-4">
            <div class="card border-primary shadow-sm h-100">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Historial de Consultas</h5>
                </div>
                <div class="card-body">
                    @if($paciente->historiaMedica && $paciente->historiaMedica->consultas->count() > 0)
                        <div class="accordion" id="accordionConsultas">
                            @foreach($paciente->historiaMedica->consultas->sortByDesc('fecha_consulta') as $consulta)
                                <div class="accordion-item border-primary mb-2 border rounded">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button {{ $loop->first ? '' : 'collapsed' }} text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $consulta->id_consulta }}">
                                            <strong>{{ \Carbon\Carbon::parse($consulta->fecha_consulta)->format('d/m/Y') }}</strong>&nbsp;- Dr(a). {{ $consulta->medico->apellido ?? 'Desconocido' }}&nbsp;-&nbsp;<span class="text-muted">{{ Str::limit($consulta->motivo_consulta, 40) }}</span>
                                        </button>
                                    </h2>
                                    <div id="collapse{{ $consulta->id_consulta }}" class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}" data-bs-parent="#accordionConsultas">
                                        <div class="accordion-body">
                                            <h6 class="text-primary">Motivo de Consulta</h6>
                                            <p>{{ $consulta->motivo_consulta }}</p>
                                            
                                            <div class="row mt-3">
                                                <div class="col-md-6">
                                                    <h6 class="text-info">Signos Vitales</h6>
                                                    <p class="text-muted">{{ $consulta->signos_vitales ?? 'No registrados' }}</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <h6 class="text-info">Examen Físico</h6>
                                                    <p class="text-muted">{{ $consulta->examen_fisico ?? 'No registrado' }}</p>
                                                </div>
                                            </div>

                                            <h6 class="mt-2 text-primary">Diagnóstico</h6>
                                            <p>{{ $consulta->diagnostico }}</p>

                                            <h6 class="mt-2 text-success">Plan de Tratamiento General</h6>
                                            <p>{{ $consulta->plan_tratamiento ?? 'Sin plan registrado' }}</p>

                                            <div class="row mt-3 bg-light p-3 rounded border">
                                                <div class="col-md-6 mb-2 mb-md-0">
                                                    <h6 class="text-secondary"><i class="bi bi-capsule"></i> Tratamiento Recetado</h6>
                                                    <p class="mb-0 text-dark">{{ $consulta->tratamiento_recetado ?? 'Ninguno' }}</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <h6 class="text-secondary"><i class="bi bi-file-earmark-medical"></i> Exámenes Solicitados</h6>
                                                    <p class="mb-0 text-dark">{{ $consulta->examenes_solicitados ?? 'Ninguno' }}</p>
                                                </div>
                                            </div>
                                            
                                            <div class="mt-3 text-end">
                                                <form action="{{ route('consultas.destroy', $consulta->id_consulta) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Eliminar esta consulta permanentemente?')">Eliminar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5 text-muted">
                            <p>Este paciente no tiene consultas registradas aún.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
