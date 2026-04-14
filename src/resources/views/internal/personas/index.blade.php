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
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">Lista de Personas</h3>
                <div class="d-flex gap-2">
                    <div>
                        <input type="text" class="form-control form-control-sm" id="searchInput" placeholder="Buscar persona..." style="width: 200px;">
                    </div>
                    <a href="{{ route('internal.personas.create') }}" class="btn btn-primary-pro">
                        <i class="fas fa-plus mr-2"></i> Nueva Persona
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                @if($personas && count($personas) > 0)
                    <table class="table-crud w-100">
                        <thead>
                            <tr>
                                <th>Apellido</th>
                                <th>Nombres</th>
                                <th>DNI</th>
                                <th>Creado</th>
                                <th style="width: 120px;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($personas as $persona)
                                <tr onclick="window.location.href='{{ route('internal.personas.show', $persona->id) }}'" style="cursor: pointer;">
                                    <td><strong>{{ $persona->apellido }}</strong></td>
                                    <td>{{ $persona->nombres }}</td>
                                    <td>{{ $persona->dni ?? '-' }}</td>
                                    <td>{{ $persona->created_at ? $persona->created_at->format('d/m/Y') : '-' }}</td>
                                    <td onclick="event.stopPropagation();">
                                        <div class="action-buttons">
                                            <a href="{{ route('internal.personas.show', $persona->id) }}" class="btn-action btn-show" title="Ver">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('internal.personas.edit', $persona->id) }}" class="btn-action btn-edit" title="Editar">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            <button type="button" class="btn-action btn-delete" title="Eliminar" onclick="confirmDelete('{{ route('internal.personas.destroy', $persona->id) }}')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" style="text-align: center; padding: 40px;">
                                        <i class="fas fa-inbox" style="font-size: 2rem; color: #ccc;"></i>
                                        <p class="mt-3" style="color: #999;">No hay personas registradas</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                @else
                    <div class="empty-state">
                        <i class="fas fa-inbox"></i>
                        <p class="mt-3">No hay personas registradas</p>
                        <a href="{{ route('internal.personas.create') }}" class="btn btn-primary-pro mt-3">
                            <i class="fas fa-plus mr-2"></i> Crear primera Persona
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
                <h5 class="modal-title" id="deleteModalLabel">Confirmar eliminación</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ¿Estás seguro de que deseas eliminar esta persona? Esta acción no se puede deshacer.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary-pro" data-dismiss="modal">Cancelar</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger-pro">Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
function confirmDelete(url) {
    document.getElementById('deleteForm').action = url;
    $('#deleteModal').modal('show');
}

// Búsqueda en tiempo real
document.getElementById('searchInput').addEventListener('keyup', function() {
    const value = this.value.toLowerCase();
    const rows = document.querySelectorAll('.table-crud tbody tr');
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(value) ? '' : 'none';
    });
});
</script>
@endsection
