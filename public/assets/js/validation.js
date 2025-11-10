class ValidationErrorFilter {
    constructor(prefix = "") {
        this.prefix = prefix;
    }

    filterValidationErrors(responseData) {
        if (!responseData?.errors) return [];

        Object.entries(responseData.errors).forEach(([key, messages]) => {
            this._showError(key, messages);
        });

        return Object.values(responseData.errors).flat();
    }

    _showError(fieldName, messages) {
        const field = this._findField(fieldName);
        if (!field) {
            console.error(`Field not found: ${fieldName}`);
            return;
        }

        const errorText = Array.isArray(messages) ? messages[0] : messages;

        // Clear existing errors
        this._clearField(field);

        // Show error message
        const errorContainer = this._getErrorContainer(field);
        if (errorContainer) {
            errorContainer.innerHTML = errorText;
            errorContainer.style.display = 'block';
            errorContainer.classList.remove('d-none');
        }

        // Add validation styling
        this._styleField(field, true);

        // Add clear listener
        this._addClearListener(field);
    }

    _findField(key) {
        const name = this.prefix + key;
        return document.getElementById(name) ||
            document.querySelector(`[name="${name}"]`);
    }

    _getErrorContainer(field) {
        const parent = field.closest('.d-flex') || field.parentNode;

        let container = parent.querySelector('.invalid-feedback');

        if (!container) {
            container = document.createElement('div');
            container.className = 'invalid-feedback';

            const insertAfter = field.classList.contains('select2-hidden-accessible')
                ? field.nextElementSibling
                : field.classList.contains('flatpickr-input') && field.nextElementSibling?.classList.contains('flatpickr-altInput')
                    ? field.nextElementSibling
                    : field;

            insertAfter.parentNode.insertBefore(container, insertAfter.nextSibling);
        }

        return container;
    }

    _styleField(field, isError) {
        if (isError) {
            field.classList.add('is-invalid');
            field.classList.remove('is-valid');

            if (field.classList.contains('select2-hidden-accessible')) {
                const select2 = field.nextElementSibling?.querySelector('.select2-selection');
                if (select2) {
                    select2.classList.add('is-invalid');
                }
            }

            if (field.classList.contains('flatpickr-input')) {
                const altInput = field.nextElementSibling;
                if (altInput?.classList.contains('flatpickr-altInput')) {
                    altInput.classList.add('is-invalid');
                }
            }
        } else {
            field.classList.remove('is-invalid', 'is-valid');

            if (field.classList.contains('select2-hidden-accessible')) {
                const select2 = field.nextElementSibling?.querySelector('.select2-selection');
                if (select2) {
                    select2.classList.remove('is-invalid');
                }
            }

            if (field.classList.contains('flatpickr-input')) {
                const altInput = field.nextElementSibling;
                if (altInput?.classList.contains('flatpickr-altInput')) {
                    altInput.classList.remove('is-invalid');
                }
            }
        }
    }

    _addClearListener(field) {
        const clearError = () => this._clearField(field);

        field.removeEventListener('input', clearError);
        field.removeEventListener('change', clearError);
        field.addEventListener('input', clearError, {once: false});
        field.addEventListener('change', clearError, {once: false});

        if (field.classList.contains('select2-hidden-accessible')) {
            $(field).off('select2:select.validation select2:unselect.validation')
                .on('select2:select.validation select2:unselect.validation', clearError);
        }
    }

    _clearField(field) {
        this._styleField(field, false);
        const parent = field.closest('.d-flex') || field.parentNode;
        const containers = parent.querySelectorAll('.invalid-feedback, .text-danger, [data-field]');

        containers.forEach(container => {
            container.style.display = 'none';
            container.innerHTML = '';
            container.classList.add('d-none');
        });
    }

    clearAllErrors() {
        document.querySelectorAll('.is-invalid').forEach(el => {
            this._clearField(el);
        });
    }

    logErrors() {
        console.log('ValidationErrorFilter: Use browser dev tools to inspect validation errors');
    }
}

// Global helpers
window.ValidationErrorFilter = ValidationErrorFilter;

window.clearAllValidationErrors = function (formSelector = null) {
    const scope = formSelector ? document.querySelector(formSelector) : document;
    if (!scope) return;

    scope.querySelectorAll('.is-invalid').forEach(el => {
        el.classList.remove('is-invalid', 'is-valid');
    });

    scope.querySelectorAll('.invalid-feedback, .text-danger').forEach(el => {
        el.style.display = 'none';
        el.innerHTML = '';
        el.classList.add('d-none');
    });

    // Clear Select2 styling
    scope.querySelectorAll('.select2-selection.is-invalid').forEach(el => {
        el.classList.remove('is-invalid');
    });
};