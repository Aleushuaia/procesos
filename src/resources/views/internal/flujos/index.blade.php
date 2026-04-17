<!-- Archivo index de flujos - No usado en la interfaz modal pero necesario para el controlador -->
@extends('layouts.app')

@section('title', 'Flujos')

@section('page_title', 'Gestión de Flujos')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('internal.procesos.index') }}">Procesos</a></li>
    <li class="breadcrumb-item active">{{ $proceso->codigo }} - Flujos</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    Flujos del Proceso: {{ $proceso->codigo }}
                </h3>
            </div>
            <div class="card-body">
                @if($flujos && count($flujos) > 0)
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Descripción</th>
                                    <th>Tipo</th>
                                    <th>Personas</th>
                                    <th>Roles</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($flujos as $flujo)
                                    <tr>
                                        <td>{{ $flujo->descripcion }}</td>
                                        <td><span class="badge badge-info">{{ $flujo->tipoFlujo->descripcion }}</span></td>
                                        <td>{{ count($flujo->personas) }}</td>
                                        <td>{{ count($flujo->tiposActores) }}</td>
                                        <td>
                                            <a href="{{ route('internal.procesos.flujos.show', [$proceso->id, $flujo->id]) }}" class="btn btn-sm btn-info">Ver</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted">No hay flujos registrados</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
