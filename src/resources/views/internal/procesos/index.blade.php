@extends('layouts.app')

@section('title', 'Procesos')

@section('page_title', 'Gestión de Procesos')

@section('breadcrumb')
    <li class="breadcrumb-item active">Procesos</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <!-- PANEL DE FILTROS -->
        <div class="card mb-3">
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="fas fa-filter mr-2 text-primary"></i>
                    Filtros Avanzados
                </h5>
                <div class="ml-auto d-flex">
                    <a href="{{ route('internal.procesos.create') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-plus mr-2"></i> Nuevo Proceso
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row g-2" style="row-gap:10px;">
                    <div class="col-md-2 d-flex align-items-center">
                        <label class="form-label small fw-bold mb-0 mr-2">Código</label>
                        <input type="text" class="form-control form-control-sm" id="filterCodigo" placeholder="Ej: PROC-001" style="flex:1;">
                    </div>
                    <div class="col-md-3 d-flex align-items-center">
                        <label class="form-label small fw-bold mb-0 mr-2">Descripción</label>
                        <input type="text" class="form-control form-control-sm" id="filterDescripcion" placeholder="Buscar descripción..." style="flex:1;">
                    </div>
                    <div class="col-auto d-flex align-items-center">
                        <label class="form-label small fw-bold mb-0 mr-2">Tipo</label>
                        <select class="form-control form-control-sm" id="filterTipo" style="flex:1; padding:.25rem .5rem; height: calc(1.5em + .5rem + 2px);">
                            <option value="">— Todos —</option>
                            @foreach($tiposProceso as $tipo)
                                <option value="{{ $tipo->id }}">{{ $tipo->descripcion }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-auto d-flex align-items-center">
                        <label class="form-label small fw-bold mb-0 mr-2">Estado</label>
                        <select class="form-control form-control-sm" id="filterEstado" style="flex:1; padding:.25rem .5rem; height: calc(1.5em + .5rem + 2px);">
                            <option value="">— Todos —</option>
                            @foreach($estadosProceso as $estado)
                                <option value="{{ $estado->id }}">{{ $estado->descripcion }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-auto d-flex align-items-center">
                        <label class="form-label small fw-bold mb-0 mr-2">Criticidad</label>
                        <select class="form-control form-control-sm" id="filterCriticidad" style="flex:1; padding:.25rem .5rem; height: calc(1.5em + .5rem + 2px);">
                            <option value="">— Todos —</option>
                            @foreach($criticidadesProceso as $criticidad)
                                <option value="{{ $criticidad->id }}">{{ $criticidad->descripcion }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-auto d-flex align-items-center">
                        <label class="form-label small fw-bold mb-0 mr-2">Unidad</label>
                        <select class="form-control form-control-sm" id="filterUnidad" style="flex:1; padding:.25rem .5rem; height: calc(1.5em + .5rem + 2px);">
                            <option value="">— Todos —</option>
                            @foreach($unidadesResponsables as $unidad)
                                <option value="{{ $unidad->id }}">{{ $unidad->descripcion }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-auto d-flex align-items-center">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" id="filterRequiereRevision">
                            <label class="form-check-label small" for="filterRequiereRevision">Mostrar sólo en revisión</label>
                        </div>
                    </div>
                </div>
                    <div class="col-auto ml-auto d-flex gap-2 align-items-center">
                        <button class="btn btn-sm btn-primary" id="btnAplicarFiltros">
                            <i class="fas fa-search mr-1"></i> Aplicar filtros
                        </button>
                        <button class="btn btn-sm btn-outline-secondary" id="btnLimpiarFiltros">
                            <i class="fas fa-times mr-1"></i> Limpiar filtros
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- PANEL DE DATOS -->
        <div class="card" style="min-height: calc(100vh - 220px); display:flex; flex-direction:column;">
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="fas fa-sitemap mr-2 text-primary"></i>
                    Lista de Procesos
                </h5>
                <div class="d-flex align-items-center gap-2 ml-auto">
                    <label class="mb-0 small"><strong>Mostrar:</strong></label>
                    <select class="form-control form-control-sm" id="perPageSelect" style="width: auto; padding:.25rem .5rem; height: calc(1.5em + .5rem + 2px);">
                        <option value="all" selected>Todos</option>
                        <option value="10">10 registros</option>
                        <option value="20">20 registros</option>
                        <option value="50">50 registros</option>
                    </select>
                </div>
            </div>

            <div class="card-body p-0" style="flex:1 1 auto; overflow:auto;">
                <div id="loadingSpinner" style="display: none; text-align: center; padding: 40px;">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Cargando...</span>
                    </div>
                    <p class="mt-2 text-muted">Cargando procesos...</p>
                </div>

                <div id="tableContainer" class="table-responsive" style="width: 100%; max-width: none;">
                    <table class="table-crud w-100 table-sm" style="width:100%; table-layout: fixed; font-size:0.92rem;">
                        <thead>
                            <tr>
                                <th style="cursor: pointer; width:9%; white-space:nowrap;" data-sort="codigo">
                                    Código
                                    <i class="fas fa-sort text-muted ml-1" style="font-size: 0.75rem;"></i>
                                </th>
                                <th style="cursor: pointer; width:40%;" data-sort="descripcion">
                                    Descripción
                                        <i class="fas fa-sort text-muted ml-1" style="font-size: 0.75rem;"></i>
                                </th>
                                <th style="cursor: pointer; width:12%; white-space:nowrap;" data-sort="tipo_proceso_id">
                                    Tipo
                                        <i class="fas fa-sort text-muted ml-1" style="font-size: 0.7rem;"></i>
                                </th>
                                <th style="cursor: pointer; width:10%; white-space:nowrap;" data-sort="estado_proceso_id">
                                    Estado
                                        <i class="fas fa-sort text-muted ml-1" style="font-size: 0.7rem;"></i>
                                </th>
                                <th style="cursor: pointer; width:8%; white-space:nowrap;" data-sort="criticidad_proceso_id">
                                    Criticidad
                                        <i class="fas fa-sort text-muted ml-1" style="font-size: 0.7rem;"></i>
                                </th>
                                <th style="cursor: pointer; width:13%; white-space:nowrap;" data-sort="unidad_responsable_id">
                                    Unidad
                                        <i class="fas fa-sort text-muted ml-1" style="font-size: 0.75rem;"></i>
                                </th>
                                <!-- Flujos column removed (shown next to Código) -->
                                <th style="width:8%;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="procesosTableBody">
                            <!-- Contenido dinamico cargado por AJAX -->
                        </tbody>
                    </table>
                </div>

                <div id="emptyStateContainer" style="display: none; text-align: center; padding: 40px;">
                    <i class="fas fa-inbox" style="font-size: 2rem; color: #ccc;"></i>
                    <p class="mt-3" style="color: #999;">No hay procesos registrados</p>
                </div>
            </div>

            <!-- PAGINACIÓN -->
            <div class="card-footer bg-light" id="paginationContainer" style="display: none;">
                <nav aria-label="Paginación" class="d-flex justify-content-between align-items-center">
                    <small class="text-muted" id="paginationInfo"></small>
                    <ul class="pagination pagination-sm mb-0" id="paginationList"></ul>
                </nav>
            </div>
        </div>
    </div>
</div>

<!-- Modal de confirmación para eliminar -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle text-danger mr-2"></i>
                    Confirmar eliminación
                </h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ¿Estás seguro de que deseas eliminar este proceso? Esta acción no se puede deshacer.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash mr-1"></i>Eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
let currentSort = 'codigo';
let currentDirection = 'asc';
let currentPerPage = 'all';

const filterInputs = {
    codigo: '#filterCodigo',
    descripcion: '#filterDescripcion',
    tipo: '#filterTipo',
    estado: '#filterEstado',
    criticidad: '#filterCriticidad',
    unidad: '#filterUnidad',
    requiere: '#filterRequiereRevision'
};

// Cargar procesos al iniciar
function loadProcesos(page = 1) {
    showLoading(true);

    const filters = {
        codigo:                $(filterInputs.codigo).val(),
        descripcion:           $(filterInputs.descripcion).val(),
        tipo_proceso_id:       $(filterInputs.tipo).val(),
        estado_proceso_id:     $(filterInputs.estado).val(),
        criticidad_proceso_id: $(filterInputs.criticidad).val(),
        unidad_responsable_id: $(filterInputs.unidad).val(),
        requiere_revision:     $(filterInputs.requiere).length ? ($(filterInputs.requiere).is(':checked') ? 1 : '') : '',
        sort:      currentSort,
        direction: currentDirection,
        per_page:  currentPerPage,
        page:      page
    };

    $.ajax({
        url: '{{ route("internal.procesos.index") }}',
        method: 'GET',
        data: filters,
        dataType: 'json',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        },
        success: function(response) {
            renderTable(response.data);
            renderPagination(response.pagination);
            showLoading(false);
        },
        error: function() {
            showError('Error al cargar los procesos');
            showLoading(false);
        }
    });
}

function renderTable(procesos) {
    const tbody = $('#procesosTableBody');
    tbody.empty();

    if (procesos.length === 0) {
        $('#tableContainer').hide();
        $('#emptyStateContainer').show();
        $('#paginationContainer').hide();
        return;
    }

    $('#tableContainer').show();
    $('#emptyStateContainer').hide();
    $('#paginationContainer').show();

    procesos.forEach(proceso => {
        const row = `
            <tr>
                <td>
                    <strong class="text-white">${proceso.codigo || '-'}</strong>
                    ${proceso.requiere_revision ? `<div><small class="text-danger d-inline" style="font-size:0.65rem;">En revisión</small> <small class="text-white d-inline" style="font-size:0.65rem;">&#9733; ${proceso.flujos ? proceso.flujos.length : 0} flujos</small></div>` : `<div><small class="text-white d-inline" style="font-size:0.65rem;">&#9733; ${proceso.flujos ? proceso.flujos.length : 0} flujos</small></div>`}
                </td>
                <td style="overflow-wrap:break-word; word-break:break-word;">
                    <div>${proceso.descripcion || '-'}</div>
                    ${proceso.observaciones ? `<small class="text-muted d-block">${proceso.observaciones.substring(0, 50)}...</small>` : ''}
                </td>
                <td>
                    <span style="background-color: ${proceso.tipo_proceso?.color || '#0c5aa0'}; color: white; padding:.18rem .4rem; font-size:0.82rem; display:inline-block; border-radius:.25rem;">
                        <i class="fas ${proceso.tipo_proceso?.icono || 'fa-folder'}" style="margin-right:6px;font-size:0.82rem;"></i>${proceso.tipo_proceso?.descripcion || '-'}
                    </span>
                    
                </td>
                <td>
                    <span style="background-color: ${proceso.estado_proceso?.color || '#6c757d'}; color: white; padding:.16rem .36rem; font-size:0.82rem; display:inline-block; border-radius:.25rem;">
                        ${proceso.estado_proceso?.descripcion || '-'}
                    </span>
                </td>
                <td>
                    <span style="background-color: ${proceso.criticidad_proceso?.color || '#dc3545'}; color: white; padding:.16rem .36rem; font-size:0.82rem; display:inline-block; border-radius:.25rem;">
                        <i class="fas fa-exclamation-triangle" style="margin-right:6px;font-size:0.82rem;"></i>${proceso.criticidad_proceso?.descripcion || '-'}
                    </span>
                </td>
                <td>${proceso.unidad_responsable?.descripcion || '-'}</td>
                <!-- Flujos moved under Tipo -->
                <td>
                    <div class="action-buttons">
                        <a href="/internal/procesos/${proceso.id}" class="btn-action btn-show" title="Ver detalles">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="/internal/procesos/${proceso.id}/edit" class="btn-action btn-edit" title="Editar">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        <button class="btn-action btn-delete" onclick="confirmDelete('/internal/procesos/${proceso.id}')" title="Eliminar">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
        `;
        tbody.append(row);
    });
}

function renderPagination(pagination) {
    const info = $('#paginationInfo');
    const list = $('#paginationList');

    const showing = (pagination.last_page === 1)
        ? `Mostrando ${pagination.total} registro${pagination.total !== 1 ? 's' : ''}`
        : `Mostrando ${pagination.per_page} de ${pagination.total} registros — Página ${pagination.current_page} de ${pagination.last_page}`;
    info.text(showing);

    list.empty();

    // Si solo hay 1 página no mostramos botonera
    if (pagination.last_page <= 1) return;

    // Botón anterior
    if (pagination.current_page > 1) {
        list.append(`<li class="page-item"><a class="page-link" href="#" onclick="loadProcesos(${pagination.current_page - 1}); return false;">&laquo;</a></li>`);
    } else {
        list.append('<li class="page-item disabled"><span class="page-link">&laquo;</span></li>');
    }

    // Números de página (ventana de 5)
    const start = Math.max(1, pagination.current_page - 2);
    const end   = Math.min(pagination.last_page, start + 4);
    for (let i = start; i <= end; i++) {
        const activeClass = i === pagination.current_page ? 'active' : '';
        list.append(`<li class="page-item ${activeClass}"><a class="page-link" href="#" onclick="loadProcesos(${i}); return false;">${i}</a></li>`);
    }

    // Botón siguiente
    if (pagination.current_page < pagination.last_page) {
        list.append(`<li class="page-item"><a class="page-link" href="#" onclick="loadProcesos(${pagination.current_page + 1}); return false;">&raquo;</a></li>`);
    } else {
        list.append('<li class="page-item disabled"><span class="page-link">&raquo;</span></li>');
    }
}

function showLoading(show) {
    if (show) {
        $('#loadingSpinner').show();
        $('#tableContainer').hide();
        $('#emptyStateContainer').hide();
    } else {
        $('#loadingSpinner').hide();
    }
}

function showError(message) {
    alert(message);
}

function confirmDelete(url) {
    document.getElementById('deleteForm').action = url;
    $('#deleteModal').modal('show');
}

// Event listeners
$('#btnAplicarFiltros').on('click', function() {
    loadProcesos(1);
});

$('#btnLimpiarFiltros').on('click', function() {
    $(filterInputs.codigo).val('');
    $(filterInputs.descripcion).val('');
    $(filterInputs.tipo).val('');
    $(filterInputs.estado).val('');
    $(filterInputs.criticidad).val('');
    $(filterInputs.unidad).val('');
    $(filterInputs.requiere).prop('checked', false);
    currentSort = 'codigo';
    currentDirection = 'asc';
    currentPerPage = 'all';
    $('#perPageSelect').val('all');
    // Reset header icons
    $('th[data-sort]').each(function() {
        const ic = $(this).find('i');
        ic.removeClass('fa-sort-up fa-sort-down text-warning').addClass('fa-sort text-muted');
    });
    // set default on codigo
    $('th[data-sort="codigo"]').find('i').removeClass('fa-sort text-muted').addClass('fa-sort-up text-warning');
    loadProcesos(1);
});

// Aplicar filtros con Enter en inputs de texto
$('#filterCodigo, #filterDescripcion').on('keydown', function(e) {
    if (e.key === 'Enter') loadProcesos(1);
});

$('#perPageSelect').on('change', function() {
    currentPerPage = $(this).val();
    loadProcesos(1);
});

// Ordenamiento por columna (toggle asc/desc) y actualizar iconos
$('th[data-sort]').on('click', function() {
    const column = $(this).data('sort');

    if (currentSort === column) {
        currentDirection = currentDirection === 'asc' ? 'desc' : 'asc';
    } else {
        currentSort = column;
        currentDirection = 'asc';
    }

    // Reset icons
    $('th[data-sort]').each(function() {
        const ic = $(this).find('i');
        ic.removeClass('fa-sort-up fa-sort-down text-warning').addClass('fa-sort text-muted');
    });

    // Set icon for active column
    const icon = $(this).find('i');
    icon.removeClass('fa-sort text-muted');
    if (currentDirection === 'asc') {
        icon.addClass('fa-sort-up text-warning');
    } else {
        icon.addClass('fa-sort-down text-warning');
    }

    loadProcesos(1);
});

// Cargar procesos al iniciar la página
$(document).ready(function() {
    // Initialize header icons
    $('th[data-sort]').each(function() {
        $(this).find('i').removeClass('fa-sort-up fa-sort-down text-warning').addClass('fa-sort text-muted');
    });
    $('th[data-sort="codigo"]').find('i').removeClass('fa-sort text-muted').addClass('fa-sort-up text-warning');

    loadProcesos(1);
});
</script>
@endsection
