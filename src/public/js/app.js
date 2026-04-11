/**
 * app.js
 * Dark / Light mode toggle – persiste preferencia en localStorage.
 * Sincroniza el checkbox con el estado aplicado en <body> desde el layout.
 */
(function () {
    'use strict';

    const STORAGE_KEY = 'theme';
    const DARK_CLASS  = 'dark-mode';

    document.addEventListener('DOMContentLoaded', function () {
        const toggle = document.getElementById('darkModeSwitch');
        const body   = document.getElementById('app-body');

        if (!toggle || !body) return;

        // Sincronizar el checkbox con el estado actual del body
        // (ya fue aplicado por el inline script del layout)
        toggle.checked = body.classList.contains(DARK_CLASS);

        // Escuchar cambios del toggle
        toggle.addEventListener('change', function () {
            body.classList.toggle(DARK_CLASS, this.checked);
            try {
                localStorage.setItem(STORAGE_KEY, this.checked ? 'dark' : 'light');
            } catch (e) {
                // localStorage no disponible (modo privado muy restringido)
            }
        });
    });
})();
