/**
 * Flujo Manager - Funciones para gestión de flujos en modales
 */

(function() {
    'use strict';

    // Objeto global para gestionar flujos
    window.FlujoManager = {
        
        /**
         * Validar fechas - Asegurar que fecha_firma_version >= fecha_inicio_analisis
         */
        validateDates: function(startDate, endDate) {
            if (startDate && endDate) {
                const start = new Date(startDate);
                const end = new Date(endDate);
                if (end < start) {
                    return {
                        valid: false,
                        message: 'La fecha de firma debe ser igual o posterior a la fecha de inicio del análisis'
                    };
                }
            }
            return { valid: true };
        },

        /**
         * Validar formulario básico
         */
        validateForm: function(form) {
            let isValid = true;
            const errors = [];

            // Validar descripción
            const descripcion = form.querySelector('[name="descripcion"]');
            if (!descripcion.value.trim()) {
                errors.push('La descripción es requerida');
                isValid = false;
            } else if (descripcion.value.length > 255) {
                errors.push('La descripción no puede exceder 255 caracteres');
                isValid = false;
            }

            // Validar tipo de flujo
            const tipoFlujo = form.querySelector('[name="tipo_flujo_id"]');
            if (!tipoFlujo.value) {
                errors.push('El tipo de flujo es requerido');
                isValid = false;
            }

            // Validar observaciones
            const observaciones = form.querySelector('[name="observaciones"]');
            if (observaciones && observaciones.value.length > 1000) {
                errors.push('Las observaciones no pueden exceder 1000 caracteres');
                isValid = false;
            }

            // Validar fechas
            const fechaInicio = form.querySelector('[name="fecha_inicio_analisis"]');
            const fechaFirma = form.querySelector('[name="fecha_firma_version"]');
            
            if (fechaInicio && fechaFirma && fechaInicio.value && fechaFirma.value) {
                const dateValidation = this.validateDates(fechaInicio.value, fechaFirma.value);
                if (!dateValidation.valid) {
                    errors.push(dateValidation.message);
                    isValid = false;
                }
            }

            return {
                valid: isValid,
                errors: errors
            };
        },

        /**
         * Mostrar errores de validación
         */
        showErrors: function(errors) {
            if (errors.length === 0) return;

            let errorHtml = '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
            errorHtml += '<strong>Por favor corrige los siguientes errores:</strong><br>';
            errors.forEach(error => {
                errorHtml += `<i class="fas fa-times-circle mr-1"></i>${error}<br>`;
            });
            errorHtml += '<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>';
            errorHtml += '</div>';

            // Insertar al inicio del modal
            const modal = document.querySelector('.modal.show .modal-body');
            if (modal) {
                const alertContainer = document.createElement('div');
                alertContainer.innerHTML = errorHtml;
                const firstChild = modal.firstChild;
                modal.insertBefore(alertContainer, firstChild);
            }
        },

        /**
         * Limpiar errores previos
         */
        clearErrors: function(form) {
            const alertContainer = form.querySelector('.alert-danger');
            if (alertContainer) {
                alertContainer.remove();
            }
        },

        /**
         * Mostrar mensaje de éxito
         */
        showSuccess: function(message) {
            if (typeof toastr !== 'undefined') {
                toastr.success(message);
            } else {
                // Fallback simple
                const alertHtml = `
                    <div class="alert alert-success alert-dismissible fade show position-fixed" style="top: 20px; right: 20px; z-index: 9999;">
                        <i class="fas fa-check-circle mr-2"></i>${message}
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                    </div>
                `;
                document.body.insertAdjacentHTML('beforeend', alertHtml);
                
                setTimeout(() => {
                    const alert = document.querySelector('.alert.alert-success');
                    if (alert) alert.remove();
                }, 5000);
            }
        },

        /**
         * Mostrar error
         */
        showError: function(message) {
            if (typeof toastr !== 'undefined') {
                toastr.error(message);
            } else {
                alert(message);
            }
        },

        /**
         * Escapar HTML para prevenir XSS
         */
        escapeHtml: function(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        },

        /**
         * Formatear fecha para mostrar
         */
        formatDate: function(dateString) {
            if (!dateString) return '-';
            const date = new Date(dateString);
            return date.toLocaleDateString('es-ES', {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
        },

        /**
         * Cargar opciones dinámicamente en selects
         */
        loadSelectOptions: function(selectElement, options, selectedIds = []) {
            selectElement.innerHTML = '';
            options.forEach(option => {
                const optionElement = document.createElement('option');
                optionElement.value = option.id;
                optionElement.textContent = option.text;
                if (selectedIds.includes(option.id.toString())) {
                    optionElement.selected = true;
                }
                selectElement.appendChild(optionElement);
            });
        }
    };

    // Event listeners para inicialización
    document.addEventListener('DOMContentLoaded', function() {
        
        // Inicializar validación de formularios
        const forms = document.querySelectorAll('form.needs-validation');
        forms.forEach(form => {
            form.addEventListener('submit', function(event) {
                // Ejecutar validación personalizada
                const validation = window.FlujoManager.validateForm(this);
                
                if (!validation.valid) {
                    event.preventDefault();
                    event.stopPropagation();
                    window.FlujoManager.clearErrors(this);
                    window.FlujoManager.showErrors(validation.errors);
                }
                
                this.classList.add('was-validated');
            }, false);
        });

        // Validación de fechas en tiempo real
        const dateInputs = document.querySelectorAll('input[type="date"]');
        dateInputs.forEach(input => {
            input.addEventListener('change', function() {
                const form = this.closest('form');
                if (form) {
                    const startInput = form.querySelector('[name="fecha_inicio_analisis"]');
                    const endInput = form.querySelector('[name="fecha_firma_version"]');
                    
                    if (startInput && endInput && startInput.value && endInput.value) {
                        const validation = window.FlujoManager.validateDates(startInput.value, endInput.value);
                        if (!validation.valid) {
                            endInput.classList.add('is-invalid');
                            const feedback = endInput.nextElementSibling || document.createElement('div');
                            if (!feedback.classList.contains('invalid-feedback')) {
                                feedback.classList.add('invalid-feedback');
                                feedback.textContent = validation.message;
                                endInput.parentElement.appendChild(feedback);
                            }
                        } else {
                            endInput.classList.remove('is-invalid');
                        }
                    }
                }
            });
        });
    });

})();

// Función global para mostrar mensaje de éxito (usada en otros archivos)
function showSuccessMessage(message) {
    window.FlujoManager.showSuccess(message);
}
