<form wire:submit.prevent="accept">
    <div class="mdc-layout-grid__inner" id="dialog-layout">
        <span class="mdc-layout-grid__cell--span-{{$image && !$errors->has('image') ? 4 : 6}} dialog-label" id="update-image">
            @lang('Update profile image'):
        </span>
        <div class="mdc-layout-grid__cell--span-{{$image && !$errors->has('image') ? 4 : 6}}">
            <x-button id="attachment-btn" outlined :label="__('Upload File')" icon="upload" type="button" />
        </div>
        <input wire:model="image" id="edit-image" name="image" type="file"
               accept=".jpg,.jpeg,.png,.gif,.bmp,.svg,.webp" aria-labelledby="update-image"/>
        @error('image')<span class="error-dialog mdc-layout-grid__cell--span-12">{{ $message }}</span>@enderror
       <x-snackbar id="update-image-profile"/>
        @if ($image && !$errors->has('image'))
            <output class="mdc-layout-grid__cell--span-4">
                @lang('Updated file'): {{$image->getClientOriginalName()}}
            </output>
            <span class="mdc-layout-grid__cell--span-4-desktop mdc-layout-grid__cell--span-2-phone">
                @lang('Image Preview'):
            </span>
            <span class="mdc-layout-grid__cell--span-8-desktop mdc-layout-grid__cell--span-2-phone">
                <img class="mdc-elevation--z8 image-profile" id="temporary-image" src="{{$image->temporaryUrl()}}"
                     alt="preview image">
            </span>
        @endif
    </div>
    <div>
        <x-textfield wire:model="user.bio" outlined textarea rows="8" cols="40" maxlength="{{$maxLength}}"
                     id="edit-bio" :label="__('Edit Bio')"/>
    </div>
    <div class="mdc-dialog__actions">
        <x-button dialog-button :label="__('Cancel')" variant="text" data-mdc-dialog-action="close"/>
        <x-button dialog-button :label="__('OK')" variant="text" type="submit"/>
    </div>

    <script wire:ignore>
        /** @type {HTMLButtonElement} */
        const button = document.querySelector('button#attachment-btn');
        button.addEventListener('click', () => {
            document.querySelector('input#edit-image')
                ?.click();
        });
    </script>
</form>
