@extends('layouts.app')

@section('title', 'Editar Flujo')
@section('page_title', 'Editar Flujo')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('internal.procesos.index') }}">Procesos</a></li>
    <li class="breadcrumb-item"><a href="{{ route('internal.procesos.show', $proceso->id) }}">{{ $proceso->codigo }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('internal.procesos.flujos.show', [$proceso->id, $flujo->id]) }}">{{ $flujo->descripcion }}</a></li>
    <li class="breadcrumb-item active">Editar</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12 col-lg-8 offset-lg-2">
        <div class="card">
            <div class="card-header bg-light">
                <i class="fas fa-pencil-alt text-primary mr-2"></i>
                <h5 class="mb-0 d-inline">Editar Flujo</h5>
            </div>
            <div class="card-body">
                <form id="editFlujoForm" action="{{ route('internal.procesos.flujos.update', [$proceso->id, $flujo->id]) }}" method="POST" class="needs-validation">
                    @csrf
                    @method('PUT')

                    <!-- Información Básica -->
                    <div class="mb-4">
                        <h6 class="text-primary mb-3">
                            <i class="fas fa-info-circle mr-2"></i>
                            Información Básica
                        </h6>

                        <div class="form-group">
                            <label for="descripcion">Descripción <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('descripcion') is-invalid @enderror" 
                                   id="descripcion" name="descripcion" 
                                   value="{{ old('descripcion', $flujo->descripcion) }}"
                                   placeholder="Descripción del flujo" required maxlength="255">
                            <small class="form-text text-muted">Máximo 255 caracteres</small>
                            @error('descripcion')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="tipo_flujo_id">Tipo de Flujo <span class="text-danger">*</span></label>
                            <select class="form-control @error('tipo_flujo_id') is-invalid @enderror" 
                                    id="tipo_flujo_id" name="tipo_flujo_id" required>
                                <option value="">-- Seleccionar --</option>
                                @foreach($tiposFlujo as $tipo)
                                    <option value="{{ $tipo->id }}" 
                                        {{ old('tipo_flujo_id', $flujo->tipo_flujo_id) == $tipo->id ? 'selected' : '' }}>
                                        {{ $tipo->descripcion }}
                                    </option>
                                @endforeach
                            </select>
                            @error('tipo_flujo_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="observaciones">Observaciones</label>
                            <textarea class="form-control @error('observaciones') is-invalid @enderror" 
                                      id="observaciones" name="observaciones" 
                                      rows="3" placeholder="Observaciones o notas adicionales" maxlength="1000">{{ old('observaciones', $flujo->observaciones) }}</textarea>
                            <small class="form-text text-muted">Máximo 1000 caracteres</small>
                            @error('observaciones')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <hr class="my-4">

                    <!-- Fechas -->
                    <div class="mb-4">
                        <h6 class="text-primary mb-3">
                            <i class="fas fa-calendar-alt mr-2"></i>
                            Fechas
                        </h6>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fecha_inicio_analisis">Fecha Inicio de Análisis</label>
                                    <input type="date" class="form-control @error('fecha_inicio_analisis') is-invalid @enderror" 
                                           id="fecha_inicio_analisis" name="fecha_inicio_analisis"
                                           value="{{ old('fecha_inicio_analisis', $flujo->fecha_inicio_analisis ? $flujo->fecha_inicio_analisis->format('Y-m-d') : '') }}">
                                    @error('fecha_inicio_analisis')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fecha_firma_version">Fecha Firma de Versión</label>
                                    <input type="date" class="form-control @error('fecha_firma_version') is-invalid @enderror" 
                                           id="fecha_firma_version" name="fecha_firma_version"
                                           value="{{ old('fecha_firma_version', $flujo->fecha_firma_version ? $flujo->fecha_firma_version->format('Y-m-d') : '') }}">
                                    <small class="form-text text-muted">Debe ser igual o posterior a la fecha de inicio</small>
                                    @error('fecha_firma_version')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <!-- Personas -->
                    <div class="mb-4">
                        <h6 class="text-primary mb-3">
                            <i class="fas fa-users mr-2"></i>
                            Personas Involucradas
                        </h6>

                        <div class="form-group">
                            <label for="personas">Seleccionar Personas</label>
                            <select class="form-control @error('personas') is-invalid @enderror" 
                                    id="personas" name="personas[]" multiple size="6">
                                @foreach($personas as $persona)
                                    <option value="{{ $persona->id }}"
                                        {{ in_array($persona->id, $personasSeleccionadas) ? 'selected' : '' }}>
                                        {{ $persona->apellido }}, {{ $persona->nombres }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle mr-1"></i>
                                Mantén Ctrl/Cmd presionado para seleccionar múltiples personas
                            </small>
                            @error('personas')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <hr class="my-4">

                    <!-- Tipos de Actores (Roles) -->
                    <div class="mb-4">
                        <h6 class="text-primary mb-3">
                            <i class="fas fa-shield-alt mr-2"></i>
                            Roles/Tipos de Actores
                        </h6>

                        <div class="form-group">
                            <label for="tipos_actores">Seleccionar Roles</label>
                            <select class="form-control @error('tipos_actores') is-invalid @enderror" 
                                    id="tipos_actores" name="tipos_actores[]" multiple size="6">
                                @foreach($tiposActores as $actor)
                                    <option value="{{ $actor->id }}"
                                        {{ in_array($actor->id, $tiposActoresSeleccionados) ? 'selected' : '' }}>
                                        {{ $actor->descripcion }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle mr-1"></i>
                                Mantén Ctrl/Cmd presionado para seleccionar múltiples roles
                            </small>
                            @error('tipos_actores')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <hr class="my-4">

                    <!-- Botones de Acción -->
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary-pro">
                            <i class="fas fa-save mr-1"></i>Guardar Cambios
                        </button>
                        <a href="{{ route('internal.procesos.flujos.show', [$proceso->id, $flujo->id]) }}" class="btn btn-secondary">
                            <i class="fas fa-times mr-1"></i>Cancelar
                        </a>
                        <a href="{{ route('internal.procesos.show', $proceso->id) }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left mr-1"></i>Volver al Proceso
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('editFlujoForm')?.addEventListener('submit', function(e) {
    // Validar fechas
    const fechaInicio = document.getElementById('fecha_inicio_analisis').value;
    const fechaFirma = document.getElementById('fecha_firma_version').value;
    
    if (fechaInicio && fechaFirma && new Date(fechaFirma) < new Date(fechaInicio)) {
        e.preventDefault();
        alert('La fecha de firma debe ser igual o posterior a la fecha de inicio del análisis');
        return false;
    }
});
</script>
@endsection
