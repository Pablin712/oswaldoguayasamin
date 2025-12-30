import './bootstrap';
import './enhanced-table';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// Inicializar Select2 para todos los selects con clase searchable-select
document.addEventListener('DOMContentLoaded', function() {
    // Función para inicializar Select2
    function initializeSearchableSelects() {
        const selects = document.querySelectorAll('.searchable-select');

        if (typeof jQuery !== 'undefined' && typeof jQuery.fn.select2 !== 'undefined') {
            selects.forEach(select => {
                const $select = jQuery(select);

                // No reinicializar si ya tiene Select2
                if ($select.hasClass('select2-hidden-accessible')) {
                    return;
                }

                const options = {
                    theme: 'default',
                    width: '100%',
                    placeholder: select.dataset.placeholder || 'Seleccione una opción',
                    allowClear: select.dataset.allowClear === 'true'
                };

                // Agregar dropdownParent si está especificado
                if (select.dataset.dropdownParent) {
                    options.dropdownParent = jQuery(select.dataset.dropdownParent);
                }

                $select.select2(options);
            });
        }
    }

    // Inicializar en carga
    initializeSearchableSelects();

    // Reinicializar cuando se abran modales
    window.addEventListener('open-modal', function() {
        setTimeout(initializeSearchableSelects, 100);
    });

    // Observar cambios en el DOM para detectar nuevos selects
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.addedNodes.length) {
                initializeSearchableSelects();
            }
        });
    });

    observer.observe(document.body, {
        childList: true,
        subtree: true
    });
});
