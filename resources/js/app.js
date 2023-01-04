import {MDCDialog} from '@material/dialog';
import {MDCRipple} from '@material/ripple';
import {MDCSnackbar} from '@material/snackbar';
import {MDCTextField} from '@material/textfield';
import {MDCSelect} from '@material/select';

/**
 * @typedef {typeof import('@material/base/component').MDCComponent} MDCComponent
 */

/**
 * @typedef {function} mdcBeforeInitCallback
 *   @param {HTMLElement} element The element the component is attached to
 */

/**
 * @typedef {function} mdcAfterInitCallback
 *   @param {HTMLElement} element The element the component is attached to
 *   @param {MDCComponent} instance The component instance
 */

/**
 * @typedef {Readonly<Object>} mdcComponentDefinition
 *   @property {?string} slug The component slug/category
 *   @property {?MDCComponent} component The component class
 *   @property {?mdcBeforeInitCallback[]} beforeInit A function to run before initializing the component
 *   @property {string|mdcAfterInitCallback[]} afterInit A function to run after initializing the component.
 */

/**
 * @type {Readonly<Object<string, Readonly<Object<string, MDCComponent>>>>}
 */
window.mdc = {
  dialog: {},
  ripple: {},
  select: {},
  snackbar: {},
  textField: {}
};

/**
 * Material Design Components definitions
 *
 * @type {Object.<string, mdcComponentDefinition>}
 */
window.mdcComponentsDefinitions = {
  '.mdc-button, .mdc-icon-button, .mdc-card__primary-action, .mdc-fab, .mdc-chip__ripple, .mdc-list-item': {
    slug: 'ripple',
    component: MDCRipple,
    /**
     * @param element A button element
     * @param {MDCRipple} instance The ripple instance
     */
    afterInit: [
      (element, instance) => {
        instance.unbounded = element.classList.contains('.mdc-icon-button');
      }]
  },
  '.mdc-text-field': {
    slug: 'textField',
    component: MDCTextField,
    afterInit: []
  },
  '.mdc-text-field .mdc-floating-label': {
    afterInit: '.mdc-text-field'
  },
  '.mdc-select': {
    slug: 'select',
    component: MDCSelect,
    afterInit: [
      /**
       *
       * @param element
       * @param {MDCSelect} instance
       */
      (element, instance) => {
        element.addEventListener(
          'MDCSelect:change',
          /**
           * @param {import('@material/select').MDCSelectEvent} event
           */
          (event) => {
            event.target.querySelector('input')
              .dispatchEvent(new InputEvent('input', {data: event.detail.value}));
          }
        );
      }
    ],
  },
  '.mdc-snackbar': {
    slug: 'snackbar',
    component: MDCSnackbar,
    afterInit: [
      /**
       * @param {HTMLElement} element The snackbar element
       * @param {MDCSnackbar} instance The snackbar instance
       */
      (element, instance) => {
        if (element.dataset.open === undefined) {
          instance.close();
        } else {
          instance.open();
        }
      }]
  },
  '.mdc-dialog': {
    slug: 'dialog',
    component: MDCDialog,
    afterInit: [
      /**
       * @param {HTMLElement} element The dialog element
       * @param {MDCDialog} instance The dialog instance
       */
      (element, instance) => {
        if (element.dataset.open === undefined) {
          instance.close();
        } else {
          instance.open();
        }
      }],
  }
};

/**
 * Initialize a Material Design Component
 *
 * @param {HTMLElement} element The HTML element to initialize
 */
function mdcInit(element) {
  const matchingDefinitions = Object.entries(window.mdcComponentsDefinitions)
    .filter(([selector]) => element.matches(selector));

  for (const [, {
    slug,
    component,
    beforeInit,
    afterInit
  }] of matchingDefinitions) {
    if (beforeInit) {
      beforeInit(element);
    }

    let instance;
    if (component) {
      instance = component.attachTo(element);
      window.mdc[slug][element.id] = instance;
    }

    let callbacks = afterInit;

    // If the afterInit is a string, it is a selector. Call the afterInit function of that selector.
    if (typeof afterInit === 'string') {
      callbacks = mdcComponentsDefinitions[afterInit].afterInit;
    }

    if (Array.isArray(callbacks)) {
      for (const callback of callbacks) {
        callback(element, instance);
      }
    }
  }
}

Livewire.hook('element.initialized', (element) => mdcInit(element));
Livewire.hook('element.updated', () => {
  let mdc = {};
  for (const component of Object.values(window.mdc)) {
    mdc = {...mdc, ...component};
  }

  for (const [, instance] of Object.entries(mdc)) {
    /** @var {MDCComponent} instance */
    if (typeof instance.layout === 'function') {
      instance.layout();

      if (instance.value !== undefined && instance.label) {
        /** @var {MDCFloatingLabel} instance.label */
        instance.label.float(true);
      }
    }
  }
});
