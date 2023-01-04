<div>
    <span><input wire:model="image" type="file" id="edit-image" name="image"></span>
    <span><label for="edit-image">Edit Image</label></span>
    <div><x-textfield wire:model="bio" outlined textarea rows="8" cols="40" maxlength="140"
                      id="edit-bio" label="Edit Bio" /></div>
    <div class="mdc-dialog__actions">
        <x-button dialog-button variant="outlined" label="Cancel" wire:click="close" variant="text"
                  data-mdc-dialog-action="close"/>
        <x-button dialog-button variant="outlined" label="OK" wire:click="accept" variant="text"
                  data-mdc-dialog-action="accept" data-mdc-dialog-button-default/>
    </div>

    <script>
        /** @type {HTMLButtonElement} */
        const button = document.querySelector('button#attachment-btn');
        button.addEventListener('click', () => {
            document.querySelector('input#edit-image')?.click();
        });
    </script>
</div>
