<!-- Buscar Pacientes -->
<div class="p-3 h-30 border border-secondary-subtle">
    <form class="d-flex" role="search" action="{{ route('pacientes.index') }}" method="GET">
        <input class="form-control me-2" type="search" name="search" placeholder="Buscar Pacientes" aria-label="Search" value="{{ request('search') }}" />
        <button class="btn btn-outline-info" type="submit">Buscar</button>
    </form>
</div>
<!-- Lista de Pacientes -->
<div class="p-3 border border-secondary-subtle flex-grow-1 d-flex flex-wrap align-items-start align-content-start overflow-auto">
    @auth
        @php
            $sidebarPacientes = \App\Models\Paciente::where('id_usuario_creador', Auth::id())
                ->when(request('search'), function($q) {
                    $q->where(function($query) {
                        $query->where('primer_nombre', 'like', '%' . request('search') . '%')
                              ->orWhere('primer_apellido', 'like', '%' . request('search') . '%')
                              ->orWhere('documento_identidad', 'like', '%' . request('search') . '%');
                    });
                })
                ->take(10)->get();
        @endphp

        @forelse ($sidebarPacientes as $paciente)
            @php
                $currentPacienteRoute = request()->route('paciente');
                $currentPacienteId = $currentPacienteRoute instanceof \App\Models\Paciente 
                    ? $currentPacienteRoute->id_paciente 
                    : $currentPacienteRoute;
                $isSelected = $currentPacienteId == $paciente->id_paciente;
            @endphp
            <div class="card mb-2 w-100 position-relative rounded-3 {{ $isSelected ? 'border-primary shadow-sm' : 'border-secondary-subtle' }}" 
                 style="transition: all 0.2s ease-in-out; cursor: pointer; {{ $isSelected ? 'background-color: #f8f9fa;' : '' }}"
                 onmouseover="this.style.transform='scale(1.02)'; this.style.boxShadow='0 .5rem 1rem rgba(13, 110, 253, .15)'; this.style.borderColor='#0a58ca';"
                 onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='{{ $isSelected ? '0 .125rem .25rem rgba(0,0,0,.075)' : 'none' }}'; this.style.borderColor='{{ $isSelected ? '#0d6efd' : '#dee2e6' }}';">
                <div class="card-body py-2 px-3">
                    <a href="{{ route('pacientes.show', $paciente->id_paciente) }}" class="stretched-link text-decoration-none">
                        <p class="mb-0 fw-bold {{ $isSelected ? 'text-primary' : 'text-dark' }}">{{ $paciente->primer_nombre }} {{ $paciente->primer_apellido }}</p>
                        <div class="d-flex justify-content-between align-items-center mt-1">
                            <small class="text-muted"><i class="bi bi-card-text"></i> {{ $paciente->documento_identidad }}</small>
                            <span class="badge {{ $isSelected ? 'bg-primary text-white' : 'bg-light text-muted' }} border border-primary-subtle"><i class="bi bi-chevron-right"></i></span>
                        </div>
                    </a>
                </div>
            </div>
        @empty
            <div class="flex-grow-1 d-grid gap-2 mt-4 text-center">
                <p class="text-muted">Parece que no tienes pacientes agregados o no coinciden con la búsqueda.</p>
                <a href="{{ route('pacientes.create') }}" class="btn btn-primary w-100">Registrar Paciente</a>
            </div>
        @endforelse
    @else
        <div class="flex-grow-1 text-center mt-4">
            <p class="text-muted">Inicia sesión para ver tus pacientes.</p>
        </div>
    @endauth
</div>
