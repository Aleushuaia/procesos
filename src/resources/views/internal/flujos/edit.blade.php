<!-- Este archivo es para mantener consistencia, pero es principalmente procesado por AJAX -->
<div class="modal fade" id="editFlujoModalForm" tabindex="-1" role="dialog" aria-labelledby="editFlujoModalLabel" aria-hidden="true">
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

            <form id="editFlujoFormContent" class="needs-validation">
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
