@php($mostrarSidebar = false)
@extends('layouts.app')

@section('main')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-primary shadow-sm">
                <div class="card-header bg-primary text-white text-center">
                    <h4 class="mb-0">Confirmar Contraseña</h4>
                </div>
                <div class="card-body p-4">
                    <div class="mb-4 text-sm text-muted">
                        Esta es un área segura de la aplicación. Por favor, confirma tu contraseña antes de continuar.
                    </div>

                    <form method="POST" action="{{ route('password.confirm') }}">
                        @csrf

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required autocomplete="current-password" autofocus>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid mt-3">
                            <button type="submit" class="btn btn-primary">
                                Confirmar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
