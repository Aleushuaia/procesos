<!-- Modal para crear nuevo flujo -->
<div class="modal fade" id="createFlujModal" tabindex="-1" role="dialog" aria-labelledby="createFlujoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document" style="max-width: 800px;">
        <div class="modal-content">
            <div class="modal-header border-bottom">
                <h5 class="modal-title" id="createFlujoModalLabel">
                    <i class="fas fa-plus-circle text-primary mr-2"></i>
                    Crear Nuevo Flujo
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="createFlujoForm" method="POST" class="needs-validation">
                @csrf
                <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                    
                    <!-- Información Básica -->
                    <div class="mb-4">
                        <h6 class="text-primary mb-3">
                            <i class="fas fa-info-circle mr-2"></i>
                            Información Básica
                        </h6>

                        <div class="form-group">
                            <label for="flujo_descripcion">Descripción <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="flujo_descripcion" name="descripcion" 
                                   placeholder="Descripción del flujo" required maxlength="255">
                            <small class="form-text text-muted">Máximo 255 caracteres</small>
                            <div class="invalid-feedback">Por favor ingresa una descripción</div>
                        </div>

                        <div class="form-group">
                            <label for="flujo_tipo">Tipo de Flujo <span class="text-danger">*</span></label>
                            <select class="form-control" id="flujo_tipo" name="tipo_flujo_id" required>
                                <option value="">-- Seleccionar --</option>
                                @foreach($tiposFlujo as $tipo)
                                    <option value="{{ $tipo->id }}">{{ $tipo->descripcion }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Por favor selecciona un tipo de flujo</div>
                        </div>

                        <div class="form-group">
                            <label for="flujo_observaciones">Observaciones</label>
                            <textarea class="form-control" id="flujo_observaciones" name="observaciones" 
                                      rows="3" placeholder="Observaciones o notas adicionales" maxlength="1000"></textarea>
                            <small class="form-text text-muted">Máximo 1000 caracteres</small>
                        </div>
                    </div>

                    <hr class="my-3">

                    <!-- Fechas -->
                    <div class="mb-4">
                        <h6 class="text-primary mb-3">
                            <i class="fas fa-calendar-alt mr-2"></i>
                            Fechas
                        </h6>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="flujo_fecha_inicio">Fecha Inicio de Análisis</label>
                                    <input type="date" class="form-control" id="flujo_fecha_inicio" 
                                           name="fecha_inicio_analisis">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="flujo_fecha_firma">Fecha Firma de Versión</label>
                                    <input type="date" class="form-control" id="flujo_fecha_firma" 
                                           name="fecha_firma_version">
                                    <small class="form-text text-muted">Debe ser igual o posterior a la fecha de inicio</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-3">

                    <!-- Personas -->
                    <div class="mb-4">
                        <h6 class="text-primary mb-3">
                            <i class="fas fa-users mr-2"></i>
                            Personas Involucradas
                        </h6>

                        <div class="form-group">
                            <div class="row align-items-end">
                                <div class="col-md-9">
                                    <label for="flujo_personas_select">Seleccionar Persona</label>
                                    <select class="form-control" id="flujo_personas_select">
                                        <option value="">-- Seleccionar una persona --</option>
                                        @foreach($personas as $persona)
                                            <option value="{{ $persona->id }}" data-apellido="{{ $persona->apellido }}" data-nombres="{{ $persona->nombres }}">
                                                {{ $persona->apellido }}, {{ $persona->nombres }}
                                                @if($persona->dni)
                                                    ({{ $persona->dni }})
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <button type="button" class="btn btn-primary-pro btn-block" id="agregarPersonaBtn">
                                        <i class="fas fa-plus mr-1"></i> Agregar
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Panel de Personas Seleccionadas -->
                        <div class="mt-3 p-3 bg-light rounded border" id="personasAgregadasPanel" style="min-height: 100px; display: none;">
                            <h6 class="mb-2">Personas Seleccionadas:</h6>
                            <div id="personasAgregadasList" class="d-flex flex-wrap gap-2"></div>
                        </div>
                        <input type="hidden" id="flujo_personas" name="personas[]" value="">
                    </div>

                    <hr class="my-3">

                    <!-- Tipos de Actores (Roles) -->
                    <div class="mb-2">
                        <h6 class="text-primary mb-3">
                            <i class="fas fa-shield-alt mr-2"></i>
                            Roles/Tipos de Actores
                        </h6>

                        <div class="form-group">
                            <div class="row align-items-end">
                                <div class="col-md-9">
                                    <label for="flujo_tipos_actores_select">Seleccionar Rol</label>
                                    <select class="form-control" id="flujo_tipos_actores_select">
                                        <option value="">-- Seleccionar un rol --</option>
                                        @foreach($tiposActores as $tipo)
                                            <option value="{{ $tipo->id }}" data-descripcion="{{ $tipo->descripcion }}">
                                                {{ $tipo->descripcion }}
                                                @if($tipo->observaciones)
                                                    ({{ substr($tipo->observaciones, 0, 30) }}...)
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <button type="button" class="btn btn-primary-pro btn-block" id="agregarRolBtn">
                                        <i class="fas fa-plus mr-1"></i> Agregar
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Panel de Roles Seleccionados -->
                        <div class="mt-3 p-3 bg-light rounded border" id="rolesAgregadosPanel" style="min-height: 100px; display: none;">
                            <h6 class="mb-2">Roles Seleccionados:</h6>
                            <div id="rolesAgregadosList" class="d-flex flex-wrap gap-2"></div>
                        </div>
                        <input type="hidden" id="flujo_tipos_actores" name="tipos_actores[]" value="">
                    </div>

                </div>

                <div class="modal-footer border-top">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-2"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary-pro">
                        <i class="fas fa-save mr-2"></i> Crear Flujo
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Variables globales para almacenar personas y roles seleccionados
window.personasSeleccionadas = {};
window.rolesSeleccionados = {};

document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('createFlujoForm');
    
    // Botón para agregar personas
    const agregarPersonaBtn = document.getElementById('agregarPersonaBtn');
    if (agregarPersonaBtn) {
        agregarPersonaBtn.addEventListener('click', function(e) {
            e.preventDefault();
            const select = document.getElementById('flujo_personas_select');
            const personaId = select.value;
            
            if (!personaId) {
                alert('Por favor selecciona una persona');
                return;
            }
            
            const option = select.options[select.selectedIndex];
            const personaFullName = option.textContent.trim();
            
            // Verificar que no esté ya agregada
            if (window.personasSeleccionadas[personaId]) {
                alert('Esta persona ya ha sido agregada');
                return;
            }
            
            // Agregar a la lista
            window.personasSeleccionadas[personaId] = personaFullName;
            actualizarPanelPersonas();
            
            // Resetear dropdown
            select.value = '';
        });
    }
    
    // Botón para agregar roles
    const agregarRolBtn = document.getElementById('agregarRolBtn');
    if (agregarRolBtn) {
        agregarRolBtn.addEventListener('click', function(e) {
            e.preventDefault();
            const select = document.getElementById('flujo_tipos_actores_select');
            const rolId = select.value;
            
            if (!rolId) {
                alert('Por favor selecciona un rol');
                return;
            }
            
            const option = select.options[select.selectedIndex];
            const rolDescripcion = option.getAttribute('data-descripcion');
            
            // Verificar que no esté ya agregado
            if (window.rolesSeleccionados[rolId]) {
                alert('Este rol ya ha sido agregado');
                return;
            }
            
            // Agregar a la lista
            window.rolesSeleccionados[rolId] = rolDescripcion;
            actualizarPanelRoles();
            
            // Resetear dropdown
            select.value = '';
        });
    }
    
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (!form.checkValidity()) {
                e.stopPropagation();
                form.classList.add('was-validated');
                return;
            }

            // Validar fechas
            const fechaInicio = document.getElementById('flujo_fecha_inicio').value;
            const fechaFirma = document.getElementById('flujo_fecha_firma').value;
            
            if (fechaInicio && fechaFirma && new Date(fechaFirma) < new Date(fechaInicio)) {
                alert('La fecha de firma debe ser igual o posterior a la fecha de inicio del análisis');
                return;
            }

            const procesId = document.getElementById('createFlujModal').dataset.procesId;
            const formData = new FormData(form);
            
            // Agregar personas y roles seleccionados
            Object.keys(window.personasSeleccionadas).forEach(id => {
                formData.append('personas[]', id);
            });
            
            Object.keys(window.rolesSeleccionados).forEach(id => {
                formData.append('tipos_actores[]', id);
            });
            
            fetch(`/internal/procesos/${procesId}/flujos`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Limpiar form y cerrar modal
                    form.reset();
                    form.classList.remove('was-validated');
                    window.personasSeleccionadas = {};
                    window.rolesSeleccionados = {};
                    $('#createFlujModal').modal('hide');
                    
                    // Mostrar mensaje de éxito
                    showSuccessMessage(data.message);
                    
                    // Recargar la página después de 1.5 segundos
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Ocurrió un error al crear el flujo');
            });
        });
    }
});

function actualizarPanelPersonas() {
    const panel = document.getElementById('personasAgregadasPanel');
    const list = document.getElementById('personasAgregadasList');
    
    list.innerHTML = '';
    
    const personaBaseUrl = '{{ url("/internal/personas") }}/';
    const tipoActorBaseUrl = '{{ url("/internal/tipos-actores") }}/';

    Object.entries(window.personasSeleccionadas).forEach(([id, nombre]) => {
        const badge = document.createElement('a');
        badge.href = `${personaBaseUrl}${id}`;
        badge.target = '_blank';
        badge.className = 'badge badge-light border border-primary p-2';
        badge.style.textDecoration = 'none';
        badge.style.color = 'inherit';
        badge.innerHTML = `
            <i class="fas fa-user mr-1"></i>${nombre}
            <span class="ml-2" style="cursor: pointer;" onclick="event.preventDefault(); event.stopPropagation(); eliminarPersona('${id}')">
                <i class="fas fa-times" style="font-size: 0.8em;"></i>
            </span>
        `;
        list.appendChild(badge);
    });
    
    if (Object.keys(window.personasSeleccionadas).length > 0) {
        panel.style.display = 'block';
    } else {
        panel.style.display = 'none';
    }
}

function actualizarPanelRoles() {
    const panel = document.getElementById('rolesAgregadosPanel');
    const list = document.getElementById('rolesAgregadosList');
    
    list.innerHTML = '';
    
    Object.entries(window.rolesSeleccionados).forEach(([id, descripcion]) => {
        const badge = document.createElement('a');
        badge.href = `${tipoActorBaseUrl}${id}`;
        badge.target = '_blank';
        badge.className = 'badge badge-warning p-2';
        badge.style.textDecoration = 'none';
        badge.style.color = 'inherit';
        badge.innerHTML = `
            ${descripcion}
            <span class="ml-2" style="cursor: pointer;" onclick="event.preventDefault(); event.stopPropagation(); eliminarRol('${id}')">
                <i class="fas fa-times" style="font-size: 0.8em;"></i>
            </span>
        `;
        list.appendChild(badge);
    });
    
    if (Object.keys(window.rolesSeleccionados).length > 0) {
        panel.style.display = 'block';
    } else {
        panel.style.display = 'none';
    }
}

function eliminarPersona(id) {
    delete window.personasSeleccionadas[id];
    actualizarPanelPersonas();
}

function eliminarRol(id) {
    delete window.rolesSeleccionados[id];
    actualizarPanelRoles();
}
</script>
