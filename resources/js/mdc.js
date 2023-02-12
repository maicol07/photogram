import {MDCCheckbox} from '@material/checkbox';
import {MDCDialog} from '@material/dialog';
import {MDCDrawer} from '@material/drawer';
import {MDCFormField} from '@material/form-field';
import {MDCList} from '@material/list';
import {Corner, MDCMenu} from '@material/menu';
import {MDCMenuSurface} from '@material/menu-surface';
import {MDCRipple} from '@material/ripple';
import {MDCSelect} from '@material/select';
import {MDCSnackbar} from '@material/snackbar';
import {MDCTextField} from '@material/textfield';
import {MDCTextFieldCharacterCounter} from '@material/textfield/character-counter';
import {MDCTextFieldHelperText} from '@material/textfield/helper-text';
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
  topAppBar: {},
  drawer: {},
  menu: {},
  menuSurface: {},
  list: {},
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
  '.mdc-button, .mdc-icon-button:not(.small-icon-button), .mdc-card__primary-action, .mdc-fab, .mdc-chip__ripple, .mdc-deprecated-list-item': {
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
        let textField = element.closest('label.mdc-text-field');
        if (!textField) {
          textField = element.parentElement.previousElementSibling;
        }
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
        if (element.dataset.timeout !== undefined) {
          instance.timeoutMs = Number.parseInt(element.dataset.timeout, 10);
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
        instance.listen('MDCDialog:opened', () => {
          element.setAttribute('aria-hidden', 'true');
        });
        instance.listen('MDCDialog:closing', () => {
          element.removeAttribute('aria-hidden');
        });
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
    slug: 'topAppBar',
    component: MDCTopAppBar,
    afterInit: [
      /**
       * @param {HTMLElement} element The topAppBar element
       * @param {MDCTopAppBar} instance The topAppBar instance
       */
      (element, instance) => {
        instance.setScrollTarget(document.querySelector('main'));
        // noinspection JSUnresolvedFunction
        instance.listen('MDCTopAppBar:nav', () => {
          const drawer = window.mdc.drawer[element.closest('.mdc-drawer-app-content').previousElementSibling.id];
          drawer.open = !drawer.open;
        });
      }
    ]
  },
  '.mdc-drawer': {
    slug: 'drawer',
    component: MDCDrawer,
    afterInit: [
      /**
       * @param {HTMLElement} element The drawer element
       * @param {MDCDrawer} instance The drawer instance
       */
      (element, instance) => {
        const listElement = document.querySelector('.mdc-drawer .mdc-deprecated-list');
        const mainContentElement = document.querySelector('main');

        listElement.addEventListener('click', (event) => {
          mainContentElement.querySelector('input, button')
            ?.focus();
        });

        document.body.addEventListener('MDCDrawer:closed', () => {
          mainContentElement.querySelector('input, button')
            ?.focus();
        });
      }
    ]
  },
  '.mdc-menu': {
    slug: 'menu',
    component: MDCMenu,
    afterInit: [
      /**
       * @param {HTMLDivElement} element The menu element
       * @param {MDCMenu} instance The menu instance
       */
      (element, instance) => {
        instance.setAnchorCorner(Corner.BOTTOM_START);
        if (element.dataset.fixed && (element.dataset.anchorid !== undefined)) {
          instance.setAnchorElement(document.querySelector(`#${element.dataset.anchorid}`));
        }
        instance.setFixedPosition(Boolean(element.dataset.fixed));
      }
    ]
  },
  '.mdc-menu-surface:not(.mdc-menu)': {
    slug: 'menuSurface',
    component: MDCMenuSurface,
    afterInit: [
      /**
       * @param {HTMLDivElement} element The menu surface element
       * @param {MDCMenuSurface} instance The menu surface instance
       */
      (element, instance) => {
        instance.setAnchorCorner(Corner.BOTTOM_START);
        if (element.dataset.fixed && (element.dataset.anchorid !== undefined)) {
          instance.setMenuSurfaceAnchorElement(document.querySelector(`#${element.dataset.anchorid}`));
        }
        instance.setFixedPosition(Boolean(element.dataset.fixed));
        const keyboardFocusableElements = [
          ...element.querySelectorAll(
            'a[href], button, input, textarea, select, details, [tabindex]:not([tabindex="-1"])'
          )
        ].filter((element_) => !element_.hasAttribute('disabled') && !element_.getAttribute('aria-hidden'));
        element.addEventListener('MDCMenuSurface:opened', () => {
          for (const element_ of keyboardFocusableElements) element_.removeAttribute('tabIndex');
          element.firstElementChild.focus();
        });
        element.addEventListener('MDCMenuSurface:closed', () => {
          for (const element_ of keyboardFocusableElements) element_.setAttribute('tabIndex', '-1');
        });
      }
    ]
  },
  '.mdc-deprecated-list': {
    slug: 'list',
    component: MDCList
  }
};

/**
 * Initialize a Material Design Component
 *
 * @param {HTMLElement} element The HTML element to initialize
 * @param {?Object<string, mdcComponentDefinition>} componentDefinitions
 */
export function initSingleComponent(element, componentDefinitions) {
  const matchingDefinitions = Object.entries(componentDefinitions ?? window.mdcComponentsDefinitions)
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

/**
 * Initialize all Material Design Components
 * @param {?(string[])} only
 */
export function mdcInit(only) {
  let definitions = Object.entries(window.mdcComponentsDefinitions);
  if (only) {
    definitions = definitions.filter(([selector]) => only.some((onlySelector) => selector.includes(onlySelector)));
  }
  for (const [selector, componentDefinition] of definitions) {
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
  const {
    id,
    action,
    message
  } = event.detail;
  openCloseComponent(slug, id, actionType, action, message);
}

const componentsWithOpenCloseEvents = ['snackbar', 'dialog', 'menu', 'menuSurface'];
for (const slug of componentsWithOpenCloseEvents) {
  const componentName = slug.charAt(0)
    .toUpperCase() + slug.slice(1);
  window.addEventListener(`MDC${componentName}::open`, (event) => openCloseComponentFromEvent(slug, event, 'open'));
  window.addEventListener(`MDC${componentName}::close`, (event) => openCloseComponentFromEvent(slug, event, 'close'));
}
