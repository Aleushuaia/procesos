@extends('layouts.app')
@section('title', 'Ver Criticidad')
@section('page_title', 'Detalles de Criticidad')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('internal.criticidades.index') }}">Criticidades</a></li>
    <li class="breadcrumb-item active">{{ $criticidad->descripcion ?? 'Ver' }}</li>
@endsection
@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="card-title mb-0"><i class="fas fa-exclamation-circle mr-2 text-muted"></i>{{ $criticidad->descripcion }}</h5>
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <label class="text-muted small"><strong>Descripción</strong></label>
                    <p class="h6">{{ $criticidad->descripcion }}</p>
                </div>

                <div class="mb-4">
                    <label class="text-muted small"><strong>Color Asignado</strong></label>
                    <div style="padding: 15px; border-radius: 4px; color: white; background-color: {{ $criticidad->color ?? '#dc3545' }}; font-weight: 500; text-align: center;">
                        <i class="fas fa-exclamation-triangle mr-2"></i>Criticidad
                    </div>
                </div>

                <div class="mb-4">
                    <label class="text-muted small"><strong>Vista Previa</strong></label>
                    <span class="badge p-2" style="background-color: {{ $criticidad->color ?? '#dc3545' }}; color: white; font-size: 0.9rem;">
                        <i class="fas fa-exclamation-triangle mr-1"></i>{{ $criticidad->descripcion }}
                    </span>
                </div>

                <div class="mb-4">
                    <label class="text-muted small"><strong>Creado</strong></label>
                    <p>{{ $criticidad->created_at ? $criticidad->created_at->format('d/m/Y H:i A') : 'N/A' }}</p>
                </div>

                <div class="mb-4">
                    <label class="text-muted small"><strong>Actualizado</strong></label>
                    <p>{{ $criticidad->updated_at ? $criticidad->updated_at->format('d/m/Y H:i A') : 'N/A' }}</p>
                </div>

                <hr>

                <div class="d-flex gap-2">
                    <a href="{{ route('internal.criticidades.edit', $criticidad->id) }}" class="btn btn-primary">
                        <i class="fas fa-pencil-alt mr-2"></i> Editar
                    </a>
                    <a href="{{ route('internal.criticidades.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left mr-2"></i> Volver
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
