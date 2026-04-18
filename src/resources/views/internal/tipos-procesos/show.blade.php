@extends('layouts.app')
@section('title', 'Tipos Procesos')
@section('page_title', 'Detalles del Tipo de Proceso')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('internal.tipos-procesos.index') }}">Tipos</a></li>
    <li class="breadcrumb-item active">{{ $tipoProceso->descripcion ?? 'Ver' }}</li>
@endsection
@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="card-title mb-0"><i class="fas fa-list mr-2 text-muted"></i>{{ $tipoProceso->descripcion }}</h5>
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <label class="text-muted small"><strong>Descripción</strong></label>
                    <p class="h6">{{ $tipoProceso->descripcion }}</p>
                </div>

                <div class="mb-4">
                    <label class="text-muted small"><strong>Color Asignado</strong></label>
                    <div style="padding: 15px; border-radius: 4px; color: white; background-color: {{ $tipoProceso->color ?? '#0c5aa0' }}; font-weight: 500; text-align: center;">
                        <i class="fas {{ $tipoProceso->icono ?? 'fa-folder' }} mr-2"></i>Tipo de Proceso
                    </div>
                </div>

                <div class="mb-4">
                    <label class="text-muted small"><strong>Icono Asignado</strong></label>
                    <div style="font-size: 2.5rem; color: {{ $tipoProceso->color ?? '#0c5aa0' }}; text-align: center;">
                        <i class="fas {{ $tipoProceso->icono ?? 'fa-folder' }}"></i>
                    </div>
                    <p style="text-align: center; color: #999; font-size: 0.85rem;">{{ $tipoProceso->icono ?? 'fa-folder' }}</p>
                </div>

                <div class="mb-4">
                    <label class="text-muted small"><strong>Vista Previa</strong></label>
                    <span class="badge p-2" style="background-color: {{ $tipoProceso->color ?? '#0c5aa0' }}; color: white; font-size: 0.9rem;">
                        <i class="fas {{ $tipoProceso->icono ?? 'fa-folder' }} mr-1"></i>{{ $tipoProceso->descripcion }}
                    </span>
                </div>

                <div class="mb-4">
                    <label class="text-muted small"><strong>Creado</strong></label>
                    <p>{{ $tipoProceso->created_at ? $tipoProceso->created_at->format('d/m/Y H:i A') : 'N/A' }}</p>
                </div>

                <div class="mb-4">
                    <label class="text-muted small"><strong>Actualizado</strong></label>
                    <p>{{ $tipoProceso->updated_at ? $tipoProceso->updated_at->format('d/m/Y H:i A') : 'N/A' }}</p>
                </div>

                <hr>

                <div class="d-flex gap-2">
                    <a href="{{ route('internal.tipos-procesos.edit', $tipoProceso->id) }}" class="btn btn-primary">
                        <i class="fas fa-pencil-alt mr-2"></i> Editar
                    </a>
                    <a href="{{ route('internal.tipos-procesos.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left mr-2"></i> Volver
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
