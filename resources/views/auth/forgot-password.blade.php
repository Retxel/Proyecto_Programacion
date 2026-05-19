@php($mostrarSidebar = false)
@extends('layouts.app')

@section('main')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-primary shadow-sm">
                <div class="card-header bg-primary text-white text-center">
                    <h4 class="mb-0">Restablecer Contraseña</h4>
                </div>
                <div class="card-body p-4">
                    <div class="mb-4 text-sm text-muted">
                        ¿Olvidaste tu contraseña? No hay problema. Solo dinos tu dirección de correo electrónico y te enviaremos un enlace para restablecerla que te permitirá elegir una nueva.
                    </div>

                    <!-- Session Status -->
                    @if (session('status'))
                        <div class="alert alert-success mb-4" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <!-- Email Address -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Correo Electrónico</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required autofocus>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid mt-3">
                            <button type="submit" class="btn btn-primary">
                                Enviar enlace para restablecer contraseña
                            </button>
                        </div>
                        <div class="text-center mt-3">
                            <a href="{{ route('login') }}" class="text-decoration-none">Volver al inicio de sesión</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
