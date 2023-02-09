<div class="mdc-menu-surface--anchor">
    <x-button class="mdc-top-app-bar__action-item" id="user-top-app-bar" outlined iconButton
              icon="translate"
              wire:click="openLanguagesMenu">
    </x-button>
    <x-menu id="languages-menu" label="{{__('Language')}}">
        <livewire:ui.language.language-list/>
    </x-menu>

    <script>
         window.addEventListener('load', () => {
             const languagesMenu = window.mdc.menu['languages-menu'];
             languagesMenu.listen(
                 'MDCMenu:selected',
                 /**
                  * @param {import('@material/menu').MDCMenuSelectionEvent} event
                  */
                 (event) => {
                     const {detail: {item}} = event;
                     @this.set('locale', item.dataset.value);
                 }
             );
         });
    </script>
</div>