@extends('layouts.app')

@section('main')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Listado de Pacientes</h2>
        <a href="{{ route('pacientes.create') }}" class="btn btn-primary">Registrar Nuevo Paciente</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-primary shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-primary">
                        <tr>
                            <th>Expediente</th>
                            <th>Documento</th>
                            <th>Nombre Completo</th>
                            <th>Fecha Nacimiento</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pacientes as $paciente)
                        <tr>
                            <td>{{ $paciente->historiaMedica ? $paciente->historiaMedica->numero_expediente : 'N/A' }}</td>
                            <td>{{ $paciente->documento_identidad }}</td>
                            <td>{{ $paciente->primer_nombre }} {{ $paciente->primer_apellido }}</td>
                            <td>{{ \Carbon\Carbon::parse($paciente->fecha_nacimiento)->format('d/m/Y') }}</td>
                            <td>
                                <a href="{{ route('pacientes.show', $paciente->id_paciente) }}" class="btn btn-sm btn-outline-info">Ver</a>
                                <!-- <a href="{{ route('pacientes.edit', $paciente->id_paciente) }}" class="btn btn-sm btn-outline-warning">Editar</a> -->
                                <form action="{{ route('pacientes.destroy', $paciente->id_paciente) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Eliminar paciente?')">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4">No hay pacientes registrados.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
