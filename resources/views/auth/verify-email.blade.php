@php($mostrarSidebar = false)
@extends('layouts.app')

@section('main')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-primary shadow-sm">
                <div class="card-header bg-primary text-white text-center">
                    <h4 class="mb-0">Verificar Correo Electrónico</h4>
                </div>
                <div class="card-body p-4">
                    <div class="mb-4 text-sm text-muted">
                        ¡Gracias por registrarte! Antes de comenzar, ¿podrías verificar tu dirección de correo electrónico haciendo clic en el enlace que te acabamos de enviar? Si no recibiste el correo, con gusto te enviaremos otro.
                    </div>

                    @if (session('status') == 'verification-link-sent')
                        <div class="alert alert-success mb-4" role="alert">
                            Se ha enviado un nuevo enlace de verificación a la dirección de correo electrónico que proporcionaste durante el registro.
                        </div>
                    @endif

                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <form method="POST" action="{{ route('verification.send') }}">
                            @csrf
                            <button type="submit" class="btn btn-primary">
                                Reenviar correo de verificación
                            </button>
                        </form>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger">
                                Cerrar Sesión
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
