@extends('layouts.app')

@section('title', 'Personas')

@section('page_title', 'Gestión de Personas')

@section('breadcrumb')
    <li class="breadcrumb-item active">Configuraciones</li>
    <li class="breadcrumb-item active">Personas</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">

        <!-- PANEL DE FILTROS -->
        <div class="card mb-3">
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="fas fa-filter mr-2 text-primary"></i>
                    Filtros de búsqueda
                </h5>
                <a href="{{ route('internal.personas.create') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-plus mr-1"></i> Nueva Persona
                </a>
            </div>
            <div class="card-body">
                <div class="row align-items-end">
                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Apellido</label>
                        <input type="text" class="form-control form-control-sm" id="filterApellido" placeholder="Buscar por apellido...">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Nombres</label>
                        <input type="text" class="form-control form-control-sm" id="filterNombres" placeholder="Buscar por nombres...">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small fw-bold">DNI</label>
                        <input type="text" class="form-control form-control-sm" id="filterDni" placeholder="Número de DNI...">
                    </div>
                    <div class="col-md-4 mt-2">
                        <div class="d-flex gap-2 align-items-center">
                            <button class="btn btn-sm btn-primary" id="btnAplicarFiltros">
                                <i class="fas fa-search mr-1"></i> Aplicar
                            </button>
                            <button class="btn btn-sm btn-outline-secondary" id="btnLimpiarFiltros">
                                <i class="fas fa-times mr-1"></i> Limpiar
                            </button>
                            <small class="text-muted"><kbd>Enter</kbd> para buscar</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- PANEL DE DATOS -->
        <div class="card">
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="fas fa-users mr-2 text-primary"></i>
                    Lista de Personas
                </h5>
                <div class="d-flex align-items-center gap-2">
                    <label class="mb-0 small"><strong>Mostrar:</strong></label>
                    <select class="form-control form-control-sm" id="perPageSelect" style="width: auto;">
                        <option value="10">10 registros</option>
                        <option value="20">20 registros</option>
                        <option value="50">50 registros</option>
                        <option value="all" selected>Todos</option>
                    </select>
                </div>
            </div>

            <div class="card-body p-0">
                <div id="loadingSpinner" style="display: none; text-align: center; padding: 40px;">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Cargando...</span>
                    </div>
                    <p class="mt-2 text-muted">Cargando personas...</p>
                </div>

                <div id="tableContainer" class="table-responsive">
                    <table class="table-crud w-100">
                        <thead>
                            <tr>
                                <th style="cursor: pointer;" data-sort="apellido">
                                    Apellido <i class="fas fa-sort text-muted ml-1" style="font-size: 0.75rem;"></i>
                                </th>
                                <th style="cursor: pointer;" data-sort="nombres">
                                    Nombres <i class="fas fa-sort text-muted ml-1" style="font-size: 0.75rem;"></i>
                                </th>
                                <th style="cursor: pointer;" data-sort="dni">
                                    DNI <i class="fas fa-sort text-muted ml-1" style="font-size: 0.75rem;"></i>
                                </th>
                                <th>Tipos de Actor</th>
                                <th style="width: 120px;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="personasTableBody"></tbody>
                    </table>
                </div>

                <div id="emptyStateContainer" style="display: none; text-align: center; padding: 40px;">
                    <i class="fas fa-users" style="font-size: 2rem; color: #ccc;"></i>
                    <p class="mt-3" style="color: #999;">No hay personas que coincidan con los filtros</p>
                    <a href="{{ route('internal.personas.create') }}" class="btn btn-secondary btn-sm mt-2">
                        <i class="fas fa-plus mr-1"></i> Nueva Persona
                    </a>
                </div>
            </div>

            <!-- PAGINACIÓN -->
            <div class="card-footer bg-light" id="paginationContainer" style="display: none;">
                <nav class="d-flex justify-content-between align-items-center">
                    <small class="text-muted" id="paginationInfo"></small>
                    <ul class="pagination pagination-sm mb-0" id="paginationList"></ul>
                </nav>
            </div>
        </div>

    </div>
</div>

<!-- Modal eliminar -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle text-danger mr-2"></i>Confirmar eliminación
                </h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">¿Estás seguro de que deseas eliminar esta persona? Esta acción no se puede deshacer.</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
let currentSort      = 'apellido';
let currentDirection = 'asc';
let currentPerPage   = 'all';

function loadPersonas(page) {
    page = page || 1;
    showLoading(true);

    var filters = {
        apellido:  $('#filterApellido').val(),
        nombres:   $('#filterNombres').val(),
        dni:       $('#filterDni').val(),
        sort:      currentSort,
        direction: currentDirection,
        per_page:  currentPerPage,
        page:      page
    };

    $.ajax({
        url: '{{ route("internal.personas.index") }}',
        method: 'GET',
        data: filters,
        dataType: 'json',
        headers: { 'X-Requested-With': 'XMLHttpRequest' },
        success: function(response) {
            renderTable(response.data);
            renderPagination(response.pagination);
            showLoading(false);
        },
        error: function() {
            showLoading(false);
            $('#tableContainer').hide();
            $('#emptyStateContainer').show();
            $('#paginationContainer').hide();
        }
    });
}

function renderTable(personas) {
    var tbody = $('#personasTableBody');
    tbody.empty();

    if (!personas || personas.length === 0) {
        $('#tableContainer').hide();
        $('#emptyStateContainer').show();
        $('#paginationContainer').hide();
        return;
    }

    $('#tableContainer').show();
    $('#emptyStateContainer').hide();
    $('#paginationContainer').show();

    $.each(personas, function(i, p) {
        var tipos = '';
        if (p.tipos_actores && p.tipos_actores.length > 0) {
            $.each(p.tipos_actores, function(j, t) {
                tipos += '<span class="badge badge-secondary mr-1">' + escHtml(t.descripcion) + '</span>';
            });
        } else {
            tipos = '<span class="text-muted small">&mdash;</span>';
        }

        var row = '<tr style="cursor: pointer;" onclick="window.location.href=\'/internal/personas/' + p.id + '\'">'
            + '<td><strong>' + escHtml(p.apellido) + '</strong></td>'
            + '<td>' + escHtml(p.nombres) + '</td>'
            + '<td>' + (p.dni ? escHtml(p.dni) : '<span class="text-muted">&mdash;</span>') + '</td>'
            + '<td>' + tipos + '</td>'
            + '<td onclick="event.stopPropagation();">'
            +   '<div class="action-buttons">'
            +     '<a href="/internal/personas/' + p.id + '" class="btn-action btn-show" title="Ver"><i class="fas fa-eye"></i></a>'
            +     '<a href="/internal/personas/' + p.id + '/edit" class="btn-action btn-edit" title="Editar"><i class="fas fa-pencil-alt"></i></a>'
            +     '<button class="btn-action btn-delete" onclick="confirmDelete(\'/internal/personas/' + p.id + '\')" title="Eliminar"><i class="fas fa-trash"></i></button>'
            +   '</div>'
            + '</td>'
            + '</tr>';
        tbody.append(row);
    });
}

function renderPagination(pagination) {
    var info = $('#paginationInfo');
    var list = $('#paginationList');

    var showing = (pagination.last_page === 1)
        ? 'Mostrando ' + pagination.total + ' registro' + (pagination.total !== 1 ? 's' : '')
        : 'Página ' + pagination.current_page + ' de ' + pagination.last_page + ' — ' + pagination.total + ' registros en total';
    info.text(showing);

    list.empty();
    if (pagination.last_page <= 1) return;

    if (pagination.current_page > 1) {
        list.append('<li class="page-item"><a class="page-link" href="#" onclick="loadPersonas(' + (pagination.current_page - 1) + '); return false;">&laquo;</a></li>');
    } else {
        list.append('<li class="page-item disabled"><span class="page-link">&laquo;</span></li>');
    }

    var start = Math.max(1, pagination.current_page - 2);
    var end   = Math.min(pagination.last_page, start + 4);
    for (var i = start; i <= end; i++) {
        var active = i === pagination.current_page ? 'active' : '';
        list.append('<li class="page-item ' + active + '"><a class="page-link" href="#" onclick="loadPersonas(' + i + '); return false;">' + i + '</a></li>');
    }

    if (pagination.current_page < pagination.last_page) {
        list.append('<li class="page-item"><a class="page-link" href="#" onclick="loadPersonas(' + (pagination.current_page + 1) + '); return false;">&raquo;</a></li>');
    } else {
        list.append('<li class="page-item disabled"><span class="page-link">&raquo;</span></li>');
    }
}

function showLoading(show) {
    if (show) {
        $('#loadingSpinner').show();
        $('#tableContainer').hide();
        $('#emptyStateContainer').hide();
        $('#paginationContainer').hide();
    } else {
        $('#loadingSpinner').hide();
    }
}

function confirmDelete(url) {
    document.getElementById('deleteForm').action = url;
    $('#deleteModal').modal('show');
}

function escHtml(str) {
    if (!str) return '';
    return String(str)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;');
}

$(document).ready(function() {
    $('th[data-sort]').find('i').addClass('fa-sort text-muted');
    $('th[data-sort="apellido"]').find('i').removeClass('fa-sort text-muted').addClass('fa-sort-up text-warning');

    loadPersonas(1);

    $('#btnAplicarFiltros').on('click', function() { loadPersonas(1); });

    $('#btnLimpiarFiltros').on('click', function() {
        $('#filterApellido, #filterNombres, #filterDni').val('');
        currentSort = 'apellido';
        currentDirection = 'asc';
        currentPerPage = 'all';
        $('#perPageSelect').val('all');
        $('th[data-sort]').find('i').removeClass('fa-sort-up fa-sort-down text-warning').addClass('fa-sort text-muted');
        $('th[data-sort="apellido"]').find('i').removeClass('fa-sort text-muted').addClass('fa-sort-up text-warning');
        loadPersonas(1);
    });

    $('#filterApellido, #filterNombres, #filterDni').on('keydown', function(e) {
        if (e.key === 'Enter') loadPersonas(1);
    });

    $('#perPageSelect').on('change', function() {
        currentPerPage = $(this).val();
        loadPersonas(1);
    });

    $('th[data-sort]').on('click', function() {
        var col = $(this).data('sort');
        if (currentSort === col) {
            currentDirection = currentDirection === 'asc' ? 'desc' : 'asc';
        } else {
            currentSort = col;
            currentDirection = 'asc';
        }
        $('th[data-sort]').find('i').removeClass('fa-sort-up fa-sort-down text-warning').addClass('fa-sort text-muted');
        $(this).find('i').removeClass('fa-sort text-muted').addClass(currentDirection === 'asc' ? 'fa-sort-up text-warning' : 'fa-sort-down text-warning');
        loadPersonas(1);
    });
});
</script>
@endsection
