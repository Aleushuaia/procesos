@extends('layouts.app')

@section('title', 'Ver Proceso')
@section('page_title', 'Detalles del Proceso')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('internal.procesos.index') }}">Procesos</a></li>
    <li class="breadcrumb-item active">{{ $proceso->codigo ?? 'Ver' }}</li>
@endsection
@section('content')
<div class="row">
    <div class="col-12">
        <!-- PANEL 1: DETALLES -->
        <div class="card mb-3">
            <div class="card-header bg-light d-flex align-items-center" style="cursor: pointer;" data-toggle="collapse" data-target="#detallesContent">
                <i class="fas fa-chevron-down mr-2 panel-icon" style="transition: transform 0.3s;"></i>
                <i class="fas fa-info-circle text-primary mr-2"></i>
                <h5 class="mb-0">Detalles del Proceso</h5>
            </div>
            <div class="collapse show" id="detallesContent">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-2 mb-3 mb-md-0">
                            <label class="text-muted small d-block mb-1">Código</label>
                            <p class="h6 mb-0"><strong class="text-primary">{{ $proceso->codigo }}</strong></p>
                        </div>
                        <div class="col-md-4 mb-3 mb-md-0">
                            <label class="text-muted small d-block mb-1">Descripción</label>
                            <p class="h6 mb-0">{{ $proceso->descripcion }}</p>
                        </div>
                        <div class="col-md-2 mb-3 mb-md-0">
                            <label class="text-muted small d-block mb-1">Estado</label>
                            <span class="badge p-2 w-100 text-truncate" style="background-color: {{ $proceso->estadoProceso?->color ?? '#6c757d' }}; color: white;">
                                {{ $proceso->estadoProceso->descripcion ?? '-' }}
                            </span>
                        </div>
                        <div class="col-md-2 mb-3 mb-md-0">
                            <label class="text-muted small d-block mb-1">Tipo</label>
                            <span class="badge p-2 w-100 text-truncate" style="background-color: {{ $proceso->tipoProceso?->color ?? '#0c5aa0' }}; color: white;">
                                <i class="fas {{ $proceso->tipoProceso?->icono ?? 'fa-folder' }} mr-1"></i>{{ $proceso->tipoProceso->descripcion ?? '-' }}
                            </span>
                        </div>
                        <div class="col-md-2">
                            <label class="text-muted small d-block mb-1">Criticidad</label>
                            <span class="badge p-2 w-100 text-truncate" style="background-color: {{ $proceso->criticidadProceso?->color ?? '#6c757d' }}; color: white;">
                                <i class="fas fa-exclamation-triangle mr-1"></i>{{ $proceso->criticidadProceso->descripcion ?? '-' }}
                            </span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 mb-3 mb-md-0">
                            <label class="text-muted small d-block mb-1">Unidad Responsable</label>
                            <p class="mb-0">{{ $proceso->unidadResponsable->descripcion ?? '-' }}</p>
                        </div>
                        <div class="col-md-4 mb-3 mb-md-0">
                            <label class="text-muted small d-block mb-1">Responsable</label>
                            <p class="mb-0">{{ $proceso->responsable ? $proceso->responsable->nombres . ' ' . $proceso->responsable->apellido : '-' }}</p>
                        </div>
                        <div class="col-md-4">
                            <label class="text-muted small d-block mb-1">En revisión</label>
                            {!! $proceso->requiere_revision ? '<span class="badge badge-danger">Sí</span>' : '<span class="badge badge-success">No</span>' !!}
                        </div>
                    </div>

                    @if($proceso->objetivo)
                        <div class="mb-3">
                            <label class="text-muted small d-block mb-1">Objetivo</label>
                            <p class="mb-0">{{ $proceso->objetivo }}</p>
                        </div>
                    @endif

                    @if($proceso->observaciones)
                        <div class="mb-3">
                            <label class="text-muted small d-block mb-1">Observaciones</label>
                            <p class="mb-0 text-muted">{{ $proceso->observaciones }}</p>
                        </div>
                    @endif

                    <hr>
                    <div class="d-flex gap-2">
                        <a href="{{ route('internal.procesos.edit', $proceso->id) }}" class="btn btn-primary-pro btn-sm"><i class="fas fa-pencil-alt mr-1"></i>Editar</a>
                        <a href="{{ route('internal.procesos.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left mr-1"></i>Volver</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- PANEL 2: DOCUMENTOS -->
        <div class="card mb-3">
            <div class="card-header bg-light d-flex align-items-center justify-content-between" style="cursor: pointer;" data-toggle="collapse" data-target="#documentosContent">
                <div class="d-flex align-items-center">
                    <i class="fas fa-chevron-down mr-2 panel-icon" style="transition: transform 0.3s;"></i>
                    <i class="fas fa-file-pdf text-danger mr-2"></i>
                    <h5 class="mb-0">Documentos Asociados <span class="badge badge-danger ml-2">{{ $proceso->documentos->count() }}</span></h5>
                </div>
                <button class="btn btn-primary-pro btn-sm" data-toggle="modal" data-target="#uploadDocumentoModal" onclick="event.stopPropagation();"><i class="fas fa-upload mr-1"></i>Subir</button>
            </div>
            <div class="collapse show" id="documentosContent">
                <div class="card-body p-0">
                    @if($proceso->documentos->count() > 0)
                        <div class="table-responsive">
                            <table class="table-crud w-100">
                                <thead><tr><th>Descripción</th><th>Tipo</th><th>Archivo</th><th class="text-center">Tamaño</th><th>Fecha</th><th style="width:100px;">Acciones</th></tr></thead>
                                <tbody>
                                    @foreach($proceso->documentos as $doc)
                                        <tr>
                                            <td><strong class="text-primary">{{ $doc->descripcion }}</strong></td>
                                            <td><span class="badge badge-secondary">{{ $doc->tipoDocumento->descripcion ?? '-' }}</span></td>
                                            <td><a href="{{ route('internal.procesos.documentos.show', [$proceso->id, $doc->id]) }}" target="_blank"><i class="fas fa-file-pdf text-danger mr-1"></i>{{ $doc->nombre_archivo }}</a></td>
                                            <td class="text-center"><small class="text-muted">{{ $doc->tamanio_formateado }}</small></td>
                                            <td><small class="text-muted">{{ $doc->created_at->format('d/m/Y') }}</small></td>
                                            <td><div class="action-buttons">
                                                <a href="{{ route('internal.procesos.documentos.show', [$proceso->id, $doc->id]) }}" target="_blank" class="btn-action btn-show" title="Abrir"><i class="fas fa-eye"></i></a>
                                                <button class="btn-action btn-delete" onclick="eliminarDocumento('{{ $proceso->id }}', '{{ $doc->id }}', '{{ addslashes($doc->nombre_archivo) }}')"><i class="fas fa-trash"></i></button>
                                            </div></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5 text-muted"><i class="fas fa-file-pdf" style="font-size: 2rem; opacity: 0.3;"></i><p class="mt-3">No hay documentos</p>
                            <button class="btn btn-primary-pro btn-sm mt-2" data-toggle="modal" data-target="#uploadDocumentoModal"><i class="fas fa-upload mr-1"></i>Subir Documento</button>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- PANEL 3: FLUJOS -->
        <div class="card">
            <div class="card-header bg-light d-flex align-items-center justify-content-between" style="cursor: pointer;" data-toggle="collapse" data-target="#flujosContent">
                <div class="d-flex align-items-center">
                    <i class="fas fa-chevron-down mr-2 panel-icon" style="transition: transform 0.3s;"></i>
                    <i class="fas fa-project-diagram text-primary mr-2"></i>
                    <h5 class="mb-0">Flujos Asociados <span class="badge badge-primary ml-2">{{ $proceso->flujos->count() }}</span></h5>
                </div>
                <button class="btn btn-primary-pro btn-sm" data-toggle="modal" data-target="#createFlujModal" onclick="event.stopPropagation(); setCreateModalProcessId('{{ $proceso->id }}');"><i class="fas fa-plus mr-1"></i>Nuevo</button>
            </div>
            <div class="collapse show" id="flujosContent">
                <div class="card-body p-0">
                    @if($proceso->flujos->count() > 0)
                        <div class="table-responsive">
                            <table class="table-crud w-100">
                                <thead><tr><th>Descripción</th><th>Tipo</th><th class="text-center">Personas</th><th class="text-center">Roles</th><th style="width:100px;">Acciones</th></tr></thead>
                                <tbody>
                                    @foreach($proceso->flujos as $flujo)
                                        <tr>
                                            <td><strong class="text-primary">{{ $flujo->descripcion }}</strong>@if($flujo->observaciones)<small class="text-muted d-block">{{ Str::limit($flujo->observaciones, 60) }}</small>@endif</td>
                                            <td><span class="badge badge-info">{{ $flujo->tipoFlujo->descripcion ?? '-' }}</span></td>
                                            <td class="text-center"><span class="badge badge-secondary">{{ $flujo->personas->count() }}</span></td>
                                            <td class="text-center"><span class="badge badge-warning">{{ $flujo->tiposActores->count() }}</span></td>
                                            <td><button class="btn-action btn-show" data-toggle="modal" data-target="#showFlujoModal" onclick="loadFlujoDetailsModal('{{ $proceso->id }}', '{{ $flujo->id }}')"><i class="fas fa-eye"></i></button></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5 text-muted"><i class="fas fa-inbox" style="font-size: 2rem;"></i><p class="mt-3">No hay flujos</p>
                            <button class="btn btn-primary-pro btn-sm mt-2" data-toggle="modal" data-target="#createFlujModal" onclick="setCreateModalProcessId('{{ $proceso->id }}');"><i class="fas fa-plus mr-1"></i>Crear Flujo</button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODALES -->
<div class="modal fade" id="uploadDocumentoModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title"><i class="fas fa-upload text-danger mr-2"></i>Subir Documento</h5><button class="close" data-dismiss="modal">&times;</button></div>
            <form id="uploadDocumentoForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group"><label>Descripción *</label><input type="text" class="form-control" name="descripcion" required maxlength="100"></div>
                    <div class="form-group"><label>Tipo *</label><select class="form-control" name="tipo_proceso_documento_id" required>
                        <option value=""> Seleccionar </option>
                        @foreach($tiposDocumento as $tipo)
                            <option value="{{ $tipo->id }}">{{ $tipo->descripcion }}</option>
                        @endforeach
                    </select></div>
                    <div class="form-group"><label>Archivo PDF *</label><input type="file" class="form-control" name="archivo" accept=".pdf" required></div>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button><button type="submit" class="btn btn-primary-pro">Subir</button></div>
            </form>
        </div>
    </div>
</div>

@include('internal.flujos.create')
@include('internal.flujos.show')

<style>
.card-header { cursor: pointer; }
.panel-icon { display: inline-block; }
.collapse:not(.show) ~ .card-header .panel-icon { transform: rotate(-90deg); }
</style>

<script>
document.querySelectorAll('[data-toggle="collapse"]').forEach(el => {
    el.addEventListener('click', function() {
        const target = document.querySelector(this.getAttribute('data-target'));
        const icon = this.querySelector('.panel-icon');
        if(icon) {
            setTimeout(() => {
                icon.style.transform = target.classList.contains('show') ? 'rotate(0deg)' : 'rotate(-90deg)';
            }, 100);
        }
    });
});

function setCreateModalProcessId(id) { document.getElementById('createFlujModal').dataset.procesId = id; }
function loadFlujoDetailsModal(pId, fId) {
    const cont = document.getElementById('flujoContent');
    cont.innerHTML = '<div class="text-center py-5"><div class="spinner-border"></div></div>';
    fetch(`/internal/procesos/${pId}/flujos/${fId}`, {headers: {'Accept': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content}})
        .then(r => r.json()).then(d => { cont.innerHTML = `<p>${d.descripcion}</p>`; }).catch(() => { cont.innerHTML = '<div class="alert alert-danger">Error</div>'; });
}
function eliminarDocumento(pId, dId, name) {
    if(!confirm(`¿Eliminar "${name}"?`)) return;
    fetch(`/internal/procesos/${pId}/documentos/${dId}`, {method: 'DELETE', headers: {'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Accept': 'application/json'}})
        .then(r => r.json()).then(d => { if(d.success) location.reload(); }).catch(() => alert('Error'));
}

document.getElementById('uploadDocumentoForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    const fd = new FormData(this);
    fetch(`/internal/procesos/{{ $proceso->id }}/documentos`, {method: 'POST', body: fd, headers: {'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Accept': 'application/json'}})
        .then(r => r.json()).then(d => { if(d.success) { $('#uploadDocumentoModal').modal('hide'); setTimeout(() => location.reload(), 500); } }).catch(() => alert('Error'));
});
</script>
@endsection
