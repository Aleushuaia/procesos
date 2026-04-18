@extends('layouts.app')
@section('title', 'Tipos de Procesos')
@section('page_title', 'Editar Tipo de Proceso')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('internal.tipos-procesos.index') }}">Tipos</a></li>
    <li class="breadcrumb-item active">{{ $tipoProceso->descripcion ?? 'Editar' }}</li>
@endsection
@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="card-title mb-0"><i class="fas fa-edit mr-2 text-muted"></i>Editar Tipo: {{ $tipoProceso->descripcion }}</h5>
            </div>
            <form action="{{ route('internal.tipos-procesos.update', $tipoProceso->id) }}" method="POST" class="card-body">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label for="descripcion">Descripción <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('descripcion') is-invalid @enderror" 
                           id="descripcion" name="descripcion" 
                           value="{{ old('descripcion', $tipoProceso->descripcion) }}" 
                           required maxlength="100">
                    @error('descripcion')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="color">Color de Etiqueta <span class="text-danger">*</span></label>
                    <div class="d-flex align-items-center gap-3">
                        <input type="color" class="form-control @error('color') is-invalid @enderror" 
                               id="color" name="color" 
                               value="{{ old('color', $tipoProceso->color ?? '#0c5aa0') }}" 
                               style="width: 100px; height: 45px; cursor: pointer;">
                        <div id="colorPreview" style="padding: 8px 16px; border-radius: 4px; color: white; font-weight: 500; background-color: {{ old('color', $tipoProceso->color ?? '#0c5aa0') }}; min-width: 180px;">
                            <i class="fas {{ old('icono', $tipoProceso->icono ?? 'fa-folder') }} mr-2"></i>{{ $tipoProceso->descripcion }}
                        </div>
                    </div>
                    <small class="text-muted d-block mt-2">Selecciona un color distintivo para esta categoría</small>
                    @error('color')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="icono">Icono Font Awesome <span class="text-danger">*</span></label>
                    <div class="d-flex align-items-center gap-2">
                        <div id="iconoPreview" style="font-size: 2rem; color: {{ old('color', $tipoProceso->color ?? '#0c5aa0') }}; width: 50px; text-align: center;">
                            <i class="fas {{ old('icono', $tipoProceso->icono ?? 'fa-folder') }}"></i>
                        </div>
                        <select class="form-control @error('icono') is-invalid @enderror" id="icono" name="icono" required style="flex: 1;">
                            <option value="">— Seleccionar Icono —</option>
                            <optgroup label="Procesos">
                                <option value="fa-folder" {{ old('icono', $tipoProceso->icono) == 'fa-folder' ? 'selected' : '' }}>📁 Carpeta</option>
                                <option value="fa-cogs" {{ old('icono', $tipoProceso->icono) == 'fa-cogs' ? 'selected' : '' }}>⚙️ Engranajes</option>
                                <option value="fa-tasks" {{ old('icono', $tipoProceso->icono) == 'fa-tasks' ? 'selected' : '' }}>✓ Tareas</option>
                                <option value="fa-project-diagram" {{ old('icono', $tipoProceso->icono) == 'fa-project-diagram' ? 'selected' : '' }}>📊 Diagrama</option>
                                <option value="fa-sitemap" {{ old('icono', $tipoProceso->icono) == 'fa-sitemap' ? 'selected' : '' }}>🗂️ Estructura</option>
                                <option value="fa-flow-chart" {{ old('icono', $tipoProceso->icono) == 'fa-flow-chart' ? 'selected' : '' }}>📈 Flujo</option>
                            </optgroup>
                            <optgroup label="Operaciones">
                                <option value="fa-industry" {{ old('icono', $tipoProceso->icono) == 'fa-industry' ? 'selected' : '' }}>🏭 Industria</option>
                                <option value="fa-cubes" {{ old('icono', $tipoProceso->icono) == 'fa-cubes' ? 'selected' : '' }}>📦 Cubos</option>
                                <option value="fa-rocket" {{ old('icono', $tipoProceso->icono) == 'fa-rocket' ? 'selected' : '' }}>🚀 Cohete</option>
                                <option value="fa-bolt" {{ old('icono', $tipoProceso->icono) == 'fa-bolt' ? 'selected' : '' }}>⚡ Rayo</option>
                                <option value="fa-gears" {{ old('icono', $tipoProceso->icono) == 'fa-gears' ? 'selected' : '' }}>⚙️ Múltiples</option>
                            </optgroup>
                            <optgroup label="Apoyo">
                                <option value="fa-life-ring" {{ old('icono', $tipoProceso->icono) == 'fa-life-ring' ? 'selected' : '' }}>💬 Soporte</option>
                                <option value="fa-headset" {{ old('icono', $tipoProceso->icono) == 'fa-headset' ? 'selected' : '' }}>🎧 Atención</option>
                                <option value="fa-users" {{ old('icono', $tipoProceso->icono) == 'fa-users' ? 'selected' : '' }}>👥 Equipo</option>
                                <option value="fa-handshake" {{ old('icono', $tipoProceso->icono) == 'fa-handshake' ? 'selected' : '' }}>🤝 Colaboración</option>
                            </optgroup>
                            <optgroup label="Gestión">
                                <option value="fa-chart-bar" {{ old('icono', $tipoProceso->icono) == 'fa-chart-bar' ? 'selected' : '' }}>📊 Estadísticas</option>
                                <option value="fa-database" {{ old('icono', $tipoProceso->icono) == 'fa-database' ? 'selected' : '' }}>💾 Datos</option>
                                <option value="fa-lock" {{ old('icono', $tipoProceso->icono) == 'fa-lock' ? 'selected' : '' }}>🔒 Seguridad</option>
                                <option value="fa-shield-alt" {{ old('icono', $tipoProceso->icono) == 'fa-shield-alt' ? 'selected' : '' }}>🛡️ Protección</option>
                            </optgroup>
                        </select>
                    </div>
                    <small class="text-muted d-block mt-2">Selecciona un icono representativo para este tipo de proceso</small>
                    @error('icono')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="card bg-light mt-4 p-3">
                    <small class="text-muted"><strong>Vista previa:</strong></small>
                    <div id="previewFinal" style="padding: 12px; border-radius: 4px; color: white; background-color: {{ old('color', $tipoProceso->color ?? '#0c5aa0') }}; margin-top: 8px; text-align: center; font-weight: 500;">
                        <i class="fas {{ old('icono', $tipoProceso->icono ?? 'fa-folder') }} mr-2" style="font-size: 1.5rem;"></i><br>
                        <span>{{ $tipoProceso->descripcion }}</span>
                    </div>
                </div>

                <hr class="my-4">

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-2"></i> Guardar Cambios
                    </button>
                    <a href="{{ route('internal.tipos-procesos.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left mr-2"></i> Volver
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
const colorInput = document.getElementById('color');
const iconoSelect = document.getElementById('icono');
const descripcionInput = document.getElementById('descripcion');

const updatePreview = () => {
    const color = colorInput.value;
    const icono = iconoSelect.value || 'fa-folder';
    const desc = descripcionInput.value || '{{ $tipoProceso->descripcion }}';
    
    document.getElementById('colorPreview').style.backgroundColor = color;
    document.getElementById('colorPreview').innerHTML = `<i class="fas ${icono} mr-2"></i>${desc}`;
    
    document.getElementById('iconoPreview').style.color = color;
    document.getElementById('iconoPreview').innerHTML = `<i class="fas ${icono}"></i>`;
    
    document.getElementById('previewFinal').style.backgroundColor = color;
    document.getElementById('previewFinal').innerHTML = `<i class="fas ${icono} mr-2" style="font-size: 1.5rem;"></i><br><span>${desc}</span>`;
};

colorInput.addEventListener('change', updatePreview);
iconoSelect.addEventListener('change', updatePreview);
descripcionInput.addEventListener('input', updatePreview);

updatePreview();
</script>
@endsection
