@extends('layouts.app')

@section('title', 'Nuevo Proceso')

@section('page_title', 'Crear Nuevo Proceso')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('internal.procesos.index') }}">Procesos</a></li>
    <li class="breadcrumb-item active">Nuevo</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8">
        <form action="{{ route('internal.procesos.store') }}" method="POST" class="form-card">
            @csrf
            
            <h5 class="mb-4">
                <i class="fas fa-sitemap mr-2 text-primary"></i>
                Información Básica
            </h5>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="codigo">Código <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('codigo') is-invalid @enderror" id="codigo" name="codigo" placeholder="Ej: PROC-001" value="{{ old('codigo') }}">
                        @error('codigo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="descripcion">Descripción <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('descripcion') is-invalid @enderror" id="descripcion" name="descripcion" placeholder="Descripción del proceso" required value="{{ old('descripcion') }}">
                        @error('descripcion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="objetivo">Objetivo</label>
                <textarea class="form-control @error('objetivo') is-invalid @enderror" id="objetivo" name="objetivo" rows="2" placeholder="Objetivo del proceso">{{ old('objetivo') }}</textarea>
                @error('objetivo')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="observaciones">Observaciones</label>
                <textarea class="form-control @error('observaciones') is-invalid @enderror" id="observaciones" name="observaciones" rows="2" placeholder="Observaciones adicionales">{{ old('observaciones') }}</textarea>
                @error('observaciones')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <hr class="my-4">
            <h5 class="mb-4">
                <i class="fas fa-cogs mr-2 text-primary"></i>
                Configuración
            </h5>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="tipo_proceso_id">Tipo de Proceso <span class="text-danger">*</span></label>
                        <select class="form-control @error('tipo_proceso_id') is-invalid @enderror" id="tipo_proceso_id" name="tipo_proceso_id" required data-colors="{{ json_encode($tiposProceso->pluck('color', 'id')) }}" data-iconos="{{ json_encode($tiposProceso->pluck('icono', 'id')) }}">
                            <option value="">-- Seleccionar --</option>
                            @foreach($tiposProceso as $tipo)
                                <option value="{{ $tipo->id }}" {{ old('tipo_proceso_id') == $tipo->id ? 'selected' : '' }}>
                                    {{ $tipo->descripcion }}
                                </option>
                            @endforeach
                        </select>
                        @error('tipo_proceso_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div id="tipoPreview" style="display: none; padding: 10px; border-radius: 4px; color: white; margin-top: 8px; font-weight: 500; text-align: center;"></div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="estado_proceso_id">Estado <span class="text-danger">*</span></label>
                        <select class="form-control @error('estado_proceso_id') is-invalid @enderror" id="estado_proceso_id" name="estado_proceso_id" required data-colors="{{ json_encode($estadosProceso->pluck('color', 'id')) }}">
                            <option value="">-- Seleccionar --</option>
                            @foreach($estadosProceso as $estado)
                                <option value="{{ $estado->id }}" {{ old('estado_proceso_id') == $estado->id ? 'selected' : '' }}>
                                    {{ $estado->descripcion }}
                                </option>
                            @endforeach
                        </select>
                        @error('estado_proceso_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div id="estadoPreview" style="display: none; padding: 10px; border-radius: 4px; color: white; margin-top: 8px; font-weight: 500; text-align: center;"></div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="criticidad_proceso_id">Criticidad <span class="text-danger">*</span></label>
                        <select class="form-control @error('criticidad_proceso_id') is-invalid @enderror" id="criticidad_proceso_id" name="criticidad_proceso_id" required data-colors="{{ json_encode($criticidadesProceso->pluck('color', 'id')) }}">
                            <option value="">-- Seleccionar --</option>
                            @foreach($criticidadesProceso as $criticidad)
                                <option value="{{ $criticidad->id }}" {{ old('criticidad_proceso_id') == $criticidad->id ? 'selected' : '' }}>
                                    {{ $criticidad->descripcion }}
                                </option>
                            @endforeach
                        </select>
                        @error('criticidad_proceso_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div id="criticidadPreview" style="display: none; padding: 10px; border-radius: 4px; color: white; margin-top: 8px; font-weight: 500; text-align: center;"><i class="fas fa-exclamation-triangle mr-2"></i><span id="criticidadPreviewText"></span></div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="unidad_responsable_id">Unidad Responsable <span class="text-danger">*</span></label>
                        <select class="form-control @error('unidad_responsable_id') is-invalid @enderror" id="unidad_responsable_id" name="unidad_responsable_id" required>
                            <option value="">-- Seleccionar --</option>
                            @foreach($unidadesResponsables as $unidad)
                                <option value="{{ $unidad->id }}" {{ old('unidad_responsable_id') == $unidad->id ? 'selected' : '' }}>
                                    {{ $unidad->descripcion }}
                                </option>
                            @endforeach
                        </select>
                        @error('unidad_responsable_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="responsable_proceso_id">Responsable del Proceso</label>
                        <select class="form-control @error('responsable_proceso_id') is-invalid @enderror" id="responsable_proceso_id" name="responsable_proceso_id">
                            <option value="">-- Sin asignar --</option>
                            @foreach($personas as $persona)
                                <option value="{{ $persona->id }}" {{ old('responsable_proceso_id') == $persona->id ? 'selected' : '' }}>
                                    {{ $persona->nombres }} {{ $persona->apellido }}
                                </option>
                            @endforeach
                        </select>
                        @error('responsable_proceso_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="proceso_padre_id">Proceso Padre (si aplica)</label>
                        <select class="form-control @error('proceso_padre_id') is-invalid @enderror" id="proceso_padre_id" name="proceso_padre_id">
                            <option value="">-- Ninguno --</option>
                            @foreach($procesos as $proc)
                                <option value="{{ $proc->id }}" {{ old('proceso_padre_id') == $proc->id ? 'selected' : '' }}>
                                    {{ $proc->codigo }} - {{ $proc->descripcion }}
                                </option>
                            @endforeach
                        </select>
                        @error('proceso_padre_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="requiere_revision" name="requiere_revision" value="1" {{ old('requiere_revision') ? 'checked' : '' }}>
                    <label class="custom-control-label" for="requiere_revision">
                        Requiere Revisión
                    </label>
                </div>
            </div>

            <div class="form-group mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-2"></i> Guardar Proceso
                </button>
                <a href="{{ route('internal.procesos.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left mr-2"></i> Volver
                </a>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tipoSelect = document.getElementById('tipo_proceso_id');
    const estadoSelect = document.getElementById('estado_proceso_id');
    const criticidadSelect = document.getElementById('criticidad_proceso_id');
    
    const tipoColors = JSON.parse(tipoSelect.dataset.colors || '{}');
    const tipoIconos = JSON.parse(tipoSelect.dataset.iconos || '{}');
    const estadoColors = JSON.parse(estadoSelect.dataset.colors || '{}');
    const criticidadColors = JSON.parse(criticidadSelect.dataset.colors || '{}');
    
    const tipoPreview = document.getElementById('tipoPreview');
    const estadoPreview = document.getElementById('estadoPreview');
    const criticidadPreview = document.getElementById('criticidadPreview');
    
    function updateTipoPreview() {
        const selectedId = tipoSelect.value;
        const selectedText = tipoSelect.options[tipoSelect.selectedIndex].text;
        if (selectedId) {
            const color = tipoColors[selectedId] || '#0c5aa0';
            const icono = tipoIconos[selectedId] || 'fa-folder';
            tipoPreview.style.display = 'block';
            tipoPreview.style.backgroundColor = color;
            tipoPreview.innerHTML = `<i class="fas ${icono} mr-2"></i>${selectedText}`;
        } else {
            tipoPreview.style.display = 'none';
        }
    }
    
    function updateEstadoPreview() {
        const selectedId = estadoSelect.value;
        const selectedText = estadoSelect.options[estadoSelect.selectedIndex].text;
        if (selectedId) {
            const color = estadoColors[selectedId] || '#6c757d';
            estadoPreview.style.display = 'block';
            estadoPreview.style.backgroundColor = color;
            estadoPreview.textContent = selectedText;
        } else {
            estadoPreview.style.display = 'none';
        }
    }
    
    function updateCriticidadPreview() {
        const selectedId = criticidadSelect.value;
        const selectedText = criticidadSelect.options[criticidadSelect.selectedIndex].text;
        if (selectedId) {
            const color = criticidadColors[selectedId] || '#dc3545';
            criticidadPreview.style.display = 'block';
            criticidadPreview.style.backgroundColor = color;
            document.getElementById('criticidadPreviewText').textContent = selectedText;
        } else {
            criticidadPreview.style.display = 'none';
        }
    }
    
    tipoSelect.addEventListener('change', updateTipoPreview);
    estadoSelect.addEventListener('change', updateEstadoPreview);
    criticidadSelect.addEventListener('change', updateCriticidadPreview);
    
    // Initialize previews on page load
    updateTipoPreview();
    updateEstadoPreview();
    updateCriticidadPreview();
});
</script>
@endsection
