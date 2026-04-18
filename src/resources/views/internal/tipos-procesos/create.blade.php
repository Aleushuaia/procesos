@extends('layouts.app')
@section('title', 'Tipos de Procesos')
@section('page_title', 'Nuevo Tipo de Proceso')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('internal.tipos-procesos.index') }}">Tipos</a></li>
    <li class="breadcrumb-item active">Nuevo</li>
@endsection
@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="card-title mb-0"><i class="fas fa-plus-circle mr-2 text-muted"></i>Crear Nuevo Tipo de Proceso</h5>
            </div>
            <form action="{{ route('internal.tipos-procesos.store') }}" method="POST" class="card-body">
                @csrf
                
                <div class="form-group">
                    <label for="descripcion">Descripción <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('descripcion') is-invalid @enderror" 
                           id="descripcion" name="descripcion" 
                           placeholder="Ej: Proceso Operativo, Soporte, Administrativo" 
                           value="{{ old('descripcion') }}" required maxlength="100">
                    @error('descripcion')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="color">Color de Etiqueta <span class="text-danger">*</span></label>
                    <div class="d-flex align-items-center gap-3">
                        <input type="color" class="form-control @error('color') is-invalid @enderror" 
                               id="color" name="color" value="{{ old('color', '#0c5aa0') }}" 
                               style="width: 100px; height: 45px; cursor: pointer;">
                        <div id="colorPreview" style="padding: 8px 16px; border-radius: 4px; color: white; font-weight: 500; background-color: #0c5aa0; min-width: 180px;">
                            <i class="fas fa-folder mr-2"></i>Tipo Ejemplo
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
                        <div id="iconoPreview" style="font-size: 2rem; color: #0c5aa0; width: 50px; text-align: center;">
                            <i class="fas fa-folder"></i>
                        </div>
                        <select class="form-control @error('icono') is-invalid @enderror" id="icono" name="icono" required style="flex: 1;">
                            <option value="">— Seleccionar Icono —</option>
                            <optgroup label="Procesos">
                                <option value="fa-folder">📁 Carpeta (fa-folder)</option>
                                <option value="fa-cogs">⚙️ Engranajes (fa-cogs)</option>
                                <option value="fa-tasks">✓ Tareas (fa-tasks)</option>
                                <option value="fa-project-diagram">📊 Diagrama (fa-project-diagram)</option>
                                <option value="fa-sitemap">🗂️ Estructura (fa-sitemap)</option>
                                <option value="fa-flow-chart">📈 Flujo (fa-flow-chart)</option>
                            </optgroup>
                            <optgroup label="Operaciones">
                                <option value="fa-industry">🏭 Industria (fa-industry)</option>
                                <option value="fa-cubes">📦 Cubos (fa-cubes)</option>
                                <option value="fa-rocket">🚀 Cohete (fa-rocket)</option>
                                <option value="fa-lightning">⚡ Rayo (fa-bolt)</option>
                                <option value="fa-gears">⚙️ Múltiples (fa-gears)</option>
                            </optgroup>
                            <optgroup label="Apoyo">
                                <option value="fa-life-ring">💬 Soporte (fa-life-ring)</option>
                                <option value="fa-headset">🎧 Atención (fa-headset)</option>
                                <option value="fa-users">👥 Equipo (fa-users)</option>
                                <option value="fa-handshake">🤝 Colaboración (fa-handshake)</option>
                            </optgroup>
                            <optgroup label="Gestión">
                                <option value="fa-chart-bar">📊 Estadísticas (fa-chart-bar)</option>
                                <option value="fa-database">💾 Datos (fa-database)</option>
                                <option value="fa-lock">🔒 Seguridad (fa-lock)</option>
                                <option value="fa-shield-alt">🛡️ Protección (fa-shield-alt)</option>
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
                    <div id="previewFinal" style="padding: 12px; border-radius: 4px; color: white; background-color: #0c5aa0; margin-top: 8px; text-align: center; font-weight: 500;">
                        <i class="fas fa-folder mr-2" style="font-size: 1.5rem;"></i><br>
                        <span>Tipo de Proceso</span>
                    </div>
                </div>

                <hr class="my-4">

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-2"></i> Guardar Tipo
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
    const desc = descripcionInput.value || 'Tipo de Proceso';
    
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
