@extends('layouts.app')
@section('title', 'Unidades Responsables')
@section('page_title', 'Gestión de Unidades Responsables')
@section('breadcrumb')<li class="breadcrumb-item active">Configuraciones</li><li class="breadcrumb-item active">Unidades</li>@endsection
@section('content')
<div class="row">
    <div class="col-lg-7 col-md-9 col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0"><i class="fas fa-building mr-2"></i>Unidades Responsables</h5>
                <a href="{{ route('internal.unidades-responsables.create') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-plus mr-1"></i> Nueva Unidad
                </a>
            </div>
            <div class="card-body p-0">
                @if($unidadesResponsables && count($unidadesResponsables) > 0)
                    <table class="table-crud w-100">
                        <thead>
                            <tr>
                                <th>Descripción</th>
                                <th style="width: 120px;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($unidadesResponsables as $item)
                                <tr onclick="window.location.href='{{ route('internal.unidades-responsables.show', $item->id) }}'" style="cursor: pointer;">
                                    <td><strong>{{ $item->descripcion }}</strong></td>
                                    <td onclick="event.stopPropagation();">
                                        <div class="action-buttons">
                                            <a href="{{ route('internal.unidades-responsables.show', $item->id) }}" class="btn-action btn-show" title="Ver"><i class="fas fa-eye"></i></a>
                                            <a href="{{ route('internal.unidades-responsables.edit', $item->id) }}" class="btn-action btn-edit" title="Editar"><i class="fas fa-pencil-alt"></i></a>
                                            <button type="button" class="btn-action btn-delete" title="Eliminar" onclick="confirmDelete('{{ route('internal.unidades-responsables.destroy', $item->id) }}')"><i class="fas fa-trash"></i></button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="empty-state text-center py-4">
                        <i class="fas fa-inbox" style="font-size: 2rem; opacity: 0.3;"></i>
                        <p class="mt-3 text-muted">No hay unidades responsables registradas</p>
                        <a href="{{ route('internal.unidades-responsables.create') }}" class="btn btn-secondary btn-sm mt-2"><i class="fas fa-plus mr-1"></i> Crear primera</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="deleteModal" tabindex="-1"><div class="modal-dialog modal-sm"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">Confirmar eliminación</h5><button type="button" class="close" data-dismiss="modal"><span>&times;</span></button></div><div class="modal-body">¿Deseas eliminar este registro?</div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button><form id="deleteForm" method="POST" style="display: inline;">@csrf @method('DELETE')<button type="submit" class="btn btn-danger">Eliminar</button></form></div></div></div></div>
@endsection
@section('scripts')
<script>
function confirmDelete(url) {
    document.getElementById('deleteForm').action = url;
    $('#deleteModal').modal('show');
}
</script>
@endsection
