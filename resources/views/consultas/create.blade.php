@extends('layouts.app')

@section('main')
<div class="container py-4">
    <div class="card border-primary shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Registrar Consulta Médica</h4>
        </div>
        <div class="card-body p-4">
            <h5 class="mb-4 text-secondary">Paciente: {{ $paciente->primer_nombre }} {{ $paciente->primer_apellido }} (Exp: {{ $paciente->historiaMedica ? $paciente->historiaMedica->numero_expediente : 'Sin Historia' }})</h5>

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form action="{{ route('pacientes.consultas.store', $paciente->id_paciente) }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="motivo_consulta" class="form-label">Motivo de Consulta <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="motivo_consulta" name="motivo_consulta" rows="2" required>{{ old('motivo_consulta') }}</textarea>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="signos_vitales" class="form-label">Signos Vitales</label>
                        <textarea class="form-control" id="signos_vitales" name="signos_vitales" rows="3" placeholder="Ej: TA: 120/80 mmHg, FC: 75 lpm...">{{ old('signos_vitales') }}</textarea>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="examen_fisico" class="form-label">Examen Físico</label>
                        <textarea class="form-control" id="examen_fisico" name="examen_fisico" rows="3">{{ old('examen_fisico') }}</textarea>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="diagnostico" class="form-label">Diagnóstico <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="diagnostico" name="diagnostico" rows="2" required>{{ old('diagnostico') }}</textarea>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="plan_tratamiento" class="form-label">Plan y Tratamiento (General)</label>
                        <textarea class="form-control" id="plan_tratamiento" name="plan_tratamiento" rows="2">{{ old('plan_tratamiento') }}</textarea>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="tratamiento_recetado" class="form-label">Tratamiento Recetado (Medicinas)</label>
                        <textarea class="form-control" id="tratamiento_recetado" name="tratamiento_recetado" rows="3" placeholder="Ej: Paracetamol 500mg c/8h">{{ old('tratamiento_recetado') }}</textarea>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="examenes_solicitados" class="form-label">Exámenes Solicitados</label>
                        <textarea class="form-control" id="examenes_solicitados" name="examenes_solicitados" rows="3" placeholder="Ej: Hematología completa, Perfil lipídico...">{{ old('examenes_solicitados') }}</textarea>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-3">
                    <a href="{{ route('pacientes.show', $paciente->id_paciente) }}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Guardar Consulta</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
