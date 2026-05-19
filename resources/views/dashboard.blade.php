@extends('layouts.app')

@section('main')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card border-primary shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Dashboard</h4>
                </div>
                <div class="card-body">
                    <h5>¡Bienvenido, {{ Auth::user()->nombre }} {{ Auth::user()->apellido }}!</h5>
                    <p>Has iniciado sesión exitosamente en el sistema de gestión de Historias Médicas.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
