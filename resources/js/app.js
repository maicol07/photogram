import autoAnimate from '@formkit/auto-animate';

import {getAllMDCInstances, initSingleComponent, mdcInit} from './mdc.js';

function domTraversal(parentElement, callback) {
  for (const element of parentElement.children) {
    callback(element);
    if (element.hasChildNodes()) {
      domTraversal(element, callback);
    }
  }
}

document.addEventListener('DOMContentLoaded', () => {
  mdcInit();
  Livewire.hook('element.updated', () => {
    for (const [, instance] of Object.entries(getAllMDCInstances())) {
      /** @var {MDCComponent} instance */
      if (typeof instance.layout === 'function') {
        instance.layout();

        if (instance.value && instance.label) {
          /** @var {MDCFloatingLabel} instance.label */
          instance.label.float(true);
        }
      }
    }
  });

  window.mdc.snackbar['message-snackbar']?.open();

  Livewire.hook('message.processed', (message, component) => {
    domTraversal(component.el, (element) => {
      // Update MDC components
      if (!(element.id in getAllMDCInstances())) {
        initSingleComponent(element);
      }
    });

    const {errors} = message.response.serverMemo;
    if (errors) {
      for (const [id, instance] of Object.entries(getAllMDCInstances())) {
        const modelProperty = instance.root.getAttribute('wire:model');
        const error = errors[id] ?? errors[modelProperty] ?? undefined;

        instance.valid = error === undefined;
        instance.helperTextContent = error ?? '';

        const form = instance.root.closest('form');
        if (form) {
          const formInputs = form.querySelectorAll('input');
          const formHasError = [...formInputs].map((input) => input.id || input.name)
            .some((inputId) => inputId in errors);
          const formSubmitButton = form.querySelector('button[type="submit"]');

          if (formSubmitButton) {
            formSubmitButton.disabled = formHasError;
            formSubmitButton.ariaDisabled = formHasError;
          }
        }
      }
    }
  });

  for (const element of document.querySelectorAll('[data-autoanimate]')) {
    autoAnimate(element);
  }
});
