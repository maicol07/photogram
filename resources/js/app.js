import {getAllMDCInstances, mdcInit} from './mdc.js';

Livewire.hook('element.initialized', (element) => mdcInit(element));
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
    for (const [name, error] of Object.entries(errors)) {
      const c = window.mdc.textField[name];
      if (c instanceof MDCTextField) {
        c.valid = false;
        c.helperTextContent = error;
      }
    }
  }
});

/**
 * Open or close an MDC component (mainly a snackbar or a dialog)
 *
 * @param {string} slug
 * @param {string} id
 * @param {'open'|'close'} actionType
 * @param {?string} action
 * @param {?message} message
 */
function openCloseComponent(slug, id, actionType, action, message) {
  /** @type {?MDCComponent} */
  const component = window.mdc[slug][id] ?? undefined;
  if (component) {
    component[actionType](action);
    if (message && component.labelText !== undefined) {
      component.labelText = message;
    }
  }
}

/**
 * Open or close an MDC component (mainly a snackbar or a dialog) from a Livewire event
 *
 * @param {string} slug
 * @param {CustomEvent<{id: string, action?: string}>} event
 * @param {'open'|'close'} actionType
 */
function openCloseComponentFromEvent(slug, event, actionType) {
  const {id, action, message} = event.detail;
  openCloseComponent(slug, id, actionType, action, message);
}

window.addEventListener('MDCDialog::open', (event) => openCloseComponentFromEvent('dialog', event, 'open'));
window.addEventListener('MDCDialog::close', (event) => openCloseComponentFromEvent('dialog', event, 'close'));
window.addEventListener('MDCSnackbar::open', (event) => openCloseComponentFromEvent('snackbar', event, 'open'));
window.addEventListener('MDCSnackbar::close', (event) => openCloseComponentFromEvent('snackbar', event, 'close'));
