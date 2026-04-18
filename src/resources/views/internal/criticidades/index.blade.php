@extends('layouts.app')

@section('title', 'Criticidades')

@section('page_title', 'Gestión de Criticidades')

@section('breadcrumb')
    <li class="breadcrumb-item active">Configuraciones</li>
    <li class="breadcrumb-item active">Criticidades</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8 col-md-10 col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0"><i class="fas fa-exclamation-circle mr-2"></i>Criticidades</h5>
                <a href="{{ route('internal.criticidades.create') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-plus mr-1"></i> Nueva Criticidad
                </a>
            </div>
            <div class="card-body p-0">
                @if($criticidades && count($criticidades) > 0)
                    <table class="table-crud w-100">
                        <thead>
                            <tr>
                                <th style="width: 40px;"></th>
                                <th>Descripción</th>
                                <th>Etiqueta</th>
                                <th style="width: 120px;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($criticidades as $criticidad)
                                <tr onclick="window.location.href='{{ route('internal.criticidades.show', $criticidad->id) }}'" style="cursor: pointer;">
                                    <td class="text-center">
                                        <span class="badge" style="background-color: {{ $criticidad->color ?? '#6c757d' }}; color: white; width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center; font-weight: bold; font-size: 1rem;">
                                            {{ strtoupper(substr($criticidad->descripcion, 0, 1)) }}
                                            </span>
                                    </td>
                                    <td><strong>{{ $criticidad->descripcion ?? 'Sin descripción' }}</strong></td>
                                    <td>
                                        <span class="badge p-2" style="background-color: {{ $criticidad->color ?? '#6c757d' }}; color: white;">
                                            <i class="fas fa-exclamation-triangle mr-1"></i>{{ $criticidad->descripcion }}
                                        </span>
                                    </td>
                                    <td onclick="event.stopPropagation();">
                                        <div class="action-buttons">
                                            <a href="{{ route('internal.criticidades.show', $criticidad->id) }}" class="btn-action btn-show" title="Ver"><i class="fas fa-eye"></i></a>
                                            <a href="{{ route('internal.criticidades.edit', $criticidad->id) }}" class="btn-action btn-edit" title="Editar"><i class="fas fa-pencil-alt"></i></a>
                                            <button type="button" class="btn-action btn-delete" title="Eliminar" onclick="confirmDelete('{{ route('internal.criticidades.destroy', $criticidad->id) }}')"><i class="fas fa-trash"></i></button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="empty-state text-center py-4">
                        <i class="fas fa-inbox" style="font-size: 2rem; opacity: 0.3;"></i>
                        <p class="mt-3 text-muted">No hay criticidades registradas</p>
                        <a href="{{ route('internal.criticidades.create') }}" class="btn btn-secondary btn-sm mt-2"><i class="fas fa-plus mr-1"></i> Crear primera</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-exclamation-triangle mr-2 text-danger"></i>Confirmar Eliminación</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">¿Estás seguro de que deseas eliminar esta criticidad? Esta acción no se puede deshacer.</div>
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
function confirmDelete(url) {
    document.getElementById('deleteForm').action = url;
    $('#deleteModal').modal('show');
}
</script>
@endsection
