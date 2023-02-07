import {getAllMDCInstances, mdcInit} from './mdc.js';

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

  Livewire.hook('message.processed', (message) => {
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
          const formHasError = [...formInputs].map((input) => input.id)
            .every((inputId) => inputId in errors);
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
