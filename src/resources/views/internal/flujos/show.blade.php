<!-- Modal para ver detalles del flujo -->
<div class="modal fade" id="showFlujoModal" tabindex="-1" role="dialog" aria-labelledby="showFlujoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header border-bottom">
                <h5 class="modal-title" id="showFlujoModalLabel">
                    <i class="fas fa-stream text-primary mr-2"></i>
                    Detalles del Flujo
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                <!-- Contenido dinámico que será llenado por AJAX -->
                <div id="flujoContent">
                    <div class="text-center py-5">
                        <div class="spinner-border text-primary" role="status">
                            <span class="sr-only">Cargando...</span>
                        </div>
                        <p class="mt-3 text-muted">Cargando información del flujo...</p>
                    </div>
                </div>
            </div>

            <div class="modal-footer border-top">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times mr-2"></i> Cerrar
                </button>
                <button type="button" class="btn btn-primary-pro" id="editFlujBtn">
                    <i class="fas fa-pencil-alt mr-2"></i> Editar
                </button>
                <button type="button" class="btn btn-danger" id="deleteFlujBtn">
                    <i class="fas fa-trash mr-2"></i> Eliminar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para editar flujo -->
<div class="modal fade" id="editFlujoModal" tabindex="-1" role="dialog" aria-labelledby="editFlujoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header border-bottom">
                <h5 class="modal-title" id="editFlujoModalLabel">
                    <i class="fas fa-pencil-alt text-primary mr-2"></i>
                    Editar Flujo
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="editFlujoForm" class="needs-validation">
                @csrf
                @method('PUT')
                <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                    
                    <!-- Información Básica -->
                    <div class="mb-4">
                        <h6 class="text-primary mb-3">
                            <i class="fas fa-info-circle mr-2"></i>
                            Información Básica
                        </h6>

                        <div class="form-group">
                            <label for="edit_flujo_descripcion">Descripción <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_flujo_descripcion" name="descripcion" 
                                   placeholder="Descripción del flujo" required maxlength="255">
                            <small class="form-text text-muted">Máximo 255 caracteres</small>
                            <div class="invalid-feedback">Por favor ingresa una descripción</div>
                        </div>

                        <div class="form-group">
                            <label for="edit_flujo_tipo">Tipo de Flujo <span class="text-danger">*</span></label>
                            <select class="form-control" id="edit_flujo_tipo" name="tipo_flujo_id" required>
                                <option value="">-- Seleccionar --</option>
                                <!-- Opciones llenadas dinámicamente -->
                            </select>
                            <div class="invalid-feedback">Por favor selecciona un tipo de flujo</div>
                        </div>

                        <div class="form-group">
                            <label for="edit_flujo_observaciones">Observaciones</label>
                            <textarea class="form-control" id="edit_flujo_observaciones" name="observaciones" 
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
                                    <label for="edit_flujo_fecha_inicio">Fecha Inicio de Análisis</label>
                                    <input type="date" class="form-control" id="edit_flujo_fecha_inicio" 
                                           name="fecha_inicio_analisis">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_flujo_fecha_firma">Fecha Firma de Versión</label>
                                    <input type="date" class="form-control" id="edit_flujo_fecha_firma" 
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
                            <label for="edit_flujo_personas">Seleccionar Personas</label>
                            <select class="form-control" id="edit_flujo_personas" name="personas[]" multiple size="5">
                                <!-- Opciones llenadas dinámicamente -->
                            </select>
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle mr-1"></i>
                                Mantén Ctrl/Cmd presionado para seleccionar múltiples personas
                            </small>
                        </div>
                    </div>

                    <hr class="my-3">

                    <!-- Tipos de Actores (Roles) -->
                    <div class="mb-2">
                        <h6 class="text-primary mb-3">
                            <i class="fas fa-shield-alt mr-2"></i>
                            Roles/Tipos de Actores
                        </h6>

                        <div class="form-group">
                            <label for="edit_flujo_tipos_actores">Seleccionar Roles</label>
                            <select class="form-control" id="edit_flujo_tipos_actores" name="tipos_actores[]" multiple size="5">
                                <!-- Opciones llenadas dinámicamente -->
                            </select>
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle mr-1"></i>
                                Mantén Ctrl/Cmd presionado para seleccionar múltiples roles
                            </small>
                        </div>
                    </div>

                </div>

                <div class="modal-footer border-top">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-2"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary-pro">
                        <i class="fas fa-save mr-2"></i> Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const editForm = document.getElementById('editFlujoForm');
    
    if (editForm) {
        editForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (!editForm.checkValidity()) {
                e.stopPropagation();
                editForm.classList.add('was-validated');
                return;
            }

            // Validar fechas
            const fechaInicio = document.getElementById('edit_flujo_fecha_inicio').value;
            const fechaFirma = document.getElementById('edit_flujo_fecha_firma').value;
            
            if (fechaInicio && fechaFirma && new Date(fechaFirma) < new Date(fechaInicio)) {
                alert('La fecha de firma debe ser igual o posterior a la fecha de inicio del análisis');
                return;
            }

            const flujoId = editForm.dataset.flujoId;
            const procesId = editForm.dataset.procesId;
            const formData = new FormData(editForm);
            
            fetch(`/internal/procesos/${procesId}/flujos/${flujoId}`, {
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
                    editForm.reset();
                    editForm.classList.remove('was-validated');
                    $('#editFlujoModal').modal('hide');
                    $('#showFlujoModal').modal('hide');
                    
                    showSuccessMessage(data.message);
                    
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Ocurrió un error al actualizar el flujo');
            });
        });
    }
});

// Cargar detalles del flujo
function loadFlujoDetails(procesId, flujoId) {
    fetch(`/internal/procesos/${procesId}/flujos/${flujoId}`, {
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        displayFlujoDetails(data);
    })
    .catch(error => console.error('Error:', error));
}

function displayFlujoDetails(flujo) {
    const html = `
        <div class="flujo-details">
            <div class="mb-4">
                <h6 class="text-muted small">Descripción</h6>
                <p class="h5">${flujo.descripcion}</p>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <h6 class="text-muted small">Tipo de Flujo</h6>
                    <span class="badge badge-info p-2">${flujo.tipo_flujo}</span>
                </div>
                <div class="col-md-6">
                    <h6 class="text-muted small">Estado</h6>
                    <span class="badge badge-secondary p-2">Activo</span>
                </div>
            </div>

            ${flujo.observaciones ? `
                <div class="mb-3">
                    <h6 class="text-muted small">Observaciones</h6>
                    <p>${flujo.observaciones}</p>
                </div>
            ` : ''}

            <hr>

            <div class="row mb-3">
                <div class="col-md-6">
                    <h6 class="text-muted small">Fecha Inicio de Análisis</h6>
                    <p>${flujo.fecha_inicio_analisis || 'No especificada'}</p>
                </div>
                <div class="col-md-6">
                    <h6 class="text-muted small">Fecha Firma de Versión</h6>
                    <p>${flujo.fecha_firma_version || 'No especificada'}</p>
                </div>
            </div>

            <hr>

            ${flujo.personas && flujo.personas.length > 0 ? `
                <div class="mb-3">
                    <h6 class="text-muted small mb-2">
                        <i class="fas fa-users mr-1"></i>
                        Personas Involucradas (${flujo.personas.length})
                    </h6>
                    <div class="d-flex flex-wrap gap-2">
                        ${flujo.personas.map(p => 
                            `<span class="badge badge-light border border-primary p-2">
                                <i class="fas fa-user mr-1"></i>${p}
                            </span>`
                        ).join('')}
                    </div>
                </div>
            ` : ''}

            ${flujo.tipos_actores && flujo.tipos_actores.length > 0 ? `
                <div class="mb-2">
                    <h6 class="text-muted small mb-2">
                        <i class="fas fa-shield-alt mr-1"></i>
                        Roles/Tipos de Actores (${flujo.tipos_actores.length})
                    </h6>
                    <div class="d-flex flex-wrap gap-2">
                        ${flujo.tipos_actores.map(r => 
                            `<span class="badge badge-warning p-2">${r}</span>`
                        ).join('')}
                    </div>
                </div>
            ` : ''}
        </div>
    `;

    document.getElementById('flujoContent').innerHTML = html;
    
    // Guardar datos en el formulario de edición y botones
    const procesId = document.getElementById('showFlujoModal').dataset.procesId;
    document.getElementById('editFlujBtn').dataset.flujoId = flujo.id;
    document.getElementById('editFlujBtn').dataset.procesId = procesId;
    document.getElementById('deleteFlujBtn').dataset.flujoId = flujo.id;
    document.getElementById('deleteFlujBtn').dataset.procesId = procesId;
}

// Borrar flujo
function deleteFlujo(procesId, flujoId) {
    if (!confirm('¿Estás seguro de que deseas eliminar este flujo? Esta acción no se puede deshacer.')) {
        return;
    }

    fetch(`/internal/procesos/${procesId}/flujos/${flujoId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            $('#showFlujoModal').modal('hide');
            $('#editFlujoModal').modal('hide');
            
            showSuccessMessage(data.message);
            
            setTimeout(() => {
                window.location.reload();
            }, 1500);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Ocurrió un error al eliminar el flujo');
    });
}
</script>
