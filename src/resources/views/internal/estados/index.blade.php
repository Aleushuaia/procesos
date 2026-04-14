@extends('layouts.app')
@section('title', 'Estados')
@section('page_title', 'Gestión de Estados')
@section('breadcrumb')
    <li class="breadcrumb-item active">Configuraciones</li>
    <li class="breadcrumb-item active">Estados</li>
@endsection
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">Lista de Estados</h3>
                <a href="{{ route('internal.estados.create') }}" class="btn btn-primary-pro">
                    <i class="fas fa-plus mr-2"></i> Nuevo Estado
                </a>
            </div>
            <div class="card-body p-0">
                @if($estados && count($estados) > 0)
                    <table class="table-crud w-100">
                        <thead>
                            <tr><th>Descripción</th><th>Creado</th><th style="width: 120px;">Acciones</th></tr>
                        </thead>
                        <tbody>
                            @foreach($estados as $estado)
                                <tr onclick="window.location.href='{{ route('internal.estados.show', $estado->id ?? 1) }}'" style="cursor: pointer;">
                                    <td><strong>{{ $estado->descripcion ?? 'Sin descripción' }}</strong></td>
                                    <td>{{ $estado->created_at ?? '' }}</td>
                                    <td onclick="event.stopPropagation();">
                                        <div class="action-buttons">
                                            <a href="{{ route('internal.estados.show', $estado->id ?? 1) }}" class="btn-action btn-show" title="Ver"><i class="fas fa-eye"></i></a>
                                            <a href="{{ route('internal.estados.edit', $estado->id ?? 1) }}" class="btn-action btn-edit" title="Editar"><i class="fas fa-pencil-alt"></i></a>
                                            <button type="button" class="btn-action btn-delete" title="Eliminar" onclick="confirmDelete('{{ route('internal.estados.destroy', $estado->id ?? 1) }}')"><i class="fas fa-trash"></i></button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="empty-state">
                        <i class="fas fa-inbox"></i>
                        <p class="mt-3">No hay estados registrados</p>
                        <a href="{{ route('internal.estados.create') }}" class="btn btn-primary-pro mt-3"><i class="fas fa-plus mr-2"></i> Crear primer Estado</a>
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
                <h5 class="modal-title">Confirmar eliminación</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">¿Estás seguro de que deseas eliminar este registro?</div>
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
