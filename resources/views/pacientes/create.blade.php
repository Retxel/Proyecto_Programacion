@php($mostrarSidebar = false)

@extends('layouts.app')

@section('main')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-primary">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Registrar Paciente</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('pacientes.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="primer_nombre" class="form-label">Primer Nombre</label>
                                    <input type="text" class="form-control" id="primer_nombre" name="primer_nombre"
                                        required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="segundo_nombre" class="form-label">Segundo Nombre</label>
                                    <input type="text" class="form-control" id="segundo_nombre" name="segundo_nombre">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="primer_apellido" class="form-label">Primer Apellido</label>
                                    <input type="text" class="form-control" id="primer_apellido" name="primer_apellido"
                                        required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="segundo_apellido" class="form-label">Segundo Apellido</label>
                                    <input type="text" class="form-control" id="segundo_apellido"
                                        name="segundo_apellido">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="documento_identidad" class="form-label">Documento</label>
                                    <input type="text" class="form-control" id="documento_identidad" name="documento_identidad" required>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                                    <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" required>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="genero" class="form-label">Género</label>
                                    <select class="form-select" id="genero" name="genero" required>
                                        <option value="">Selecciona...</option>
                                        <option value="Masculino">Masculino</option>
                                        <option value="Femenino">Femenino</option>
                                        <option value="Otro">Otro</option>
                                    </select>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="telefono" class="form-label">Teléfono</label>
                                    <input type="text" class="form-control" id="telefono" name="telefono">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="correo" class="form-label">Correo electrónico</label>
                                    <input type="email" class="form-control" id="correo" name="correo">
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="antecedentes_personales" class="form-label">Antecedentes Personales</label>
                                    <textarea class="form-control" id="antecedentes_personales" name="antecedentes_personales" rows="2"></textarea>
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="antecedentes_quirurgicos" class="form-label">Antecedentes
                                        Quirúrgicos</label>
                                    <textarea class="form-control" id="antecedentes_quirurgicos" name="antecedentes_quirurgicos" rows="2"></textarea>
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="antecedentes_familiares" class="form-label">Antecedentes
                                        Familiares</label>
                                    <textarea class="form-control" id="antecedentes_familiares" name="antecedentes_familiares" rows="2"></textarea>
                                </div>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">Registrar</button>
                                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">Cancelar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
