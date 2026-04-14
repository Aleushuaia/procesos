@extends('layouts.app')

@section('title', 'Criticidades')

@section('page_title', 'Gestión de Criticidades')

@section('breadcrumb')
    <li class="breadcrumb-item active">Configuraciones</li>
    <li class="breadcrumb-item active">Criticidades</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">Lista de Criticidades</h3>
                <div>
                    <a href="{{ route('internal.criticidades.create') }}" class="btn btn-primary-pro">
                        <i class="fas fa-plus mr-2"></i> Nueva Criticidad
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                @if($criticidades && count($criticidades) > 0)
                    <table class="table-crud w-100">
                        <thead>
                            <tr>
                                <th>Descripción</th>
                                <th>Creado</th>
                                <th style="width: 120px;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($criticidades as $criticidad)
                                <tr onclick="window.location.href='{{ route('internal.criticidades.show', $criticidad->id) }}'" style="cursor: pointer;">
                                    <td><strong>{{ $criticidad->descripcion }}</strong></td>
                                    <td>{{ $criticidad->created_at ? $criticidad->created_at->format('d/m/Y') : '-' }}</td>
                                    <td onclick="event.stopPropagation();">
                                        <div class="action-buttons">
                                            <a href="{{ route('internal.criticidades.show', $criticidad->id) }}" class="btn-action btn-show" title="Ver">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('internal.criticidades.edit', $criticidad->id) }}" class="btn-action btn-edit" title="Editar">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            <button type="button" class="btn-action btn-delete" title="Eliminar" onclick="confirmDelete('{{ route('internal.criticidades.destroy', $criticidad->id) }}')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="empty-state">
                        <i class="fas fa-inbox"></i>
                        <p class="mt-3">No hay criticidades registradas</p>
                        <a href="{{ route('internal.criticidades.create') }}" class="btn btn-primary-pro mt-3">
                            <i class="fas fa-plus mr-2"></i> Crear primera Criticidad
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
                ¿Estás seguro de que deseas eliminar esta criticidad? Esta acción no se puede deshacer.
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
</script>
@endsection
