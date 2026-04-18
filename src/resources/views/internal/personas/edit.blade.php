@extends('layouts.app')

@section('title', 'Editar Persona')

@section('page_title', 'Editar Persona')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('internal.personas.index') }}">Personas</a></li>
    <li class="breadcrumb-item active">Editar</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <form action="{{ route('internal.personas.update', $persona->id) }}" method="POST" class="form-card">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="apellido">Apellido <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('apellido') is-invalid @enderror" id="apellido" name="apellido" placeholder="Apellido" required value="{{ old('apellido', $persona->apellido) }}">
                @error('apellido')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="nombres">Nombres <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('nombres') is-invalid @enderror" id="nombres" name="nombres" placeholder="Nombres" required value="{{ old('nombres', $persona->nombres) }}">
                @error('nombres')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="dni">DNI</label>
                <input type="text" class="form-control @error('dni') is-invalid @enderror" id="dni" name="dni" placeholder="DNI" value="{{ old('dni', $persona->dni) }}">
                @error('dni')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-2"></i> Guardar cambios
                </button>
                <a href="{{ route('internal.personas.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left mr-2"></i> Volver
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
