@extends('layouts.app')
@section('title', 'Estados')
@section('page_title', 'Detalles del Estado')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('internal.estados.index') }}">Estados</a></li>
    <li class="breadcrumb-item active">{{ $estado->descripcion ?? 'Ver' }}</li>
@endsection
@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="card-title mb-0"><i class="fas fa-flag mr-2 text-muted"></i>{{ $estado->descripcion }}</h5>
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <label class="text-muted small"><strong>Descripción</strong></label>
                    <p class="h6">{{ $estado->descripcion }}</p>
                </div>

                <div class="mb-4">
                    <label class="text-muted small"><strong>Color Asignado</strong></label>
                    <div style="padding: 15px; border-radius: 4px; color: white; background-color: {{ $estado->color ?? '#6c757d' }}; font-weight: 500; text-align: center;">
                        Etiqueta de Estado
                    </div>
                </div>

                <div class="mb-4">
                    <label class="text-muted small"><strong>Vista Previa</strong></label>
                    <span class="badge p-2" style="background-color: {{ $estado->color ?? '#6c757d' }}; color: white; font-size: 0.9rem;">
                        {{ $estado->descripcion }}
                    </span>
                </div>

                <div class="mb-4">
                    <label class="text-muted small"><strong>Creado</strong></label>
                    <p>{{ $estado->created_at ? $estado->created_at->format('d/m/Y H:i A') : 'N/A' }}</p>
                </div>

                <div class="mb-4">
                    <label class="text-muted small"><strong>Actualizado</strong></label>
                    <p>{{ $estado->updated_at ? $estado->updated_at->format('d/m/Y H:i A') : 'N/A' }}</p>
                </div>

                <hr>

                <div class="d-flex gap-2">
                    <a href="{{ route('internal.estados.edit', $estado->id) }}" class="btn btn-primary">
                        <i class="fas fa-pencil-alt mr-2"></i> Editar
                    </a>
                    <a href="{{ route('internal.estados.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left mr-2"></i> Volver
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
