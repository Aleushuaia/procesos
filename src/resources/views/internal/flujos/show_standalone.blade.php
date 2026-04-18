@extends('layouts.app')

@section('title', 'Ver Flujo')
@section('page_title', 'Detalles del Flujo')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('internal.procesos.index') }}">Procesos</a></li>
    <li class="breadcrumb-item"><a href="{{ route('internal.procesos.show', $proceso->id) }}">{{ $proceso->codigo }}</a></li>
    <li class="breadcrumb-item active">{{ $flujo->descripcion ?? 'Flujo' }}</li>
@endsection

@section('content')
<style>
.table-crud { font-size: 0.9375rem; border-collapse: collapse; }
.table-crud thead { background-color: #f8f9fa; }
.table-crud th { 
    font-size: 0.8125rem; 
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 0.75rem;
    border-bottom: 1px solid #dee2e6;
    vertical-align: middle;
}
.table-crud tbody tr { border-bottom: 1px solid #dee2e6; }
.table-crud tbody td { 
    padding: 0.75rem;
    vertical-align: middle;
    font-size: 0.9375rem;
    line-height: 1.4;
    color: white;
}
.table-crud tbody td span { 
    font-size: 0.9375rem;
    color: white;
}
.panel-icon { display: inline-block; transition: transform 0.3s; }
.collapse:not(.show) ~ .card-header .panel-icon { transform: rotate(-90deg); }
.card-header h5 { font-size: 0.95rem; margin: 0; }
.card-header { padding: 0.5rem 0.75rem; cursor: pointer; }
.card { font-size: 0.9375rem; }
.card .badge { font-size: 0.8125rem; }
</style>
<div class="row">
    <div class="col-12">
        <!-- PANEL 1: DETALLES DEL FLUJO (COLAPSABLE) -->
        <div class="card mb-3">
            <div class="card-header bg-light d-flex align-items-center justify-content-between" style="cursor: pointer;" data-toggle="collapse" data-target="#detallesFlujosContent">
                <div class="d-flex align-items-center">
                    <i class="fas fa-chevron-down mr-2 panel-icon"></i>
                    <i class="fas fa-stream text-primary mr-2"></i>
                    <h5 class="mb-0">Detalles del Flujo</h5>
                </div>
                <div class="d-flex gap-2 ml-auto">
                    <a href="{{ route('internal.procesos.flujos.edit', [$proceso->id, $flujo->id]) }}" class="btn btn-primary-pro btn-sm" onclick="event.stopPropagation();"><i class="fas fa-pencil-alt mr-1"></i>Editar</a>
                    <a href="{{ route('internal.procesos.show', $proceso->id) }}" class="btn btn-secondary btn-sm" onclick="event.stopPropagation();"><i class="fas fa-arrow-left mr-1"></i>Volver</a>
                </div>
            </div>
            <div class="collapse" id="detallesFlujosContent">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-8">
                            <div class="mb-2">
                                <label class="text-muted small d-block">Descripción</label>
                                <p class="h6 mb-0"><strong class="text-primary">{{ $flujo->descripcion }}</strong></p>
                            </div>
                            @if($flujo->observaciones)
                                <div class="mb-2">
                                    <label class="text-muted small d-block">Observaciones</label>
                                    <p class="mb-0 small">{{ $flujo->observaciones }}</p>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-4">
                            <label class="text-muted small d-block">Tipo de Flujo</label>
                            <span class="badge p-2 w-100 text-center" style="background-color: #17a2b8; color: white;">
                                {{ $flujo->tipoFlujo->descripcion ?? '-' }}
                            </span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label class="text-muted small d-block">Fecha Inicio de Análisis</label>
                            <p class="h6 mb-0">{{ $flujo->fecha_inicio_analisis ? $flujo->fecha_inicio_analisis->format('d/m/Y') : '-' }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small d-block">Fecha Firma de Versión</label>
                            <p class="h6 mb-0">{{ $flujo->fecha_firma_version ? $flujo->fecha_firma_version->format('d/m/Y') : '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- PANEL 2: DOCUMENTOS ASOCIADOS (COLAPSABLE) -->
        <div class="card mb-3">
            <div class="card-header bg-light d-flex align-items-center justify-content-between" style="cursor: pointer;" data-toggle="collapse" data-target="#documentosFlujosContent">
                <div class="d-flex align-items-center">
                    <i class="fas fa-chevron-down mr-2 panel-icon"></i>
                    <i class="fas fa-file-pdf text-danger mr-2"></i>
                    <h5 class="mb-0">Documentos Asociados <span class="badge badge-danger ml-2">{{ $flujo->documentos->count() }}</span></h5>
                </div>
                <div class="panel-actions ml-auto">
                    <button class="btn btn-primary-pro btn-sm" data-toggle="modal" data-target="#uploadFlujDocumentoModal" onclick="event.stopPropagation();"><i class="fas fa-upload mr-1"></i>Subir</button>
                </div>
            </div>
            <div class="collapse" id="documentosFlujosContent">
                <div class="card-body p-0">
                    @if($flujo->documentos->count() > 0)
                        <div class="table-responsive">
                            <table class="table-crud w-100">
                                <thead><tr><th style="width:30%;">Descripción</th><th style="width:35%;">Archivo</th><th style="width:15%;">Tamaño</th><th style="width:10%;">Fecha</th><th style="width:10%;">Acciones</th></tr></thead>
                                <tbody>
                                    @foreach($flujo->documentos as $doc)
                                        <tr>
                                            <td><span class="text-white">{{ $doc->descripcion }}</span></td>
                                            <td><span class="text-white"><i class="fas fa-file-pdf text-danger mr-1"></i>{{ $doc->nombre_archivo }}</span></td>
                                            <td><span class="text-white">{{ $doc->tamanio_formateado }}</span></td>
                                            <td><span class="text-white">{{ $doc->created_at->format('d/m/Y') }}</span></td>
                                            <td><div class="action-buttons d-flex justify-content-end">
                                                <button class="btn-action btn-delete" onclick="confirmarEliminarDocumento('{{ $proceso->id }}', '{{ $flujo->id }}', '{{ $doc->id }}', '{{ addslashes($doc->nombre_archivo) }}')" title="Eliminar"><i class="fas fa-trash"></i></button>
                                            </div></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5 text-muted"><i class="fas fa-file-pdf" style="font-size: 2rem; opacity: 0.3;"></i><p class="mt-3">No hay documentos</p>
                            <button class="btn btn-primary-pro btn-sm mt-2" data-toggle="modal" data-target="#uploadFlujDocumentoModal"><i class="fas fa-upload mr-1"></i>Subir Documento</button>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- PANEL 3: PERSONAS ASOCIADAS (COLAPSABLE) -->
        <div class="card mb-3">
            <div class="card-header bg-light d-flex align-items-center justify-content-between" style="cursor: pointer;" data-toggle="collapse" data-target="#personasFlujosContent">
                <div class="d-flex align-items-center">
                    <i class="fas fa-chevron-down mr-2 panel-icon"></i>
                    <i class="fas fa-users text-info mr-2"></i>
                    <h5 class="mb-0">Personas Asociadas <span class="badge badge-info ml-2">{{ $flujo->personas->count() }}</span></h5>
                </div>
                <div class="panel-actions ml-auto">
                    <button class="btn btn-primary-pro btn-sm" data-toggle="modal" data-target="#agregarPersonaFlujModal" onclick="event.stopPropagation();"><i class="fas fa-plus mr-1"></i>Agregar</button>
                </div>
            </div>
            <div class="collapse" id="personasFlujosContent">
                <div class="card-body p-0">
                    @if($flujo->personas->count() > 0)
                        <div class="table-responsive">
                            <table class="table-crud w-100">
                                <thead><tr><th style="width:35%;">Nombre</th><th style="width:35%;">Apellido</th><th style="width:30%;">Acciones</th></tr></thead>
                                <tbody>
                                    @foreach($flujo->personas as $persona)
                                        <tr>
                                            <td><span class="text-white">{{ $persona->nombres }}</span></td>
                                            <td><span class="text-white">{{ $persona->apellido }}</span></td>
                                            <td><div class="action-buttons d-flex justify-content-end">
                                                <button class="btn-action btn-delete" onclick="confirmarEliminarPersona('{{ $proceso->id }}', '{{ $flujo->id }}', '{{ $persona->id }}')" title="Eliminar"><i class="fas fa-trash"></i></button>
                                            </div></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5 text-muted"><i class="fas fa-users" style="font-size: 2rem; opacity: 0.3;"></i><p class="mt-3">No hay personas asociadas</p>
                            <button class="btn btn-primary-pro btn-sm mt-2" data-toggle="modal" data-target="#agregarPersonaFlujModal"><i class="fas fa-plus mr-1"></i>Agregar Persona</button>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- PANEL 4: ROLES ASOCIADOS (COLAPSABLE) -->
        <div class="card">
            <div class="card-header bg-light d-flex align-items-center justify-content-between" style="cursor: pointer;" data-toggle="collapse" data-target="#rolesFlujosContent">
                <div class="d-flex align-items-center">
                    <i class="fas fa-chevron-down mr-2 panel-icon"></i>
                    <i class="fas fa-shield-alt text-warning mr-2"></i>
                    <h5 class="mb-0">Roles Asociados <span class="badge badge-warning ml-2">{{ $flujo->tiposActores->count() }}</span></h5>
                </div>
                <div class="panel-actions ml-auto">
                    <button class="btn btn-primary-pro btn-sm" data-toggle="modal" data-target="#agregarRolFlujModal" onclick="event.stopPropagation();"><i class="fas fa-plus mr-1"></i>Agregar</button>
                </div>
            </div>
            <div class="collapse" id="rolesFlujosContent">
                <div class="card-body p-0">
                    @if($flujo->tiposActores->count() > 0)
                        <div class="table-responsive">
                            <table class="table-crud w-100">
                                <thead><tr><th style="width:70%;">Descripción</th><th style="width:30%;">Acciones</th></tr></thead>
                                <tbody>
                                    @foreach($flujo->tiposActores as $rol)
                                        <tr>
                                            <td><span class="text-white">{{ $rol->descripcion }}</span></td>
                                            <td><div class="action-buttons d-flex justify-content-end">
                                                <button class="btn-action btn-delete" onclick="confirmarEliminarRol('{{ $proceso->id }}', '{{ $flujo->id }}', '{{ $rol->id }}')" title="Eliminar"><i class="fas fa-trash"></i></button>
                                            </div></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5 text-muted"><i class="fas fa-shield-alt" style="font-size: 2rem; opacity: 0.3;"></i><p class="mt-3">No hay roles asociados</p>
                            <button class="btn btn-primary-pro btn-sm mt-2" data-toggle="modal" data-target="#agregarRolFlujModal"><i class="fas fa-plus mr-1"></i>Agregar Rol</button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL: Subir Documento a Flujo -->
<div class="modal fade" id="uploadFlujDocumentoModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title"><i class="fas fa-upload text-danger mr-2"></i>Subir Documento</h5><button class="close" data-dismiss="modal">&times;</button></div>
            <form id="uploadFlujDocumentoForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group"><label>Descripción *</label><input type="text" class="form-control" name="descripcion" required maxlength="100"></div>
                    <div class="form-group"><label>Archivo PDF *</label><input type="file" class="form-control" name="archivo" accept=".pdf" required></div>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button><button type="submit" class="btn btn-primary-pro">Subir</button></div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL: Agregar Persona a Flujo -->
<div class="modal fade" id="agregarPersonaFlujModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title"><i class="fas fa-user-plus text-info mr-2"></i>Agregar Persona</h5><button class="close" data-dismiss="modal">&times;</button></div>
            <form id="agregarPersonaFlujForm">
                @csrf
                <div class="modal-body">
                    <div class="form-group"><label>Persona *</label><select class="form-control" name="persona_id" required>
                        <option value="">-- Seleccionar --</option>
                        @foreach($personas as $persona)
                            <option value="{{ $persona->id }}">{{ $persona->apellido }}, {{ $persona->nombres }}</option>
                        @endforeach
                    </select></div>
                    <div class="form-group"><label>Observaciones</label><textarea class="form-control" name="observaciones" rows="3" maxlength="500"></textarea></div>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button><button type="submit" class="btn btn-primary-pro">Agregar</button></div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL: Agregar Rol a Flujo -->
<div class="modal fade" id="agregarRolFlujModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title"><i class="fas fa-shield-alt text-warning mr-2"></i>Agregar Rol</h5><button class="close" data-dismiss="modal">&times;</button></div>
            <form id="agregarRolFlujForm">
                @csrf
                <div class="modal-body">
                    <div class="form-group"><label>Rol *</label><select class="form-control" name="tipo_actor_id" required>
                        <option value="">-- Seleccionar --</option>
                        @foreach($tiposActores as $tipo)
                            <option value="{{ $tipo->id }}">{{ $tipo->descripcion }}</option>
                        @endforeach
                    </select></div>
                    <div class="form-group"><label>Observaciones</label><textarea class="form-control" name="observaciones" rows="3" maxlength="500"></textarea></div>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button><button type="submit" class="btn btn-primary-pro">Agregar</button></div>
            </form>
        </div>
    </div>
</div>

<script>
// Animar iconos de colapso
document.querySelectorAll('[data-toggle="collapse"]').forEach(btn => {
    btn.addEventListener('click', function() {
        const icon = this.querySelector('.panel-icon');
        if(icon) {
            const target = document.querySelector(this.getAttribute('data-target'));
            if(target.classList.contains('show')) {
                icon.style.transform = 'rotate(-90deg)';
            } else {
                icon.style.transform = 'rotate(0deg)';
            }
        }
    });
});

// FORMULARIO: Subir Documento
document.getElementById('uploadFlujDocumentoForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const pId = '{{ $proceso->id }}';
    const fId = '{{ $flujo->id }}';
    const formData = new FormData(this);
    
    try {
        const resp = await fetch(`/internal/procesos/${pId}/flujos/${fId}/documentos`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: formData
        });
        
        const data = await resp.json();
        if(data.success) {
            location.reload();
        } else {
            alert(data.message || 'Error al subir documento');
        }
    } catch(err) {
        alert('Error: ' + err.message);
    }
});

// FORMULARIO: Agregar Persona
document.getElementById('agregarPersonaFlujForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const pId = '{{ $proceso->id }}';
    const fId = '{{ $flujo->id }}';
    
    try {
        const resp = await fetch(`/internal/procesos/${pId}/flujos/${fId}/personas`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                pessoa_id: this.pessoa_id.value,
                observaciones: this.observaciones.value
            })
        });
        
        const data = await resp.json();
        if(data.success) {
            location.reload();
        } else {
            alert(data.message || 'Error al agregar persona');
        }
    } catch(err) {
        alert('Error: ' + err.message);
    }
});

// FORMULARIO: Agregar Rol
document.getElementById('agregarRolFlujForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const pId = '{{ $proceso->id }}';
    const fId = '{{ $flujo->id }}';
    
    try {
        const resp = await fetch(`/internal/procesos/${pId}/flujos/${fId}/roles`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                tipo_actor_id: this.tipo_actor_id.value,
                observaciones: this.observaciones.value
            })
        });
        
        const data = await resp.json();
        if(data.success) {
            location.reload();
        } else {
            alert(data.message || 'Error al agregar rol');
        }
    } catch(err) {
        alert('Error: ' + err.message);
    }
});

// FUNCIÓN: Eliminar Documento
function confirmarEliminarDocumento(pId, fId, docId, fileName) {
    if(!confirm(`¿Eliminar documento "${fileName}"?`)) return;
    fetch(`/internal/procesos/${pId}/flujos/${fId}/documentos/${docId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
    .then(r => r.json())
    .then(d => {
        if(d.success) location.reload();
        else alert('Error al eliminar');
    })
    .catch(() => alert('Error al eliminar'));
}

// FUNCIÓN: Eliminar Persona
function confirmarEliminarPersona(pId, fId, personaId) {
    if(!confirm('¿Eliminar persona?')) return;
    fetch(`/internal/procesos/${pId}/flujos/${fId}/personas/${personaId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
    .then(r => r.json())
    .then(d => {
        if(d.success) location.reload();
        else alert('Error al eliminar');
    })
    .catch(() => alert('Error al eliminar'));
}

// FUNCIÓN: Eliminar Rol
function confirmarEliminarRol(pId, fId, rolId) {
    if(!confirm('¿Eliminar rol?')) return;
    fetch(`/internal/procesos/${pId}/flujos/${fId}/roles/${rolId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
    .then(r => r.json())
    .then(d => {
        if(d.success) location.reload();
        else alert('Error al eliminar');
    })
    .catch(() => alert('Error al eliminar'));
}
</script>
@endsection
