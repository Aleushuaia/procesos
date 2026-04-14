@extends('layouts.app')

@section('title', 'Ver Persona')

@section('page_title', 'Detalles de Persona')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('internal.personas.index') }}">Personas</a></li>
    <li class="breadcrumb-item active">Ver</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="form-card">
            <div class="mb-3">
                <label class="text-muted small">Apellido</label>
                <p class="h5">{{ $persona->apellido }}</p>
            </div>

            <div class="mb-3">
                <label class="text-muted small">Nombres</label>
                <p class="h5">{{ $persona->nombres }}</p>
            </div>

            <div class="mb-3">
                <label class="text-muted small">DNI</label>
                <p>{{ $persona->dni ?? '-' }}</p>
            </div>

            <div class="mb-3">
                <label class="text-muted small">Creado</label>
                <p>{{ $persona->created_at ? $persona->created_at->format('d/m/Y H:i A') : 'N/A' }}</p>
            </div>

            <div class="mt-4">
                <a href="{{ route('internal.personas.edit', $persona->id) }}" class="btn btn-primary-pro">
                    <i class="fas fa-pencil-alt mr-2"></i> Editar
                </a>
                <a href="{{ route('internal.personas.index') }}" class="btn btn-secondary-pro">
                    <i class="fas fa-arrow-left mr-2"></i> Volver
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
