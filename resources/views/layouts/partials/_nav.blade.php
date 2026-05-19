<nav class="navbar navbar-expand-md bg-light border border-secondary-subtle px-2" data-bs-theme="light">
    <a class="navbar-brand" href="{{ url('/') }}">Historias Médicas</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            @auth
            <li class="nav-item">
                <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('pacientes.index') }}">Pacientes</a>
            </li>
            @endauth
        </ul>
        <div class="d-flex align-items-center">
            @auth
                <span class="me-3">Dr(a). {{ Auth::user()->nombre }} {{ Auth::user()->apellido }}</span>
                <form method="POST" action="{{ route('logout') }}" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm">Cerrar Sesión</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm me-2">Ingresar</a>
                <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Registrarse</a>
            @endauth
        </div>
    </div>
</nav>
