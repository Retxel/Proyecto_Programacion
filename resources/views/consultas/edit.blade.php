<!-- resources/views/consultas/edit.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Editar Consulta</h2>
    <form method="POST" action="{{ route('consultas.update', $consulta->id_consulta) }}">
        @csrf
        @method('PUT')

        <div class="row g-3">
            <div class="col-md-6 mb-3">
                <label for="motivo_consulta" class="form-label">Motivo de la Consulta</label>
                <input type="text" class="form-control @error('motivo_consulta') is-invalid @enderror"
                       id="motivo_consulta" name="motivo_consulta"
                       value="{{ old('motivo_consulta', $consulta->motivo_consulta) }}" required>
                @error('motivo_consulta')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="signos_vitales" class="form-label">Signos Vitales</label>
                <input type="text" class="form-control @error('signos_vitales') is-invalid @enderror"
                       id="signos_vitales" name="signos_vitales"
                       value="{{ old('signos_vitales', $consulta->signos_vitales) }}">
                @error('signos_vitales')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-3">
            <label for="examen_fisico" class="form-label">Examen Físico</label>
            <textarea class="form-control @error('examen_fisico') is-invalid @enderror" id="examen_fisico" name="examen_fisico" rows="3">{{ old('examen_fisico', $consulta->examen_fisico) }}</textarea>
            @error('examen_fisico')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="diagnostico" class="form-label">Diagnóstico</label>
            <textarea class="form-control @error('diagnostico') is-invalid @enderror" id="diagnostico" name="diagnostico" rows="3" required>{{ old('diagnostico', $consulta->diagnostico) }}</textarea>
            @error('diagnostico')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="plan_tratamiento" class="form-label">Plan de Tratamiento (General)</label>
            <textarea class="form-control @error('plan_tratamiento') is-invalid @enderror" id="plan_tratamiento" name="plan_tratamiento" rows="2">{{ old('plan_tratamiento', $consulta->plan_tratamiento) }}</textarea>
            @error('plan_tratamiento')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="row g-3">
            <div class="col-md-6 mb-3">
                <label for="tratamiento_recetado" class="form-label">Tratamiento Recetado (Medicinas)</label>
                <textarea class="form-control @error('tratamiento_recetado') is-invalid @enderror" id="tratamiento_recetado" name="tratamiento_recetado" rows="3" placeholder="Ej: Paracetamol 500 mg c/8h">{{ old('tratamiento_recetado', $consulta->tratamiento_recetado) }}</textarea>
                @error('tratamiento_recetado')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="examenes_solicitados" class="form-label">Exámenes Solicitados</label>
                <textarea class="form-control @error('examenes_solicitados') is-invalid @enderror" id="examenes_solicitados" name="examenes_solicitados" rows="3" placeholder="Ej: Hematología completa, Perfil lipídico...">{{ old('examenes_solicitados', $consulta->examenes_solicitados) }}</textarea>
                @error('examenes_solicitados')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary me-2">Cancelar</a>
            <button type="submit" class="btn btn-primary">Actualizar Consulta</button>
        </div>
    </form>
</div>
@endsection
