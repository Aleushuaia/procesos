@extends('layouts.app')

@section('title', 'Editar Documento')
@section('page_title', 'Editar Documento')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('internal.procesos.index') }}">Procesos</a></li>
    <li class="breadcrumb-item"><a href="{{ route('internal.procesos.show', $proceso->id) }}">{{ $proceso->codigo }}</a></li>
    <li class="breadcrumb-item active">Editar Documento</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12 col-lg-6 offset-lg-3">
        <div class="card">
            <div class="card-header bg-light">
                <i class="fas fa-file-pdf text-danger mr-2"></i>
                <h5 class="mb-0 d-inline">Editar Documento</h5>
            </div>
            <div class="card-body">
                <form id="editDocumentoForm" action="{{ route('internal.procesos.documentos.update', [$proceso->id, $documento->id]) }}" method="POST" class="needs-validation">
                    @csrf
                    @method('PUT')

                    <!-- Información del documento -->
                    <div class="mb-4">
                        <h6 class="text-primary mb-3">
                            <i class="fas fa-info-circle mr-2"></i>
                            Información del Documento
                        </h6>

                        <div class="form-group">
                            <label for="descripcion">Descripción <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('descripcion') is-invalid @enderror" 
                                   id="descripcion" name="descripcion" 
                                   value="{{ old('descripcion', $documento->descripcion) }}"
                                   placeholder="Descripción del documento" required maxlength="100">
                            <small class="form-text text-muted">Máximo 100 caracteres</small>
                            @error('descripcion')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="tipo_proceso_documento_id">Tipo de Documento <span class="text-danger">*</span></label>
                            <select class="form-control @error('tipo_proceso_documento_id') is-invalid @enderror" 
                                    id="tipo_proceso_documento_id" name="tipo_proceso_documento_id" required>
                                <option value="">-- Seleccionar --</option>
                                @foreach($tiposDocumento as $tipo)
                                    <option value="{{ $tipo->id }}" 
                                        {{ old('tipo_proceso_documento_id', $documento->tipo_proceso_documento_id) == $tipo->id ? 'selected' : '' }}>
                                        {{ $tipo->descripcion }}
                                    </option>
                                @endforeach
                            </select>
                            @error('tipo_proceso_documento_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <hr class="my-4">

                    <!-- Información del archivo (solo lectura) -->
                    <div class="mb-4">
                        <h6 class="text-primary mb-3">
                            <i class="fas fa-file mr-2"></i>
                            Información del Archivo (Solo lectura)
                        </h6>

                        <div class="form-group">
                            <label for="nombre_archivo">Nombre del Archivo</label>
                            <input type="text" class="form-control" id="nombre_archivo" 
                                   value="{{ $documento->nombre_archivo }}" disabled>
                            <small class="form-text text-muted">No se puede cambiar el nombre del archivo</small>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tamanio">Tamaño</label>
                                    <input type="text" class="form-control" id="tamanio" 
                                           value="{{ $documento->tamanio_formateado }}" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fecha_subida">Fecha de Subida</label>
                                    <input type="text" class="form-control" id="fecha_subida" 
                                           value="{{ $documento->created_at->format('d/m/Y H:i') }}" disabled>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="extension">Extensión</label>
                            <input type="text" class="form-control" id="extension" 
                                   value="{{ strtoupper($documento->extension) }}" disabled>
                        </div>
                    </div>

                    <hr class="my-4">

                    <!-- Botones de Acción -->
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary-pro">
                            <i class="fas fa-save mr-1"></i>Guardar Cambios
                        </button>
                        <a href="{{ route('internal.procesos.show', $proceso->id) . '?panel=documentos' }}" class="btn btn-secondary">
                            <i class="fas fa-times mr-1"></i>Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('editDocumentoForm')?.addEventListener('submit', function(e) {
    // Allow form submission to proceed normally, but ensure redirect keeps panel open
    // The form will POST to the update route which should redirect with the panel parameter
});

// Optional: If you want to handle the redirect via JavaScript for POST requests
// Uncomment the code below and modify the form action accordingly
/*
document.getElementById('editDocumentoForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    const form = this;
    const formData = new FormData(form);
    
    fetch(form.action, {
        method: 'POST',
        body: formData,
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => {
        if (response.ok) {
            window.location.href = '{{ route('internal.procesos.show', $proceso->id) }}' + '?panel=documentos';
        } else {
            response.json().then(data => {
                console.error('Error:', data);
                alert('Error al guardar los cambios');
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al guardar los cambios');
    });
});
*/
</script>
@endsection
