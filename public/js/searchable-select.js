// Searchable Select - Select2 Initializer
(function() {
    'use strict';

    // Función para inicializar Select2
    function initializeSearchableSelects() {
        // Verificar que jQuery y Select2 estén disponibles
        if (typeof jQuery === 'undefined') {
            console.warn('jQuery no está disponible. Select2 requiere jQuery.');
            return;
        }

        if (typeof jQuery.fn.select2 === 'undefined') {
            console.warn('Select2 no está disponible. Verifica que select2.js esté cargado.');
            return;
        }

        const selects = document.querySelectorAll('.searchable-select');

        selects.forEach(select => {
            const $select = jQuery(select);

            // No reinicializar si ya tiene Select2
            if ($select.hasClass('select2-hidden-accessible')) {
                return;
            }

            // Configuración de Select2
            const options = {
                theme: 'default',
                width: '100%',
                placeholder: select.dataset.placeholder || select.getAttribute('placeholder') || 'Seleccione...',
                allowClear: select.dataset.allowClear !== 'false',
                language: {
                    noResults: function() {
                        return "No se encontraron resultados";
                    },
                    searching: function() {
                        return "Buscando...";
                    },
                    loadingMore: function() {
                        return "Cargando más resultados...";
                    }
                }
            };

            // Agregar dropdownParent si está especificado (importante para modales)
            if (select.dataset.dropdownParent) {
                const parent = document.querySelector(select.dataset.dropdownParent);
                if (parent) {
                    options.dropdownParent = jQuery(select.dataset.dropdownParent);
                }
            }

            // Inicializar Select2
            $select.select2(options);
        });
    }

    // Inicializar cuando el DOM esté listo
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initializeSearchableSelects);
    } else {
        initializeSearchableSelects();
    }

    // Reinicializar cuando se abran modales (Alpine.js)
    window.addEventListener('open-modal', function() {
        setTimeout(initializeSearchableSelects, 100);
    });

    // Observar cambios en el DOM para detectar nuevos selects
    const observer = new MutationObserver(function(mutations) {
        let shouldReinitialize = false;

        mutations.forEach(function(mutation) {
            if (mutation.addedNodes.length) {
                mutation.addedNodes.forEach(function(node) {
                    if (node.nodeType === 1) { // Element node
                        if (node.classList && node.classList.contains('searchable-select')) {
                            shouldReinitialize = true;
                        } else if (node.querySelector && node.querySelector('.searchable-select')) {
                            shouldReinitialize = true;
                        }
                    }
                });
            }
        });

        if (shouldReinitialize) {
            setTimeout(initializeSearchableSelects, 50);
        }
    });

    observer.observe(document.body, {
        childList: true,
        subtree: true
    });

    // Exponer función globalmente para uso manual si es necesario
    window.initializeSearchableSelects = initializeSearchableSelects;
})();
