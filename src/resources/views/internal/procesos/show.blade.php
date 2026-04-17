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

        {{-- ===================== PANEL DETALLES ===================== --}}
        <div class="card mb-3" id="detallesPanel">
            <div class="card-header bg-light cursor-pointer" data-toggle="collapse" data-target="#detallesContent"
                 onclick="togglePanelIcon(this)">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chevron-down mr-2 panel-toggle-icon"></i>
                        <i class="fas fa-info-circle text-primary mr-2"></i>
                        Detalles del Proceso
                    </h5>
                </div>
                <small class="text-muted d-block mt-2">
                    <strong>{{ $proceso->codigo }}</strong> — {{ $proceso->descripcion }}
                    @if($proceso->tipoProceso)
                        <span class="badge badge-info ml-2">{{ $proceso->tipoProceso->descripcion }}</span>
                    @endif
                </small>
            </div>

            <div class="collapse show" id="detallesContent">
                <div class="card-body">

                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label class="text-muted small d-block">Código</label>
                            <p class="h6 text-primary mb-0"><strong>{{ $proceso->codigo }}</strong></p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small d-block">Descripción</label>
                            <p class="h6 mb-0">{{ $proceso->descripcion }}</p>
                        </div>
                        <div class="col-md-3">
                            <label class="text-muted small d-block">Estado</label>
                            @php
                                $estadoColor = match($proceso->estadoProceso->descripcion ?? '') {
                                    'Borrador'      => 'warning',
                                    'En análisis'   => 'info',
                                    'En revisión'   => 'secondary',
                                    'Aprobado'      => 'success',
                                    'Vigente'       => 'success',
                                    'Observado'     => 'danger',
                                    'Archivado'     => 'dark',
                                    default         => 'secondary'
                                };
                            @endphp
                            <span class="badge badge-{{ $estadoColor }}">{{ $proceso->estadoProceso->descripcion ?? '-' }}</span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="text-muted small d-block">Tipo de Proceso</label>
                            <span class="badge badge-info">{{ $proceso->tipoProceso->descripcion ?? '-' }}</span>
                        </div>
                        <div class="col-md-4">
                            <label class="text-muted small d-block">Criticidad</label>
                            @php
                                $criticidadColor = match($proceso->criticidadProceso->descripcion ?? '') {
                                    'Baja'  => 'success',
                                    'Media' => 'warning',
                                    'Alta'  => 'danger',
                                    default => 'secondary'
                                };
                            @endphp
                            <span class="badge badge-{{ $criticidadColor }}">
                                <i class="fas fa-exclamation-triangle mr-1"></i>
                                {{ $proceso->criticidadProceso->descripcion ?? '-' }}
                            </span>
                        </div>
                        <div class="col-md-4">
                            <label class="text-muted small d-block">Requiere Revisión</label>
                            @if($proceso->requiere_revision)
                                <span class="badge badge-danger"><i class="fas fa-check-circle mr-1"></i>Sí</span>
                            @else
                                <span class="badge badge-success"><i class="fas fa-times-circle mr-1"></i>No</span>
                            @endif
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="text-muted small d-block">Unidad Responsable</label>
                            <p class="h6 mb-0">{{ $proceso->unidadResponsable->descripcion ?? '-' }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small d-block">Responsable del Proceso</label>
                            <p class="h6 mb-0">
                                @if($proceso->responsable)
                                    {{ $proceso->responsable->apellido }}, {{ $proceso->responsable->nombres }}
                                @else
                                    <span class="text-muted">No asignado</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    @if($proceso->objetivo)
                        <div class="mb-3">
                            <label class="text-muted small d-block">Objetivo</label>
                            <p class="mb-0">{{ $proceso->objetivo }}</p>
                        </div>
                    @endif

                    @if($proceso->observaciones)
                        <div class="mb-3">
                            <label class="text-muted small d-block">Observaciones</label>
                            <p class="text-muted mb-0">{{ $proceso->observaciones }}</p>
                        </div>
                    @endif

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="text-muted small d-block">Creado</label>
                            <p class="text-muted small mb-0">{{ $proceso->created_at ? $proceso->created_at->format('d/m/Y H:i') : 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small d-block">Proceso Padre</label>
                            @if($proceso->procesoPadre)
                                <a href="{{ route('internal.procesos.show', $proceso->procesoPadre->id) }}" class="text-primary">
                                    {{ $proceso->procesoPadre->codigo }} — {{ $proceso->procesoPadre->descripcion }}
                                </a>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </div>
                    </div>

                    <hr class="my-3">

                    <div class="d-flex" style="gap: 0.5rem;">
                        <a href="{{ route('internal.procesos.edit', $proceso->id) }}" class="btn btn-primary-pro btn-sm">
                            <i class="fas fa-pencil-alt mr-2"></i> Editar Proceso
                        </a>
                        <a href="{{ route('internal.procesos.index') }}" class="btn btn-secondary-pro btn-sm">
                            <i class="fas fa-arrow-left mr-2"></i> Volver
                        </a>
                    </div>

                </div>
            </div>
        </div>

        {{-- ===================== PANEL DOCUMENTOS ===================== --}}
        <div class="card mb-3" id="documentosPanel">
            <div class="card-header bg-light cursor-pointer" data-toggle="collapse" data-target="#documentosContent"
                 onclick="togglePanelIcon(this)">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chevron-down mr-2 panel-toggle-icon"></i>
                        <i class="fas fa-file-pdf text-danger mr-2"></i>
                        Documentos Asociados
                        <span class="badge badge-danger ml-2">{{ $proceso->documentos->count() }}</span>
                    </h5>
                    <button type="button" class="btn btn-primary-pro btn-sm"
                            data-toggle="modal" data-target="#uploadDocumentoModal">
                        <i class="fas fa-upload mr-1"></i> Subir Documento
                    </button>
                </div>
            </div>

            <div class="collapse show" id="documentosContent">
                <div class="card-body p-0">
                    @if($proceso->documentos->count() > 0)
                        <div class="table-responsive">
                            <table class="table-crud w-100">
                                <thead>
                                    <tr>
                                        <th>Descripción</th>
                                        <th>Tipo</th>
                                        <th>Archivo</th>
                                        <th class="text-center">Tamaño</th>
                                        <th>Fecha</th>
                                        <th style="width: 100px;">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($proceso->documentos as $doc)
                                        <tr>
                                            <td><strong class="text-primary">{{ $doc->descripcion }}</strong></td>
                                            <td>
                                                <span class="badge badge-secondary">
                                                    {{ $doc->tipoDocumento->descripcion ?? '-' }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('internal.procesos.documentos.show', [$proceso->id, $doc->id]) }}"
                                                   target="_blank" style="text-decoration: none;">
                                                    <i class="fas fa-file-pdf text-danger mr-1"></i>
                                                    {{ $doc->nombre_archivo }}
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                <small class="text-muted">{{ $doc->tamanio_formateado }}</small>
                                            </td>
                                            <td>
                                                <small class="text-muted">{{ $doc->created_at->format('d/m/Y') }}</small>
                                            </td>
                                            <td>
                                                <div class="action-buttons">
                                                    <a href="{{ route('internal.procesos.documentos.show', [$proceso->id, $doc->id]) }}"
                                                       target="_blank" class="btn-action btn-show" title="Abrir PDF">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <button type="button" class="btn-action btn-delete" title="Eliminar"
                                                            onclick="eliminarDocumento('{{ $proceso->id }}', '{{ $doc->id }}', '{{ addslashes($doc->nombre_archivo) }}')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5 text-muted">
                            <i class="fas fa-file-pdf" style="font-size: 2rem; color: #dc3545; opacity: 0.4;"></i>
                            <p class="mt-3 mb-0">No hay documentos adjuntos aún</p>
                            <button type="button" class="btn btn-primary-pro btn-sm mt-3"
                                    data-toggle="modal" data-target="#uploadDocumentoModal">
                                <i class="fas fa-upload mr-1"></i> Subir Primer Documento
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- ===================== PANEL FLUJOS ===================== --}}
        <div class="card" id="flujosPanel">
            <div class="card-header bg-light cursor-pointer" data-toggle="collapse" data-target="#flujosContent"
                 onclick="togglePanelIcon(this)">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chevron-down mr-2 panel-toggle-icon"></i>
                        <i class="fas fa-project-diagram text-primary mr-2"></i>
                        Flujos Asociados
                        <span class="badge badge-primary ml-2">{{ $proceso->flujos->count() }}</span>
                    </h5>
                    <button type="button" class="btn btn-primary-pro btn-sm"
                            data-toggle="modal" data-target="#createFlujModal"
                            onclick="setCreateModalProcessId('{{ $proceso->id }}')">
                        <i class="fas fa-plus mr-1"></i> Nuevo Flujo
                    </button>
                </div>
            </div>

            <div class="collapse show" id="flujosContent">
                <div class="card-body p-0">
                    @if($proceso->flujos->count() > 0)
                        <div class="table-responsive">
                            <table class="table-crud w-100">
                                <thead>
                                    <tr>
                                        <th>Descripción</th>
                                        <th>Tipo</th>
                                        <th class="text-center">Personas</th>
                                        <th class="text-center">Roles</th>
                                        <th style="width: 100px;">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($proceso->flujos as $flujo)
                                        <tr>
                                            <td>
                                                <strong class="text-primary">{{ $flujo->descripcion }}</strong>
                                                @if($flujo->observaciones)
                                                    <small class="text-muted d-block">{{ Str::limit($flujo->observaciones, 60) }}</small>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge badge-info">{{ $flujo->tipoFlujo->descripcion ?? '-' }}</span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge badge-secondary">{{ $flujo->personas->count() }}</span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge badge-warning">{{ $flujo->tiposActores->count() }}</span>
                                            </td>
                                            <td>
                                                <div class="action-buttons">
                                                    <button type="button" class="btn-action btn-show" title="Ver detalles"
                                                            data-toggle="modal" data-target="#showFlujoModal"
                                                            onclick="loadFlujoDetailsModal('{{ $proceso->id }}', '{{ $flujo->id }}')">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5 text-muted">
                            <i class="fas fa-inbox" style="font-size: 2rem;"></i>
                            <p class="mt-3 mb-0">No hay flujos asociados aún</p>
                            <button type="button" class="btn btn-primary-pro btn-sm mt-3"
                                    data-toggle="modal" data-target="#createFlujModal"
                                    onclick="setCreateModalProcessId('{{ $proceso->id }}')">
                                <i class="fas fa-plus mr-1"></i> Crear Primer Flujo
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>

{{-- ===================== MODALES ===================== --}}

{{-- Modal Subir Documento --}}
<div class="modal fade" id="uploadDocumentoModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 580px;">
        <div class="modal-content">
            <div class="modal-header border-bottom">
                <h5 class="modal-title">
                    <i class="fas fa-upload text-danger mr-2"></i>
                    Subir Documento PDF
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="uploadDocumentoForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">

                    <div class="form-group">
                        <label for="doc_descripcion">Descripción <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="doc_descripcion" name="descripcion"
                               placeholder="Descripción del documento" required maxlength="100">
                        <small class="form-text text-muted">Máximo 100 caracteres</small>
                    </div>

                    <div class="form-group">
                        <label for="doc_tipo">Tipo de Documento <span class="text-danger">*</span></label>
                        <select class="form-control" id="doc_tipo" name="tipo_proceso_documento_id" required>
                            <option value="">— Seleccionar tipo —</option>
                            @foreach($tiposDocumento as $tipo)
                                <option value="{{ $tipo->id }}">{{ $tipo->descripcion }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="doc_archivo">Archivo PDF <span class="text-danger">*</span></label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="doc_archivo" name="archivo"
                                   accept=".pdf" required>
                            <label class="custom-file-label" for="doc_archivo">Seleccionar archivo PDF...</label>
                        </div>
                        <small class="form-text text-muted">Solo archivos PDF, máximo 20 MB</small>
                    </div>

                    <div id="docUploadProgress" class="d-none">
                        <div class="progress mt-2">
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary"
                                 role="progressbar" style="width: 0%"></div>
                        </div>
                        <small class="text-muted mt-1 d-block text-center">Subiendo documento...</small>
                    </div>

                    <div id="docUploadError" class="alert alert-danger d-none mt-2"></div>

                </div>

                <div class="modal-footer border-top">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-2"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary-pro" id="docUploadBtn">
                        <i class="fas fa-upload mr-2"></i> Subir Documento
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modales Flujos --}}
@include('internal.flujos.create')
@include('internal.flujos.show')

<style>
.cursor-pointer { cursor: pointer; user-select: none; }

.card-header {
    cursor: pointer;
    transition: none !important;
}
.card-header:hover,
.card-header:focus,
.card-header:active {
    background-color: inherit !important;
    color: inherit !important;
}

.panel-toggle-icon {
    transition: transform 0.3s ease;
    display: inline-block;
}
</style>

<script>
const personaBaseUrl    = '{{ url("/internal/personas") }}/';
const tipoActorBaseUrl  = '{{ url("/internal/tipos-actores") }}/';

// ── Panel collapse icon ──────────────────────────────────
function togglePanelIcon(header) {
    const icon = header.querySelector('.panel-toggle-icon');
    if (!icon) return;
    icon.style.transform = (icon.style.transform === 'rotate(-90deg)') ? 'rotate(0deg)' : 'rotate(-90deg)';
}

// ── Create flujo modal setup ─────────────────────────────
function setCreateModalProcessId(procesId) {
    document.getElementById('createFlujModal').dataset.procesId = procesId;
    document.getElementById('createFlujoForm').reset();
    document.getElementById('personasAgregadasPanel').style.display  = 'none';
    document.getElementById('rolesAgregadosPanel').style.display     = 'none';
    document.getElementById('personasAgregadasList').innerHTML = '';
    document.getElementById('rolesAgregadosList').innerHTML    = '';
    window.personasSeleccionadas = {};
    window.rolesSeleccionados    = {};
}

// ── Show flujo details modal ─────────────────────────────
function loadFlujoDetailsModal(procesId, flujoId) {
    document.getElementById('flujoContent').innerHTML = `
        <div class="text-center py-5">
            <div class="spinner-border text-primary" role="status"></div>
            <p class="mt-3 text-muted">Cargando...</p>
        </div>`;

    fetch(`/internal/procesos/${procesId}/flujos/${flujoId}`, {
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(r => { if (!r.ok) throw new Error('Error'); return r.json(); })
    .then(data => displayFlujoDetailsContent(data, procesId, flujoId))
    .catch(() => {
        document.getElementById('flujoContent').innerHTML =
            '<div class="alert alert-danger">Error al cargar el flujo.</div>';
    });
}

function displayFlujoDetailsContent(flujo, procesId, flujoId) {
    let personasHtml = '';
    if (flujo.personas && flujo.personas.length > 0) {
        personasHtml = flujo.personas.map(p => {
            const [id, fullName] = p.split('|');
            return `<a href="${personaBaseUrl}${id}" target="_blank"
                class="badge badge-light border border-primary p-2" style="text-decoration:none;color:inherit;">
                <i class="fas fa-user mr-1"></i>${escapeHtml(fullName)}</a>`;
        }).join(' ');
    }

    let rolesHtml = '';
    if (flujo.tipos_actores && flujo.tipos_actores.length > 0) {
        rolesHtml = flujo.tipos_actores.map(r => {
            const [id, desc] = r.split('|');
            return `<a href="${tipoActorBaseUrl}${id}" target="_blank"
                class="badge badge-warning p-2" style="text-decoration:none;color:inherit;">
                ${escapeHtml(desc)}</a>`;
        }).join(' ');
    }

    document.getElementById('flujoContent').innerHTML = `
        <div>
            <p class="text-muted small mb-1">Descripción</p>
            <p class="h5 mb-3">${escapeHtml(flujo.descripcion)}</p>

            <div class="row mb-3">
                <div class="col-md-6">
                    <p class="text-muted small mb-1">Tipo de Flujo</p>
                    <span class="badge badge-info p-2">${escapeHtml(flujo.tipoFlujo)}</span>
                </div>
            </div>

            ${flujo.observaciones ? `
                <p class="text-muted small mb-1">Observaciones</p>
                <p class="mb-3">${escapeHtml(flujo.observaciones)}</p>` : ''}

            ${(flujo.fecha_inicio_analisis || flujo.fecha_firma_version) ? `<hr>
                <div class="row mb-3">
                    ${flujo.fecha_inicio_analisis ? `<div class="col-md-6">
                        <p class="text-muted small mb-1">Fecha Inicio Análisis</p>
                        <p>${escapeHtml(flujo.fecha_inicio_analisis)}</p></div>` : ''}
                    ${flujo.fecha_firma_version ? `<div class="col-md-6">
                        <p class="text-muted small mb-1">Fecha Firma Versión</p>
                        <p>${escapeHtml(flujo.fecha_firma_version)}</p></div>` : ''}
                </div>` : ''}

            ${personasHtml ? `<hr>
                <p class="text-muted small mb-2"><i class="fas fa-users mr-1"></i>Personas Involucradas (${flujo.personas.length})</p>
                <div class="d-flex flex-wrap" style="gap:0.4rem;">${personasHtml}</div>` : ''}

            ${rolesHtml ? `<div class="mt-3">
                <p class="text-muted small mb-2"><i class="fas fa-shield-alt mr-1"></i>Roles/Tipos de Actores (${flujo.tipos_actores.length})</p>
                <div class="d-flex flex-wrap" style="gap:0.4rem;">${rolesHtml}</div></div>` : ''}
        </div>`;

    document.getElementById('editFlujBtn').onclick  = () => editFlujoModal(procesId, flujoId);
    document.getElementById('deleteFlujBtn').onclick = () => deleteFlujo(procesId, flujoId);
}

function escapeHtml(text) {
    const d = document.createElement('div');
    d.textContent = String(text);
    return d.innerHTML;
}

function editFlujoModal(procesId, flujoId) {
    alert('Función de edición en desarrollo');
}

function deleteFlujo(procesId, flujoId) {
    if (!confirm('¿Eliminar este flujo? Esta acción no se puede deshacer.')) return;

    fetch(`/internal/procesos/${procesId}/flujos/${flujoId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            $('#showFlujoModal').modal('hide');
            showToast('success', data.message || 'Flujo eliminado');
            setTimeout(() => location.reload(), 1200);
        } else {
            alert(data.message || 'Error al eliminar');
        }
    })
    .catch(() => alert('Error al eliminar el flujo'));
}

// ── Documento upload ─────────────────────────────────────
document.addEventListener('DOMContentLoaded', function () {
    // Custom file label
    document.getElementById('doc_archivo').addEventListener('change', function () {
        const label = this.closest('.custom-file').querySelector('.custom-file-label');
        label.textContent = this.files[0] ? this.files[0].name : 'Seleccionar archivo PDF...';
    });

    document.getElementById('uploadDocumentoForm').addEventListener('submit', function (e) {
        e.preventDefault();

        const form    = this;
        const btn     = document.getElementById('docUploadBtn');
        const errDiv  = document.getElementById('docUploadError');
        const progBar = document.getElementById('docUploadProgress');

        errDiv.classList.add('d-none');
        errDiv.textContent = '';

        const formData = new FormData(form);
        const procesId = '{{ $proceso->id }}';

        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm mr-2"></span>Subiendo...';
        progBar.classList.remove('d-none');

        const xhr = new XMLHttpRequest();

        xhr.upload.addEventListener('progress', function (ev) {
            if (ev.lengthComputable) {
                const pct = Math.round((ev.loaded / ev.total) * 100);
                progBar.querySelector('.progress-bar').style.width = pct + '%';
            }
        });

        xhr.addEventListener('load', function () {
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-upload mr-2"></i>Subir Documento';
            progBar.classList.add('d-none');

            let data;
            try { data = JSON.parse(xhr.responseText); } catch (ex) {
                errDiv.textContent = 'Error inesperado del servidor';
                errDiv.classList.remove('d-none');
                return;
            }

            if (data.success) {
                $('#uploadDocumentoModal').modal('hide');
                form.reset();
                document.querySelector('#uploadDocumentoModal .custom-file-label').textContent = 'Seleccionar archivo PDF...';
                showToast('success', data.message || 'Documento subido correctamente');
                setTimeout(() => location.reload(), 1200);
            } else {
                const msgs = data.errors
                    ? Object.values(data.errors).flat().join('<br>')
                    : (data.message || 'Error al subir el documento');
                errDiv.innerHTML = msgs;
                errDiv.classList.remove('d-none');
            }
        });

        xhr.addEventListener('error', function () {
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-upload mr-2"></i>Subir Documento';
            progBar.classList.add('d-none');
            errDiv.textContent = 'Error de red al subir el archivo';
            errDiv.classList.remove('d-none');
        });

        xhr.open('POST', `/internal/procesos/${procesId}/documentos`);
        xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
        xhr.setRequestHeader('Accept', 'application/json');
        xhr.send(formData);
    });
});

function eliminarDocumento(procesId, docId, nombre) {
    if (!confirm(`¿Eliminar el documento "${nombre}"? Esta acción no se puede deshacer.`)) return;

    fetch(`/internal/procesos/${procesId}/documentos/${docId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            showToast('success', data.message || 'Documento eliminado');
            setTimeout(() => location.reload(), 1200);
        } else {
            alert(data.message || 'Error al eliminar');
        }
    })
    .catch(() => alert('Error al eliminar el documento'));
}

function showSuccessMessage(msg) { showToast('success', msg); }

function showToast(type, msg) {
    if (typeof toastr !== 'undefined') {
        toastr[type](msg);
    } else {
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type === 'success' ? 'success' : 'danger'} fixed-top m-3`;
        alertDiv.style.cssText = 'z-index:9999;max-width:400px;right:1rem;left:auto;top:1rem;';
        alertDiv.textContent = msg;
        document.body.appendChild(alertDiv);
        setTimeout(() => alertDiv.remove(), 3000);
    }
}
</script>
@endsection
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
        <!-- Panel de Detalles Colapsable -->
        <div class="card mb-3" id="detallesPanel">
            <div class="card-header bg-light cursor-pointer" data-toggle="collapse" data-target="#detallesContent" 
                 onclick="togglePanelIcon(this)">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chevron-down mr-2 panel-toggle-icon"></i>
                        <i class="fas fa-info-circle text-primary mr-2"></i>
                        Detalles del Proceso
                    </h5>
                </div>
                <small class="text-muted d-block mt-2">
                    <strong>{{ $proceso->codigo }}</strong> - {{ $proceso->descripcion }}
                    @if($proceso->tipoProceso)
                        <span class="badge badge-info ml-2">{{ $proceso->tipoProceso->descripcion }}</span>
                    @endif
                </small>
            </div>

            <div class="collapse show" id="detallesContent">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <div class="form-group mb-2">
                                <label class="text-muted small">Código</label>
                                <p class="h6 text-primary mb-0"><strong>{{ $proceso->codigo }}</strong></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-2">
                                <label class="text-muted small">Descripción</label>
                                <p class="h6 mb-0">{{ $proceso->descripcion }}</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group mb-2">
                                <label class="text-muted small">Estado</label>
                                <p class="mb-0">
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
                                    <span class="badge badge-{{ $estadoColor }}">
                                        {{ $proceso->estadoProceso->descripcion ?? '-' }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <div class="form-group mb-2">
                                <label class="text-muted small">Tipo de Proceso</label>
                                <p class="mb-0">
                                    <span class="badge badge-info">
                                        {{ $proceso->tipoProceso->descripcion ?? '-' }}
                                    </span>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-2">
                                <label class="text-muted small">Criticidad</label>
                                <p class="mb-0">
                                    @php
                                        $criticidadColor = match($proceso->criticidadProceso->descripcion ?? '') {
                                            'Baja' => 'success',
                                            'Media' => 'warning',
                                            'Alta' => 'danger',
                                            default => 'secondary'
                                        };
                                    @endphp
                                    <span class="badge badge-{{ $criticidadColor }}">
                                        <i class="fas fa-exclamation-triangle mr-1"></i>
                                        {{ $proceso->criticidadProceso->descripcion ?? '-' }}
                                    </span>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-2">
                                <label class="text-muted small">Requiere Revisión</label>
                                <p class="mb-0">
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
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group mb-2">
                                <label class="text-muted small">Unidad Responsable</label>
                                <p class="h6 mb-0">{{ $proceso->unidadResponsable->descripcion ?? '-' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-2">
                                <label class="text-muted small">Responsable del Proceso</label>
                                <p class="h6 mb-0">
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

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group mb-0">
                                <label class="text-muted small">Creado</label>
                                <p class="text-muted small">{{ $proceso->created_at ? $proceso->created_at->format('d/m/Y H:i A') : 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-0">
                                <label class="text-muted small">Proceso Padre</label>
                                <p>
                                    @if($proceso->procesoPadre)
                                        <a href="{{ route('internal.procesos.show', $proceso->procesoPadre->id) }}" class="text-primary">
                                            {{ $proceso->procesoPadre->codigo }} - {{ $proceso->procesoPadre->descripcion }}
                                        </a>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <hr class="my-3">

                    <div class="d-flex gap-2">
                        <a href="{{ route('internal.procesos.edit', $proceso->id) }}" class="btn btn-primary-pro btn-sm">
                            <i class="fas fa-pencil-alt mr-2"></i> Editar Proceso
                        </a>
                        <a href="{{ route('internal.procesos.index') }}" class="btn btn-secondary-pro btn-sm">
                            <i class="fas fa-arrow-left mr-2"></i> Volver
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Panel de Documentos Colapsable -->
        <div class="card mb-3" id="documentosPanel">
            <div class="card-header bg-light cursor-pointer" data-toggle="collapse" data-target="#documentosContent"
                 onclick="togglePanelIcon(this)">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chevron-down mr-2 panel-toggle-icon"></i>
                        <i class="fas fa-file-pdf text-danger mr-2"></i>
                        Documentos Asociados
                        <span class="badge badge-danger ml-2">{{ count($proceso->documentos) }}</span>
                    </h5>
                    <button type="button" class="btn btn-primary-pro btn-sm" data-toggle="modal" data-target="#uploadDocumentoModal">
                        <i class="fas fa-upload mr-1"></i> Subir Documento
                    </button>
                </div>
            </div>

            <div class="collapse show" id="documentosContent">
                <div class="card-body p-0">
                    @if(count($proceso->documentos) > 0)
                        <div class="table-responsive">
                            <table class="table-crud w-100">
                                <thead>
                                    <tr>
                                        <th>Descripción</th>
                                        <th>Tipo</th>
                                        <th>Archivo</th>
                                        <th class="text-center">Tamaño</th>
                                        <th>Fecha</th>
                                        <th style="width: 100px;">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($proceso->documentos as $doc)
                                        <tr>
                                            <td>
                                                <strong class="text-primary">{{ $doc->descripcion }}</strong>
                                            </td>
                                            <td>
                                                <span class="badge badge-secondary">{{ $doc->tipoDocumento->descripcion ?? '-' }}</span>
                                            </td>
                                            <td>
                                                <a href="{{ route('internal.procesos.documentos.show', [$proceso->id, $doc->id]) }}"
                                                   target="_blank" class="text-primary" style="text-decoration: none;">
                                                    <i class="fas fa-file-pdf text-danger mr-1"></i>
                                                    {{ $doc->nombre_archivo }}
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                <small class="text-muted">{{ $doc->tamanio_formateado }}</small>
                                            </td>
                                            <td>
                                                <small class="text-muted">{{ $doc->created_at->format('d/m/Y') }}</small>
                                            </td>
                                            <td>
                                                <div class="action-buttons">
                                                    <a href="{{ route('internal.procesos.documentos.show', [$proceso->id, $doc->id]) }}"
                                                       target="_blank" class="btn-action btn-show" title="Abrir PDF">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <button type="button" class="btn-action btn-delete" title="Eliminar"
                                                            onclick="eliminarDocumento('{{ $proceso->id }}', '{{ $doc->id }}', '{{ $doc->nombre_archivo }}')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5 text-muted">
                            <i class="fas fa-file-pdf" style="font-size: 2rem; color: #dc3545; opacity: 0.4;"></i>
                            <p class="mt-3">No hay documentos adjuntos aún</p>
                            <button type="button" class="btn btn-primary-pro btn-sm mt-2" data-toggle="modal" data-target="#uploadDocumentoModal">
                                <i class="fas fa-upload mr-1"></i> Subir Primer Documento
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Panel de Flujos Colapsable -->
        <div class="card" id="flujosPanel">
            <div class="card-header bg-light cursor-pointer" data-toggle="collapse" data-target="#flujosContent" 
                 onclick="togglePanelIcon(this)">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chevron-down mr-2 panel-toggle-icon"></i>
                        <i class="fas fa-project-diagram text-primary mr-2"></i>
                        Flujos Asociados
                        <span class="badge badge-primary ml-2">{{ count($proceso->flujos) }}</span>
                    </h5>
                    <button type="button" class="btn btn-primary-pro btn-sm" data-toggle="modal" data-target="#createFlujModal" 
                            onclick="setCreateModalProcessId({{ $proceso->id }})">
                        <i class="fas fa-plus mr-1"></i> Nuevo Flujo
                    </button>
                </div>
            </div>

            <div class="collapse show" id="flujosContent">
                <div class="card-body p-0">
                    @if(count($proceso->flujos) > 0)
                        <div class="table-responsive">
                            <table class="table-crud w-100">
                                <thead>
                                    <tr>
                                        <th>Descripción</th>
                                        <th>Tipo</th>
                                        <th class="text-center">Personas</th>
                                        <th class="text-center">Roles</th>
                                        <th style="width: 120px;">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($proceso->flujos as $flujo)
                                        <tr>
                                            <td>
                                                <strong class="text-primary">{{ $flujo->descripcion }}</strong>
                                                @if($flujo->observaciones)
                                                    <small class="text-muted d-block">{{ substr($flujo->observaciones, 0, 50) }}...</small>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge badge-info">{{ $flujo->tipoFlujo->descripcion ?? '-' }}</span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge badge-secondary">{{ count($flujo->personas) }}</span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge badge-warning">{{ count($flujo->tiposActores) }}</span>
                                            </td>
                                            <td>
                                                <div class="action-buttons">
                                                    <button type="button" class="btn-action btn-show" title="Ver detalles"
                                                            data-toggle="modal" data-target="#showFlujoModal"
                                                            onclick="loadFlujoDetailsModal({{ $proceso->id }}, '{{ $flujo->id }}')">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5 text-muted">
                            <i class="fas fa-inbox" style="font-size: 2rem;"></i>
                            <p class="mt-3">No hay flujos asociados aún</p>
                            <button type="button" class="btn btn-primary-pro btn-sm mt-3" data-toggle="modal" data-target="#createFlujModal" 
                                    onclick="setCreateModalProcessId({{ $proceso->id }})">
                                <i class="fas fa-plus mr-1"></i> Crear Primer Flujo
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Incluir los modales de flujos -->
@include('internal.flujos.create')
@include('internal.flujos.show')

<style>
.cursor-pointer {
    cursor: pointer;
    user-select: none;
}

.card-header {
    cursor: pointer;
    transition: none !important;
}

.card-header:focus,
.card-header:active,
.card-header:hover {
    background-color: inherit !important;
    color: inherit !important;
}

.panel-toggle-icon {
    transition: transform 0.3s ease;
    display: inline-block;
}

.collapse.show ~ .card-header .panel-toggle-icon {
    transform: rotate(0deg);
}

#detallesPanel .collapsed .panel-toggle-icon,
#flujosPanel .collapsed .panel-toggle-icon {
    transform: rotate(-90deg);
}

.form-card {
    background: #fff;
    border: 1px solid #dee2e6;
    border-radius: 4px;
    padding: 1.5rem;
}
</style>

<script>
function togglePanelIcon(headerElement) {
    const icon = headerElement.querySelector('.panel-toggle-icon');
    if (icon) {
        icon.style.transform = icon.style.transform === 'rotate(-90deg)' ? 'rotate(0deg)' : 'rotate(-90deg)';
    }
}

function setCreateModalProcessId(procesId) {
    document.getElementById('createFlujModal').dataset.procesId = procesId;
    // Resetear formulario al abrir
    document.getElementById('createFlujoForm').reset();
    document.getElementById('personasAgregadasPanel').style.display = 'none';
    document.getElementById('rolesAgregadosPanel').style.display = 'none';
    document.getElementById('personasAgregadasList').innerHTML = '';
    document.getElementById('rolesAgregadosList').innerHTML = '';
    window.personasSeleccionadas = {};
    window.rolesSeleccionados = {};
}

function loadFlujoDetailsModal(procesId, flujoId) {
    const modal = document.getElementById('showFlujoModal');
    modal.dataset.procesId = procesId;
    modal.dataset.flujoId = flujoId;
    
    // Mostrar loader
    document.getElementById('flujoContent').innerHTML = `
        <div class="text-center py-5">
            <div class="spinner-border text-primary" role="status">
                <span class="sr-only">Cargando...</span>
            </div>
            <p class="mt-3 text-muted">Cargando información del flujo...</p>
        </div>
    `;
    
    // Realizar petición AJAX para cargar detalles
    fetch(`/internal/procesos/${procesId}/flujos/${flujoId}`, {
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => {
        if (!response.ok) throw new Error('Error al cargar flujo');
        return response.json();
    })
    .then(data => {
        displayFlujoDetailsContent(data, procesId, flujoId);
    })
    .catch(error => {
        console.error('Error:', error);
        document.getElementById('flujoContent').innerHTML = `
            <div class="alert alert-danger" role="alert">
                <i class="fas fa-exclamation-circle mr-2"></i>
                Error al cargar los detalles del flujo. Por favor, intenta nuevamente.
            </div>
        `;
    });
}

const personaBaseUrl = '{{ url("/internal/personas") }}/';
const tipoActorBaseUrl = '{{ url("/internal/tipos-actores") }}/';

function displayFlujoDetailsContent(flujo, procesId, flujoId) {
    let personasHtml = '';
    if (flujo.personas && flujo.personas.length > 0) {
        personasHtml = flujo.personas.map(p => {
            const [id, fullName] = p.split('|');
            return `<a href="${personaBaseUrl}${id}" target="_blank" class="badge badge-light border border-primary p-2" style="text-decoration: none; color: inherit;">
                <i class="fas fa-user mr-1"></i>${escapeHtml(fullName)}
            </a>`;
        }).join('');
    }

    let rolesHtml = '';
    if (flujo.tipos_actores && flujo.tipos_actores.length > 0) {
        rolesHtml = flujo.tipos_actores.map(r => {
            const [id, descripcion] = r.split('|');
            return `<a href="${tipoActorBaseUrl}${id}" target="_blank" class="badge badge-warning p-2" style="text-decoration: none; color: inherit;">
                ${escapeHtml(descripcion)}
            </a>`;
        }).join('');
    }

    const html = `
        <div class="flujo-details">
            <div class="mb-4">
                <h6 class="text-muted small">Descripción</h6>
                <p class="h5">${escapeHtml(flujo.descripcion)}</p>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <h6 class="text-muted small">Tipo de Flujo</h6>
                    <span class="badge badge-info p-2">${escapeHtml(flujo.tipoFlujo)}</span>
                </div>
                <div class="col-md-6">
                    <h6 class="text-muted small">Estado</h6>
                    <span class="badge badge-secondary p-2">Activo</span>
                </div>
            </div>

            ${flujo.observaciones ? `
                <div class="mb-3">
                    <h6 class="text-muted small">Observaciones</h6>
                    <p>${escapeHtml(flujo.observaciones)}</p>
                </div>
            ` : ''}

            ${(flujo.fecha_inicio_analisis || flujo.fecha_firma_version) ? `
                <hr>
                <div class="row mb-3">
                    ${flujo.fecha_inicio_analisis ? `
                        <div class="col-md-6">
                            <h6 class="text-muted small">Fecha Inicio de Análisis</h6>
                            <p>${escapeHtml(flujo.fecha_inicio_analisis)}</p>
                        </div>
                    ` : ''}
                    ${flujo.fecha_firma_version ? `
                        <div class="col-md-6">
                            <h6 class="text-muted small">Fecha Firma de Versión</h6>
                            <p>${escapeHtml(flujo.fecha_firma_version)}</p>
                        </div>
                    ` : ''}
                </div>
            ` : ''}

            ${personasHtml ? `
                <hr>
                <div class="mb-3">
                    <h6 class="text-muted small mb-2">
                        <i class="fas fa-users mr-1"></i>
                        Personas Involucradas (${flujo.personas.length})
                    </h6>
                    <div class="d-flex flex-wrap gap-2">
                        ${personasHtml}
                    </div>
                </div>
            ` : ''}

            ${rolesHtml ? `
                <div class="mb-2">
                    <h6 class="text-muted small mb-2">
                        <i class="fas fa-shield-alt mr-1"></i>
                        Roles/Tipos de Actores (${flujo.tipos_actores.length})
                    </h6>
                    <div class="d-flex flex-wrap gap-2">
                        ${rolesHtml}
                    </div>
                </div>
            ` : ''}
        </div>
    `;

    document.getElementById('flujoContent').innerHTML = html;
    
    // Actualizar datos en los botones de acciones
    document.getElementById('editFlujBtn').onclick = function() {
        editFlujoModal(procesId, flujoId);
    };
    
    document.getElementById('deleteFlujBtn').onclick = function() {
        deleteFlujo(procesId, flujoId);
    };
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

function editFlujoModal(procesId, flujoId) {
    fetch(`/internal/procesos/${procesId}/flujos/${flujoId}/edit`, {
        headers: {
            'Accept': 'text/html',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.text())
    .then(html => {
        $('#editFlujoModal').modal('show');
        document.getElementById('editFlujoForm').dataset.flujoId = flujoId;
        document.getElementById('editFlujoForm').dataset.procesId = procesId;
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al cargar el formulario de edición');
    });
}

function deleteFlujo(procesId, flujoId) {
    if (!confirm('¿Estás seguro de que deseas eliminar este flujo? Esta acción no se puede deshacer.')) {
        return;
    }

    fetch(`/internal/procesos/${procesId}/flujos/${flujoId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            $('#showFlujoModal').modal('hide');
            showSuccessMessage(data.message || 'Flujo eliminado correctamente');
            
            setTimeout(() => {
                window.location.reload();
            }, 1500);
        } else {
            alert(data.message || 'Error al eliminar el flujo');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Ocurrió un error al eliminar el flujo');
    });
}

function showSuccessMessage(message) {
    if (typeof toastr !== 'undefined') {
        toastr.success(message);
    } else {
        alert(message);
    }
}
</script>
@endsection
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
        <!-- Panel de Detalles Colapsable -->
        <div class="card mb-3" id="detallesPanel">
            <div class="card-header bg-light cursor-pointer" data-toggle="collapse" data-target="#detallesContent" 
                 onclick="togglePanelIcon(this)" style="cursor: pointer;">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chevron-down mr-2 panel-toggle-icon"></i>
                        <i class="fas fa-info-circle text-primary mr-2"></i>
                        Detalles del Proceso
                    </h5>
                </div>
                <small class="text-muted d-block mt-2">
                    <strong>{{ $proceso->codigo }}</strong> - {{ $proceso->descripcion }}
                    @if($proceso->tipoProceso)
                        <span class="badge badge-info ml-2">{{ $proceso->tipoProceso->descripcion }}</span>
                    @endif
                </small>
            </div>

            <div class="collapse show" id="detallesContent">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <div class="form-group mb-2">
                                <label class="text-muted small">Código</label>
                                <p class="h6 text-primary mb-0"><strong>{{ $proceso->codigo }}</strong></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-2">
                                <label class="text-muted small">Descripción</label>
                                <p class="h6 mb-0">{{ $proceso->descripcion }}</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group mb-2">
                                <label class="text-muted small">Estado</label>
                                <p class="mb-0">
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
                                    <span class="badge badge-{{ $estadoColor }}">
                                        {{ $proceso->estadoProceso->descripcion ?? '-' }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <div class="form-group mb-2">
                                <label class="text-muted small">Tipo de Proceso</label>
                                <p class="mb-0">
                                    <span class="badge badge-info">
                                        {{ $proceso->tipoProceso->descripcion ?? '-' }}
                                    </span>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-2">
                                <label class="text-muted small">Criticidad</label>
                                <p class="mb-0">
                                    @php
                                        $criticidadColor = match($proceso->criticidadProceso->descripcion ?? '') {
                                            'Baja' => 'success',
                                            'Media' => 'warning',
                                            'Alta' => 'danger',
                                            default => 'secondary'
                                        };
                                    @endphp
                                    <span class="badge badge-{{ $criticidadColor }}">
                                        <i class="fas fa-exclamation-triangle mr-1"></i>
                                        {{ $proceso->criticidadProceso->descripcion ?? '-' }}
                                    </span>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-2">
                                <label class="text-muted small">Requiere Revisión</label>
                                <p class="mb-0">
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
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group mb-2">
                                <label class="text-muted small">Unidad Responsable</label>
                                <p class="h6 mb-0">{{ $proceso->unidadResponsable->descripcion ?? '-' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-2">
                                <label class="text-muted small">Responsable del Proceso</label>
                                <p class="h6 mb-0">
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

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group mb-0">
                                <label class="text-muted small">Creado</label>
                                <p class="text-muted small">{{ $proceso->created_at ? $proceso->created_at->format('d/m/Y H:i A') : 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-0">
                                <label class="text-muted small">Proceso Padre</label>
                                <p>
                                    @if($proceso->procesoPadre)
                                        <a href="{{ route('internal.procesos.show', $proceso->procesoPadre->id) }}" class="text-primary">
                                            {{ $proceso->procesoPadre->codigo }} - {{ $proceso->procesoPadre->descripcion }}
                                        </a>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <hr class="my-3">

                    <div class="d-flex gap-2">
                        <a href="{{ route('internal.procesos.edit', $proceso->id) }}" class="btn btn-primary-pro btn-sm">
                            <i class="fas fa-pencil-alt mr-2"></i> Editar Proceso
                        </a>
                        <a href="{{ route('internal.procesos.index') }}" class="btn btn-secondary-pro btn-sm">
                            <i class="fas fa-arrow-left mr-2"></i> Volver
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Panel de Flujos Colapsable -->
        <div class="card" id="flujosPanel" style="width: 90%; margin: 0 auto;">
            <div class="card-header bg-light cursor-pointer" data-toggle="collapse" data-target="#flujosContent" 
                 onclick="togglePanelIcon(this)" style="cursor: pointer;">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chevron-down mr-2 panel-toggle-icon"></i>
                        <i class="fas fa-project-diagram text-primary mr-2"></i>
                        Flujos Asociados
                        <span class="badge badge-primary ml-2">{{ count($proceso->flujos) }}</span>
                    </h5>
                    <button type="button" class="btn btn-primary-pro btn-sm" data-toggle="modal" data-target="#createFlujModal" 
                            onclick="setCreateModalProcessId({{ $proceso->id }})">
                        <i class="fas fa-plus mr-1"></i> Nuevo Flujo
                    </button>
                </div>
            </div>

            <div class="collapse show" id="flujosContent">
                <div class="card-body p-0">
                    @if(count($proceso->flujos) > 0)
                        <div class="table-responsive">
                            <table class="table-crud w-100">
                                <thead>
                                    <tr>
                                        <th>Descripción</th>
                                        <th>Tipo</th>
                                        <th class="text-center">Personas</th>
                                        <th class="text-center">Roles</th>
                                        <th style="width: 120px;">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($proceso->flujos as $flujo)
                                        <tr>
                                            <td>
                                                <strong class="text-primary">{{ $flujo->descripcion }}</strong>
                                                @if($flujo->observaciones)
                                                    <small class="text-muted d-block">{{ substr($flujo->observaciones, 0, 50) }}...</small>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge badge-info">{{ $flujo->tipoFlujo->descripcion ?? '-' }}</span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge badge-secondary">{{ count($flujo->personas) }}</span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge badge-warning">{{ count($flujo->tiposActores) }}</span>
                                            </td>
                                            <td>
                                                <div class="action-buttons">
                                                    <button type="button" class="btn-action btn-show" title="Ver detalles"
                                                            data-toggle="modal" data-target="#showFlujoModal"
                                                            onclick="loadFlujoDetailsModal({{ $proceso->id }}, '{{ $flujo->id }}')">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5 text-muted">
                            <i class="fas fa-inbox" style="font-size: 2rem;"></i>
                            <p class="mt-3">No hay flujos asociados aún</p>
                            <button type="button" class="btn btn-primary-pro btn-sm mt-3" data-toggle="modal" data-target="#createFlujModal" 
                                    onclick="setCreateModalProcessId({{ $proceso->id }})">
                                <i class="fas fa-plus mr-1"></i> Crear Primer Flujo
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Incluir los modales de flujos -->
@include('internal.flujos.create')
@include('internal.flujos.show')

<style>
.cursor-pointer {
    cursor: pointer;
    user-select: none;
}

.card-header:hover {
    background-color: #f5f5f5 !important;
    transition: background-color 0.2s ease;
}

.panel-toggle-icon {
    transition: transform 0.3s ease;
    display: inline-block;
}

.collapse.show ~ .card-header .panel-toggle-icon {
    transform: rotate(0deg);
}

#detallesPanel .collapsed .panel-toggle-icon,
#flujosPanel .collapsed .panel-toggle-icon {
    transform: rotate(-90deg);
}

.form-card {
    background: #fff;
    border: 1px solid #dee2e6;
    border-radius: 4px;
    padding: 1.5rem;
}

@media (max-width: 768px) {
    #flujosPanel {
        width: 100% !important;
    }
}
</style>

<script>
function togglePanelIcon(headerElement) {
    const icon = headerElement.querySelector('.panel-toggle-icon');
    if (icon) {
        icon.style.transform = icon.style.transform === 'rotate(-90deg)' ? 'rotate(0deg)' : 'rotate(-90deg)';
    }
}

function setCreateModalProcessId(procesId) {
    document.getElementById('createFlujModal').dataset.procesId = procesId;
}

function loadFlujoDetailsModal(procesId, flujoId) {
    const modal = document.getElementById('showFlujoModal');
    modal.dataset.procesId = procesId;
    modal.dataset.flujoId = flujoId;
    
    // Mostrar loader
    document.getElementById('flujoContent').innerHTML = `
        <div class="text-center py-5">
            <div class="spinner-border text-primary" role="status">
                <span class="sr-only">Cargando...</span>
            </div>
            <p class="mt-3 text-muted">Cargando información del flujo...</p>
        </div>
    `;
    
    // Realizar petición AJAX para cargar detalles
    fetch(`/internal/procesos/${procesId}/flujos/${flujoId}`, {
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => {
        if (!response.ok) throw new Error('Error al cargar flujo');
        return response.json();
    })
    .then(data => {
        displayFlujoDetailsContent(data, procesId, flujoId);
    })
    .catch(error => {
        console.error('Error:', error);
        document.getElementById('flujoContent').innerHTML = `
            <div class="alert alert-danger" role="alert">
                <i class="fas fa-exclamation-circle mr-2"></i>
                Error al cargar los detalles del flujo. Por favor, intenta nuevamente.
            </div>
        `;
    });
}

function displayFlujoDetailsContent(flujo, procesId, flujoId) {
    const html = `
        <div class="flujo-details">
            <div class="mb-4">
                <h6 class="text-muted small">Descripción</h6>
                <p class="h5">${escapeHtml(flujo.descripcion)}</p>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <h6 class="text-muted small">Tipo de Flujo</h6>
                    <span class="badge badge-info p-2">${escapeHtml(flujo.tipoFlujo)}</span>
                </div>
                <div class="col-md-6">
                    <h6 class="text-muted small">Estado</h6>
                    <span class="badge badge-secondary p-2">Activo</span>
                </div>
            </div>

            ${flujo.observaciones ? `
                <div class="mb-3">
                    <h6 class="text-muted small">Observaciones</h6>
                    <p>${escapeHtml(flujo.observaciones)}</p>
                </div>
            ` : ''}

            ${(flujo.fecha_inicio_analisis || flujo.fecha_firma_version) ? `
                <hr>
                <div class="row mb-3">
                    ${flujo.fecha_inicio_analisis ? `
                        <div class="col-md-6">
                            <h6 class="text-muted small">Fecha Inicio de Análisis</h6>
                            <p>${escapeHtml(flujo.fecha_inicio_analisis)}</p>
                        </div>
                    ` : ''}
                    ${flujo.fecha_firma_version ? `
                        <div class="col-md-6">
                            <h6 class="text-muted small">Fecha Firma de Versión</h6>
                            <p>${escapeHtml(flujo.fecha_firma_version)}</p>
                        </div>
                    ` : ''}
                </div>
            ` : ''}

            ${flujo.personas && flujo.personas.length > 0 ? `
                <hr>
                <div class="mb-3">
                    <h6 class="text-muted small mb-2">
                        <i class="fas fa-users mr-1"></i>
                        Personas Involucradas (${flujo.personas.length})
                    </h6>
                    <div class="d-flex flex-wrap gap-2">
                        ${flujo.personas.map(p => 
                            `<span class="badge badge-light border border-primary p-2">
                                <i class="fas fa-user mr-1"></i>${escapeHtml(p)}
                            </span>`
                        ).join('')}
                    </div>
                </div>
            ` : ''}

            ${flujo.tipos_actores && flujo.tipos_actores.length > 0 ? `
                <div class="mb-2">
                    <h6 class="text-muted small mb-2">
                        <i class="fas fa-shield-alt mr-1"></i>
                        Roles/Tipos de Actores (${flujo.tipos_actores.length})
                    </h6>
                    <div class="d-flex flex-wrap gap-2">
                        ${flujo.tipos_actores.map(r => 
                            `<span class="badge badge-warning p-2">${escapeHtml(r)}</span>`
                        ).join('')}
                    </div>
                </div>
            ` : ''}
        </div>
    `;

    document.getElementById('flujoContent').innerHTML = html;
    
    // Actualizar datos en los botones de acciones
    document.getElementById('editFlujBtn').onclick = function() {
        editFlujoModal(procesId, flujoId);
    };
    
    document.getElementById('deleteFlujBtn').onclick = function() {
        deleteFlujo(procesId, flujoId);
    };
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

function editFlujoModal(procesId, flujoId) {
    // Cargar el formulario de edición
    fetch(`/internal/procesos/${procesId}/flujos/${flujoId}/edit`, {
        headers: {
            'Accept': 'text/html',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.text())
    .then(html => {
        // Mostrar modal de edición (puede necesitar parsing adicional)
        $('#editFlujoModal').modal('show');
        
        // Prellenar el formulario con los datos actuales
        document.getElementById('editFlujoForm').dataset.flujoId = flujoId;
        document.getElementById('editFlujoForm').dataset.procesId = procesId;
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al cargar el formulario de edición');
    });
}

function deleteFlujo(procesId, flujoId) {
    if (!confirm('¿Estás seguro de que deseas eliminar este flujo? Esta acción no se puede deshacer.')) {
        return;
    }

    fetch(`/internal/procesos/${procesId}/flujos/${flujoId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            $('#showFlujoModal').modal('hide');
            showSuccessMessage(data.message || 'Flujo eliminado correctamente');
            
            setTimeout(() => {
                window.location.reload();
            }, 1500);
        } else {
            alert(data.message || 'Error al eliminar el flujo');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Ocurrió un error al eliminar el flujo');
    });
}

function showSuccessMessage(message) {
    // Usar toastr si está disponible, sino usar alert
    if (typeof toastr !== 'undefined') {
        toastr.success(message);
    } else {
        alert(message);
    }
}
</script>
@endsection
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
        <!-- Panel de Detalles Colapsable -->
        <div class="card mb-3" id="detallesPanel">
            <div class="card-header bg-light cursor-pointer" data-toggle="collapse" data-target="#detallesContent" 
                 onclick="togglePanelIcon(this)" style="cursor: pointer;">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chevron-down mr-2 panel-toggle-icon"></i>
                        <i class="fas fa-info-circle text-primary mr-2"></i>
                        Detalles del Proceso
                    </h5>
                </div>
                <small class="text-muted d-block mt-2">
                    <strong>{{ $proceso->codigo }}</strong> - {{ $proceso->descripcion }}
                    @if($proceso->tipoProceso)
                        <span class="badge badge-info ml-2">{{ $proceso->tipoProceso->descripcion }}</span>
                    @endif
                </small>
            </div>

            <div class="collapse show" id="detallesContent">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <div class="form-group mb-2">
                                <label class="text-muted small">Código</label>
                                <p class="h6 text-primary mb-0"><strong>{{ $proceso->codigo }}</strong></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-2">
                                <label class="text-muted small">Descripción</label>
                                <p class="h6 mb-0">{{ $proceso->descripcion }}</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group mb-2">
                                <label class="text-muted small">Estado</label>
                                <p class="mb-0">
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
                                    <span class="badge badge-{{ $estadoColor }}">
                                        {{ $proceso->estadoProceso->descripcion ?? '-' }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <div class="form-group mb-2">
                                <label class="text-muted small">Tipo de Proceso</label>
                                <p class="mb-0">
                                    <span class="badge badge-info">
                                        {{ $proceso->tipoProceso->descripcion ?? '-' }}
                                    </span>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-2">
                                <label class="text-muted small">Criticidad</label>
                                <p class="mb-0">
                                    @php
                                        $criticidadColor = match($proceso->criticidadProceso->descripcion ?? '') {
                                            'Baja' => 'success',
                                            'Media' => 'warning',
                                            'Alta' => 'danger',
                                            default => 'secondary'
                                        };
                                    @endphp
                                    <span class="badge badge-{{ $criticidadColor }}">
                                        <i class="fas fa-exclamation-triangle mr-1"></i>
                                        {{ $proceso->criticidadProceso->descripcion ?? '-' }}
                                    </span>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-2">
                                <label class="text-muted small">Requiere Revisión</label>
                                <p class="mb-0">
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
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group mb-2">
                                <label class="text-muted small">Unidad Responsable</label>
                                <p class="h6 mb-0">{{ $proceso->unidadResponsable->descripcion ?? '-' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-2">
                                <label class="text-muted small">Responsable del Proceso</label>
                                <p class="h6 mb-0">
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

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group mb-0">
                                <label class="text-muted small">Creado</label>
                                <p class="text-muted small">{{ $proceso->created_at ? $proceso->created_at->format('d/m/Y H:i A') : 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-0">
                                <label class="text-muted small">Proceso Padre</label>
                                <p>
                                    @if($proceso->procesoPadre)
                                        <a href="{{ route('internal.procesos.show', $proceso->procesoPadre->id) }}" class="text-primary">
                                            {{ $proceso->procesoPadre->codigo }} - {{ $proceso->procesoPadre->descripcion }}
                                        </a>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <hr class="my-3">

                    <div class="d-flex gap-2">
                        <a href="{{ route('internal.procesos.edit', $proceso->id) }}" class="btn btn-primary-pro btn-sm">
                            <i class="fas fa-pencil-alt mr-2"></i> Editar Proceso
                        </a>
                        <a href="{{ route('internal.procesos.index') }}" class="btn btn-secondary-pro btn-sm">
                            <i class="fas fa-arrow-left mr-2"></i> Volver
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Panel de Flujos Colapsable -->
        <div class="card" id="flujosPanel" style="width: 90%; margin: 0 auto;">
            <div class="card-header bg-light cursor-pointer" data-toggle="collapse" data-target="#flujosContent" 
                 onclick="togglePanelIcon(this)" style="cursor: pointer;">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chevron-down mr-2 panel-toggle-icon"></i>
                        <i class="fas fa-project-diagram text-primary mr-2"></i>
                        Flujos Asociados
                        <span class="badge badge-primary ml-2">{{ count($proceso->flujos) }}</span>
                    </h5>
                    <button type="button" class="btn btn-primary-pro btn-sm" data-toggle="modal" data-target="#createFlujModal" 
                            onclick="setCreateModalProcessId({{ $proceso->id }})">
                        <i class="fas fa-plus mr-1"></i> Nuevo Flujo
                    </button>
                </div>
            </div>

            <div class="collapse show" id="flujosContent">
                <div class="card-body p-0">
                    @if(count($proceso->flujos) > 0)
                        <div class="table-responsive">
                            <table class="table-crud w-100">
                                <thead>
                                    <tr>
                                        <th>Descripción</th>
                                        <th>Tipo</th>
                                        <th class="text-center">Personas</th>
                                        <th class="text-center">Roles</th>
                                        <th style="width: 120px;">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($proceso->flujos as $flujo)
                                        <tr>
                                            <td>
                                                <strong class="text-primary">{{ $flujo->descripcion }}</strong>
                                                @if($flujo->observaciones)
                                                    <small class="text-muted d-block">{{ substr($flujo->observaciones, 0, 50) }}...</small>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge badge-info">{{ $flujo->tipoFlujo->descripcion ?? '-' }}</span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge badge-secondary">{{ count($flujo->personas) }}</span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge badge-warning">{{ count($flujo->tiposActores) }}</span>
                                            </td>
                                            <td>
                                                <div class="action-buttons">
                                                    <button type="button" class="btn-action btn-show" title="Ver detalles"
                                                            data-toggle="modal" data-target="#showFlujoModal"
                                                            onclick="loadFlujoDetailsModal({{ $proceso->id }}, '{{ $flujo->id }}')">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5 text-muted">
                            <i class="fas fa-inbox" style="font-size: 2rem;"></i>
                            <p class="mt-3">No hay flujos asociados aún</p>
                            <button type="button" class="btn btn-primary-pro btn-sm mt-3" data-toggle="modal" data-target="#createFlujModal" 
                                    onclick="setCreateModalProcessId({{ $proceso->id }})">
                                <i class="fas fa-plus mr-1"></i> Crear Primer Flujo
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Incluir los modales de flujos -->
@include('internal.flujos.create')
@include('internal.flujos.show')

<style>
.cursor-pointer {
    cursor: pointer;
    user-select: none;
}

.card-header:hover {
    background-color: #f5f5f5 !important;
    transition: background-color 0.2s ease;
}

.panel-toggle-icon {
    transition: transform 0.3s ease;
    display: inline-block;
}

.collapsed .panel-toggle-icon {
    transform: rotate(-90deg);
}

.form-card {
    background: #fff;
    border: 1px solid #dee2e6;
    border-radius: 4px;
    padding: 1.5rem;
}

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

@media (max-width: 768px) {
    #flujosPanel {
        width: 100% !important;
    }
}
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
