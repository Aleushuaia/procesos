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
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="card-title mb-0"><i class="fas fa-plus-circle mr-2 text-muted"></i>Crear Nueva Criticidad</h5>
            </div>
            <form action="{{ route('internal.criticidades.store') }}" method="POST" class="card-body">
                @csrf
                
                <div class="form-group">
                    <label for="descripcion">Descripción <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('descripcion') is-invalid @enderror" 
                           id="descripcion" name="descripcion" placeholder="Ej: Baja, Media, Alta" 
                           value="{{ old('descripcion') }}" required maxlength="100">
                    @error('descripcion')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="color">Color de Criticidad <span class="text-danger">*</span></label>
                    <div class="d-flex align-items-center gap-3">
                        <input type="color" class="form-control @error('color') is-invalid @enderror" 
                               id="color" name="color" value="{{ old('color', '#dc3545') }}" 
                               style="width: 100px; height: 45px; cursor: pointer;">
                        <div id="colorPreview" style="padding: 8px 16px; border-radius: 4px; color: white; font-weight: 500; background-color: #dc3545; min-width: 200px; text-align: center;">
                            <i class="fas fa-exclamation-triangle mr-2"></i>Criticidad Ejemplo
                        </div>
                    </div>
                    <small class="text-muted d-block mt-2">Selecciona un color para destacar esta criticidad en el sistema</small>
                    @error('color')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <hr class="my-4">

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-2"></i> Guardar Criticidad
                    </button>
                    <a href="{{ route('internal.criticidades.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left mr-2"></i> Volver
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('color').addEventListener('change', function() {
    document.getElementById('colorPreview').style.backgroundColor = this.value;
});
</script>
@endsection
                    <i class="fas fa-arrow-left mr-2"></i> Volver
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
