import {MDCDialog} from '@material/dialog';
import {MDCFloatingLabel} from '@material/floating-label';
import {MDCRipple} from '@material/ripple';
import {MDCSelect} from '@material/select';
import {MDCSnackbar} from '@material/snackbar';
import {MDCTextField} from '@material/textfield';
import {MDCTextFieldHelperText} from '@material/textfield/helper-text';
import {MDCFormField} from '@material/form-field';
import {MDCCheckbox} from '@material/checkbox';
import {MDCTextFieldCharacterCounter} from '@material/textfield/character-counter';
import {MDCTopAppBar} from '@material/top-app-bar';


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
  textField: {},
  characterCounter: {},
  helperText: {},
  formField: {},
  checkbox: {},
  topAppBar: {}
};

/**
 * @returns {Readonly<Object<string, MDCComponent>>}
 */
export function getAllMDCInstances() {
  let mdc = {};
  for (const component of Object.values(window.mdc)) {
    mdc = {...mdc, ...component};
  }
  return mdc;
}

/**
 * Material Design Components definitions
 *
 * @type {Object.<string, mdcComponentDefinition>}
 */
window.mdcComponentsDefinitions = {
  '.mdc-button, .mdc-icon-button, .mdc-card__primary-action, .mdc-fab, .mdc-chip__ripple, .mdc-deprecated-list-item': {
    slug: 'ripple',
    component: MDCRipple,
    /**
     * @param element A button element
     * @param {MDCRipple} instance The ripple instance
     */
    afterInit: [
      (element, instance) => {
        instance.unbounded = element.classList.contains('mdc-icon-button');
      }]
  },
  '.mdc-text-field': {
    slug: 'textField',
    component: MDCTextField,
    afterInit: []
  },
  '.mdc-text-field-character-counter': {
    slug: 'characterCounter',
    component: MDCTextFieldCharacterCounter,
    afterInit: [
      /**
       * @param element
       * @param {MDCTextFieldCharacterCounter} instance
       */
      (element, instance) => {
        // "0 / 140"
        const textField = element.closest('label.mdc-text-field');
        const {id} = textField;
        /** @type {{value: string}} */
        const {value} = window.mdc.textField[id];
        const characterCounter = element.textContent.split(' / ');
        characterCounter[0] = value.length;
        element.textContent = characterCounter.join(' / ');
      }
    ]
  },
  '.mdc-text-field .mdc-floating-label': {
    afterInit: '.mdc-text-field'
  },
  '.mdc-select': {
    slug: 'select',
    component: MDCSelect,
    afterInit: [
      /**
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
  },
  '.mdc-text-field-helper-text': {
    slug: 'helperText',
    component: MDCTextFieldHelperText,
  },
  '.mdc-form-field': {
    slug: 'formField',
    component: MDCFormField,
  },
  '.mdc-checkbox': {
    slug: 'checkbox',
    component: MDCCheckbox,
    afterInit: [
      /**
       * @param {HTMLElement} element The checkbox element
       * @param {MDCCheckbox} instance The checkbox instance
       */
      (element, instance) => {
        const parent = element.closest('.mdc-form-field');
        window.mdc.formField[parent.id].input = instance;
      }
    ],
  },
  '.mdc-top-app-bar': {
    slug: 'top-app-bar',
    component: 'MDCTopAppBar',
  }
};

/**
 * Initialize a Material Design Component
 *
 * @param {HTMLElement} element The HTML element to initialize
 * @param {?Object<string, mdcComponentDefinition>} componentDefinitions
 */
export function initSingleComponent(element, componentDefinitions) {
  const matchingDefinitions = Object.entries(componentDefinitions) ?? Object.entries(window.mdcComponentsDefinitions)
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

export function mdcInit() {
  for (const [selector, componentDefinition] of Object.entries(window.mdcComponentsDefinitions)) {
    const elements = document.querySelectorAll(selector);

    for (const element of elements) {
      initSingleComponent(element, {[selector]: componentDefinition});
    }
  }
}


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
    if (typeof component[actionType] === 'function') {
      component[actionType]();
    } else if (typeof component.open === 'boolean') {
      component.open = actionType === 'open';
    }

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
