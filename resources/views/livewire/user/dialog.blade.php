<div>
    @if ($image)
        <div id="preview-image">
            <span>
                @lang('Image Preview'):
            </span>
            <span>
                <img id="temporary-image" src="{{$image->temporaryUrl()}}" alt="preview image">
            </span>
        </div>
    @endif
    <div class="mdc-layout-grid__inner" id="dialog-layout">
        <span class="mdc-layout-grid__cell dialog-label">
            @lang('Update profile image'):
        </span>
        <div class="mdc-layout-grid__cell">
            <x-button id="attachment-btn" outlined :label="__('Upload File')" icon="paperclip" />
        </div>
        <input wire:model="image" id="edit-image" name="image" type="file">
        @error('image') <span class="error">{{$message}}</span>@enderror
        <span class="mdc-layout-grid__cell dialog-label">
            @lang('Uploaded file:')
            <span id="attachments-display">{{$image?->getClientOriginalName()}}</span>
        </span>
    </div>
    <div><x-textfield wire:model="user.bio" outlined textarea rows="8" cols="40" maxlength="140"
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
