@extends('layouts.app')

@section('title', 'Editar Proceso')

@section('page_title', 'Editar Proceso')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('internal.procesos.index') }}">Procesos</a></li>
    <li class="breadcrumb-item active">Editar</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8">
        <form action="{{ route('internal.procesos.update', $proceso->id) }}" method="POST" class="form-card">
            @csrf
            @method('PUT')
            
            

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="codigo">Código <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('codigo') is-invalid @enderror" id="codigo" name="codigo" placeholder="Ej: PROC-001" value="{{ old('codigo', $proceso->codigo) }}">
                        @error('codigo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="descripcion">Descripción <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('descripcion') is-invalid @enderror" id="descripcion" name="descripcion" placeholder="Descripción del proceso" required value="{{ old('descripcion', $proceso->descripcion) }}">
                        @error('descripcion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="objetivo">Objetivo</label>
                <textarea class="form-control @error('objetivo') is-invalid @enderror" id="objetivo" name="objetivo" rows="2" placeholder="Objetivo del proceso">{{ old('objetivo', $proceso->objetivo) }}</textarea>
                @error('objetivo')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="observaciones">Observaciones</label>
                <textarea class="form-control @error('observaciones') is-invalid @enderror" id="observaciones" name="observaciones" rows="2" placeholder="Observaciones adicionales">{{ old('observaciones', $proceso->observaciones) }}</textarea>
                @error('observaciones')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="tipo_proceso_id">Tipo de Proceso <span class="text-danger">*</span></label>
                        <select class="form-control @error('tipo_proceso_id') is-invalid @enderror" id="tipo_proceso_id" name="tipo_proceso_id" required>
                            <option value="">-- Seleccionar --</option>
                            @foreach($tiposProceso as $tipo)
                                <option value="{{ $tipo->id }}" {{ old('tipo_proceso_id', $proceso->tipo_proceso_id) == $tipo->id ? 'selected' : '' }}>
                                    {{ $tipo->descripcion }}
                                </option>
                            @endforeach
                        </select>
                        @error('tipo_proceso_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="estado_proceso_id">Estado <span class="text-danger">*</span></label>
                        <select class="form-control @error('estado_proceso_id') is-invalid @enderror" id="estado_proceso_id" name="estado_proceso_id" required>
                            <option value="">-- Seleccionar --</option>
                            @foreach($estadosProceso as $estado)
                                <option value="{{ $estado->id }}" {{ old('estado_proceso_id', $proceso->estado_proceso_id) == $estado->id ? 'selected' : '' }}>
                                    {{ $estado->descripcion }}
                                </option>
                            @endforeach
                        </select>
                        @error('estado_proceso_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="criticidad_proceso_id">Criticidad <span class="text-danger">*</span></label>
                        <select class="form-control @error('criticidad_proceso_id') is-invalid @enderror" id="criticidad_proceso_id" name="criticidad_proceso_id" required>
                            <option value="">-- Seleccionar --</option>
                            @foreach($criticidadesProceso as $criticidad)
                                <option value="{{ $criticidad->id }}" {{ old('criticidad_proceso_id', $proceso->criticidad_proceso_id) == $criticidad->id ? 'selected' : '' }}>
                                    {{ $criticidad->descripcion }}
                                </option>
                            @endforeach
                        </select>
                        @error('criticidad_proceso_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="proceso_padre_id">Proceso Padre (si aplica)</label>
                        <select class="form-control @error('proceso_padre_id') is-invalid @enderror" id="proceso_padre_id" name="proceso_padre_id">
                            <option value="">-- Ninguno --</option>
                            @foreach($procesos as $proc)
                                <option value="{{ $proc->id }}" {{ old('proceso_padre_id', $proceso->proceso_padre_id) == $proc->id ? 'selected' : '' }}>
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
                    <input type="checkbox" class="custom-control-input" id="requiere_revision" name="requiere_revision" value="1" {{ old('requiere_revision', $proceso->requiere_revision) ? 'checked' : '' }}>
                    <label class="custom-control-label" for="requiere_revision">
                        Requiere Revisión
                    </label>
                </div>
            </div>

            <div class="form-group mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-2"></i> Guardar Cambios
                </button>
                <a href="{{ route('internal.procesos.show', $proceso->id) }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left mr-2"></i> Volver
                </a>
            </div>
        </form>
    </div>
</div>

<script>
// Previews removed per UX decision: no colored badges in edit view.
</script>
@endsection
