@extends('layouts.app')

@section('title', 'Procesos')

@section('page_title', 'Gestión de Procesos')

@section('breadcrumb')
    <li class="breadcrumb-item active">Procesos</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">
                    <i class="fas fa-sitemap mr-2 text-primary"></i>
                    Lista de Procesos
                </h3>
                <div class="d-flex gap-2">
                    <div>
                        <input type="text" class="form-control form-control-sm" id="searchInput" placeholder="Buscar proceso o código..." style="width: 250px;">
                    </div>
                    <a href="{{ route('internal.procesos.create') }}" class="btn btn-primary-pro">
                        <i class="fas fa-plus mr-2"></i> Nuevo Proceso
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                @if($procesos && count($procesos) > 0)
                    <div class="table-responsive">
                        <table class="table-crud w-100">
                            <thead>
                                <tr>
                                    <th>Código</th>
                                    <th>Descripción</th>
                                    <th>Tipo</th>
                                    <th>Estado</th>
                                    <th>Criticidad</th>
                                    <th>Unidad</th>
                                    <th class="text-center">Flujos</th>
                                    <th style="width: 120px;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($procesos as $proceso)
                                    <tr onclick="window.location.href='{{ route('internal.procesos.show', $proceso->id) }}'" style="cursor: pointer;">
                                        <td><strong class="text-primary">{{ $proceso->codigo }}</strong></td>
                                        <td>
                                            <div>{{ $proceso->descripcion }}</div>
                                            @if($proceso->observaciones)
                                                <small class="text-muted d-block">{{ substr($proceso->observaciones, 0, 50) }}...</small>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge badge-info">{{ $proceso->tipoProceso->descripcion ?? '-' }}</span>
                                        </td>
                                        <td>
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
                                            <span class="badge badge-{{ $estadoColor }}">{{ $proceso->estadoProceso->descripcion ?? '-' }}</span>
                                        </td>
                                        <td>
                                            @php
                                                $criticidadColor = match($proceso->criticidadProceso->descripcion ?? '') {
                                                    'Baja' => 'success',
                                                    'Media' => 'warning',
                                                    'Alta' => 'danger',
                                                    default => 'secondary'
                                                };
                                                $criticidadIcon = match($proceso->criticidadProceso->descripcion ?? '') {
                                                    'Baja' => 'circle',
                                                    'Media' => 'circle',
                                                    'Alta' => 'exclamation-triangle',
                                                    default => 'circle'
                                                };
                                            @endphp
                                            <span class="badge badge-{{ $criticidadColor }}">
                                                <i class="fas fa-{{ $criticidadIcon }} mr-1"></i>{{ $proceso->criticidadProceso->descripcion ?? '-' }}
                                            </span>
                                        </td>
                                        <td>{{ $proceso->unidadResponsable->descripcion ?? '-' }}</td>
                                        <td class="text-center">
                                            <span class="badge badge-primary">{{ count($proceso->flujos) }}</span>
                                        </td>
                                        <td onclick="event.stopPropagation();">
                                            <div class="action-buttons">
                                                <a href="{{ route('internal.procesos.show', $proceso->id) }}" class="btn-action btn-show" title="Ver detalles">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('internal.procesos.edit', $proceso->id) }}" class="btn-action btn-edit" title="Editar">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                                <button type="button" class="btn-action btn-delete" title="Eliminar" onclick="confirmDelete('{{ route('internal.procesos.destroy', $proceso->id) }}')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" style="text-align: center; padding: 40px;">
                                            <i class="fas fa-inbox" style="font-size: 2rem; color: #ccc;"></i>
                                            <p class="mt-3" style="color: #999;">No hay procesos registrados</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="empty-state">
                        <i class="fas fa-sitemap"></i>
                        <p class="mt-3">No hay procesos registrados</p>
                        <a href="{{ route('internal.procesos.create') }}" class="btn btn-primary-pro mt-3">
                            <i class="fas fa-plus mr-2"></i> Crear primer Proceso
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal de confirmación para eliminar -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">
                    <i class="fas fa-exclamation-triangle text-danger mr-2"></i>
                    Confirmar eliminación
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ¿Estás seguro de que deseas eliminar este proceso? Esta acción no se puede deshacer.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary-pro" data-dismiss="modal">Cancelar</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash mr-2"></i>Eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete(url) {
    document.getElementById('deleteForm').action = url;
    $('#deleteModal').modal('show');
}

// Búsqueda en tiempo real
document.getElementById('searchInput').addEventListener('keyup', function(e) {
    let searchValue = this.value.toLowerCase();
    let rows = document.querySelectorAll('.table-crud tbody tr');
    
    rows.forEach(row => {
        let text = row.innerText.toLowerCase();
        row.style.display = text.includes(searchValue) ? '' : 'none';
    });
});
</script>
@endsection
