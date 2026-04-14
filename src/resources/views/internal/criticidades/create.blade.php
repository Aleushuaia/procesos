@extends('layouts.app')

@section('title', 'Nueva Criticidad')

@section('page_title', 'Crear Nueva Criticidad')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('internal.criticidades.index') }}">Criticidades</a></li>
    <li class="breadcrumb-item active">Nueva</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <form action="{{ route('internal.criticidades.store') }}" method="POST" class="form-card">
            @csrf
            
            <div class="form-group">
                <label for="descripcion">Descripción <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('descripcion') is-invalid @enderror" id="descripcion" name="descripcion" placeholder="Descripción de la criticidad" required value="{{ old('descripcion') }}">
                @error('descripcion')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mt-4">
                <button type="submit" class="btn btn-primary-pro">
                    <i class="fas fa-save mr-2"></i> Guardar Criticidad
                </button>
                <a href="{{ route('internal.criticidades.index') }}" class="btn btn-secondary-pro">
                    <i class="fas fa-arrow-left mr-2"></i> Volver
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
