@extends('layouts.app')

@section('title', 'Ver Proceso')

@section('page_title', 'Detalles del Proceso')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('internal.procesos.index') }}">Procesos</a></li>
    <li class="breadcrumb-item active">{{ $proceso->codigo ?? 'Ver' }}</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8">
        <!-- Card Principal de Información -->
        <div class="form-card mb-3">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="text-muted small">Código</label>
                        <p class="h5 text-primary"><strong>{{ $proceso->codigo }}</strong></p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="text-muted small">Estado</label>
                        <p>
                            @php
                                $estadoColor = match($proceso->estadoProceso->descripcion ?? '') {
                                    'Borrador' => 'warning',
                                    'En análisis' => 'info',
                                    'En revisión' => 'secondary',
                                    'Aprobado' => 'success',
                                    'Vigente' => 'success',
                                    'Observado' => 'danger',
                                    'Archivado' => 'dark',
                                    default => 'secondary'
                                };
                            @endphp
                            <span class="badge badge-{{ $estadoColor }} p-2">
                                {{ $proceso->estadoProceso->descripcion ?? '-' }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label class="text-muted small">Descripción</label>
                <p class="h6">{{ $proceso->descripcion }}</p>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="text-muted small">Tipo de Proceso</label>
                        <p>
                            <span class="badge badge-info p-2">
                                {{ $proceso->tipoProceso->descripcion ?? '-' }}
                            </span>
                        </p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="text-muted small">Criticidad</label>
                        <p>
                            @php
                                $criticidadColor = match($proceso->criticidadProceso->descripcion ?? '') {
                                    'Baja' => 'success',
                                    'Media' => 'warning',
                                    'Alta' => 'danger',
                                    default => 'secondary'
                                };
                            @endphp
                            <span class="badge badge-{{ $criticidadColor }} p-2">
                                <i class="fas fa-exclamation-triangle mr-1"></i>
                                {{ $proceso->criticidadProceso->descripcion ?? '-' }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="text-muted small">Unidad Responsable</label>
                        <p class="h6">{{ $proceso->unidadResponsable->descripcion ?? '-' }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="text-muted small">Responsable del Proceso</label>
                        <p class="h6">
                            @if($proceso->responsable)
                                {{ $proceso->responsable->nombres . ' ' . $proceso->responsable->apellido }}
                            @else
                                <span class="text-muted">No asignado</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            @if($proceso->objetivo)
                <div class="mb-3">
                    <label class="text-muted small">Objetivo</label>
                    <p>{{ $proceso->objetivo }}</p>
                </div>
            @endif

            @if($proceso->observaciones)
                <div class="mb-3">
                    <label class="text-muted small">Observaciones</label>
                    <p class="text-muted">{{ $proceso->observaciones }}</p>
                </div>
            @endif

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="text-muted small">Requiere Revisión</label>
                        <p>
                            @if($proceso->requiere_revision)
                                <span class="badge badge-danger">
                                    <i class="fas fa-check-circle mr-1"></i>Sí
                                </span>
                            @else
                                <span class="badge badge-success">
                                    <i class="fas fa-times-circle mr-1"></i>No
                                </span>
                            @endif
                        </p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="text-muted small">Creado</label>
                        <p class="text-muted">{{ $proceso->created_at ? $proceso->created_at->format('d/m/Y H:i A') : 'N/A' }}</p>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('internal.procesos.edit', $proceso->id) }}" class="btn btn-primary-pro">
                    <i class="fas fa-pencil-alt mr-2"></i> Editar
                </a>
                <a href="{{ route('internal.procesos.index') }}" class="btn btn-secondary-pro">
                    <i class="fas fa-arrow-left mr-2"></i> Volver
                </a>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Card de Información Rápida -->
        <div class="info-card mb-3">
            <h6 class="card-title">
                <i class="fas fa-info-circle mr-2 text-info"></i>
                Información Rápida
            </h6>
            <hr class="my-2">
            <div class="info-item">
                <span class="info-label">Total de Flujos:</span>
                <span class="info-value badge badge-primary">{{ count($proceso->flujos) }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Proceso Padre:</span>
                <span class="info-value">
                    @if($proceso->procesoPadre)
                        <a href="{{ route('internal.procesos.show', $proceso->procesoPadre->id) }}">
                            {{ $proceso->procesoPadre->codigo }} - {{ $proceso->procesoPadre->descripcion }}
                        </a>
                    @else
                        <span class="text-muted">-</span>
                    @endif
                </span>
            </div>
        </div>
    </div>
</div>

<!-- Card de Flujos -->
@if(count($proceso->flujos) > 0)
    <div class="row mt-3">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">
                        <i class="fas fa-project-diagram mr-2 text-primary"></i>
                        Flujos Asociados ({{ count($proceso->flujos) }})
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        @forelse($proceso->flujos as $flujo)
                            <div class="col-md-6 mb-3">
                                <div class="flujo-card">
                                    <div class="flujo-header">
                                        <h6 class="mb-2">{{ $flujo->descripcion }}</h6>
                                        <span class="badge badge-secondary">{{ $flujo->tipoFlujo->descripcion ?? '-' }}</span>
                                    </div>

                                    @if(count($flujo->personas) > 0)
                                        <div class="flujo-section mt-2">
                                            <p class="text-muted small mb-2">
                                                <i class="fas fa-users mr-1"></i>
                                                <strong>Personas ({{ count($flujo->personas) }}):</strong>
                                            </p>
                                            <div class="personas-list">
                                                @foreach($flujo->personas as $persona)
                                                    <span class="badge badge-light border border-primary mr-1 mb-1">
                                                        <i class="fas fa-user mr-1"></i>{{ $persona->nombres }} {{ $persona->apellido }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    @if(count($flujo->tiposActores) > 0)
                                        <div class="flujo-section mt-2">
                                            <p class="text-muted small mb-2">
                                                <i class="fas fa-shield-alt mr-1"></i>
                                                <strong>Roles ({{ count($flujo->tiposActores) }}):</strong>
                                            </p>
                                            <div class="roles-list">
                                                @foreach($flujo->tiposActores as $rol)
                                                    <span class="badge badge-warning mr-1 mb-1">
                                                        {{ $rol->descripcion }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    @if($flujo->observaciones)
                                        <div class="flujo-section mt-2">
                                            <p class="text-muted small">
                                                <i class="fas fa-sticky-note mr-1"></i>
                                                {{ $flujo->observaciones }}
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <p class="text-muted">No hay flujos asociados</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="row mt-3">
        <div class="col-12">
            <div class="alert alert-info">
                <i class="fas fa-info-circle mr-2"></i>
                Este proceso no tiene flujos asociados aún.
            </div>
        </div>
    </div>
@endif

<style>
.info-card {
    background: #f8f9fa;
    border-left: 4px solid #007bff;
    padding: 1rem;
    border-radius: 4px;
}

.info-item {
    display: flex;
    justify-content: space-between;
    padding: 0.5rem 0;
    border-bottom: 1px solid #dee2e6;
}

.info-item:last-child {
    border-bottom: none;
}

.info-label {
    font-weight: 500;
    color: #666;
    font-size: 0.9rem;
}

.info-value {
    color: #333;
    font-weight: 500;
}

.flujo-card {
    background: #fff;
    border: 1px solid #dee2e6;
    border-radius: 6px;
    padding: 1rem;
    transition: all 0.3s ease;
}

.flujo-card:hover {
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    border-color: #007bff;
}

.flujo-header {
    border-bottom: 1px solid #dee2e6;
    padding-bottom: 0.75rem;
}

.flujo-section {
    border-top: 1px solid #f0f0f0;
    padding-top: 0.75rem;
}

.personas-list,
.roles-list {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
}
</style>
@endsection
