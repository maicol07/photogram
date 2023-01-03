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
    afterInit: [
      /**
       *
       * @param element
       * @param {?MDCTextField} instance
       */
      (element, instance) => {
        // const textField = element.classList.contains('mdc-text-field') ? element : element.closest('.mdc-text-field');
        // if (textField.querySelector('input, textarea')?.value) {
        //   if (element.classList.contains('mdc-text-field')) {
        //     element.classList.add('mdc-text-field--label-floating');
        //   } else if (element.classList.contains('mdc-floating-label')) {
        //     element.classList.add('mdc-notched-outline--notched');
        //   } else if (element.classList.contains('mdc-line-ripple') && document.activeElement === textField.querySelector('input, textarea')) {
        //     element.classList.add('mdc-line-ripple--active');
        //   }
        // }
        // instance?.layout();
        // if (document.activeElement === textField.querySelector('input, textarea')) {
        //   textField.querySelector('.mdc-line-ripple')?.classList.add('mdc-line-ripple--active');
        // }
      }]
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
       * @param {?MDCSelect} instance
       */
      (element, instance) => {
        instance.listen('MDCSelect:change',
          /**
           * @param {import('@material/select').MDCSelectEvent} event
           */
          (event) => {
            event.target.querySelector('input').dispatchEvent(new InputEvent('input', {data: event.detail.value}));
          }
        );
      }
    ],
    // afterInit: (element) => {
    // if (element.parentElement.querySelector('select')?.value) {
    //   element.classList.add('mdc-select--filled');
    // }
    // }
  },
  '.mdc-snackbar': {
    slug: 'snackbar',
    component: MDCSnackbar,
    /**
     * @param {HTMLElement} element The snackbar element
     * @param {MDCSnackbar} instance The snackbar instance
     */
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
  for (const [selector, {
    slug,
    component,
    beforeInit,
    afterInit
  }] of Object.entries(mdcComponentsDefinitions)) {
    if (element.matches(selector)) {
      if (beforeInit) {
        beforeInit(element);
      }

      let instance;
      if (component) {
        instance = component.attachTo(element);
        window.mdc[slug][element.id] = instance;
      }

      if (afterInit) {
        // If the afterInit is a string, it is a selector. Call the afterInit function of that selector.
        if (typeof afterInit === 'string') {
          for (const callback of mdcComponentsDefinitions[afterInit].afterInit) {
            callback(element, instance);
          }
        } else {
          for (const callback of afterInit) {
            callback(element, instance);
          }
        }
      }
    }
  }
}

Livewire.hook('element.initialized', (element) => mdcInit(element));
Livewire.hook('element.updated', (element) => {
  for (const [id, instance] of Object.entries({...window.mdc.textField, ...window.mdc.select, ...window.mdc.snackbar, ...window.mdc.dialog})) {
    if (id !== 'language' && instance instanceof MDCTextField || instance instanceof MDCSelect || instance instanceof MDCSnackbar || instance instanceof MDCDialog) {
      instance.layout();
    }
  }
});
