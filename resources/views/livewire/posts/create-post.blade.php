<form wire:submit.prevent="upload">
    <x-card outlined class="container-card">
        <div>
            <span>
                    @lang('Add an image to your post'):
            </span>
            <div>
                <x-button id="upload-image-button" outlined :label="__('Upload File')" icon="upload" type="button" />
            </div>
            <input wire:model="image" id="add-image" name="image" type="file"
                   accept=".jpg,.jpeg,.png,.gif,.bmp,.svg,.webp" />
        </div>

        @if ($image && !$errors->has('image'))
            <div style="text-overflow: ellipsis; overflow: clip">
                @lang('Uploaded file'): {{($image instanceof \Livewire\TemporaryUploadedFile)? $image->getClientOriginalName() : $image}}
            </div>
            <div id="preview-image">
                <span>
                    @lang('Image Preview'):
                </span>
                <span>
                    <img id="temporary-post-image" src="{{($image instanceof \Livewire\TemporaryUploadedFile) ? $image->temporaryUrl() :
                        Storage::disk('public')->url('post/images/' . $image)}}"
                         alt="preview image" />
                </span>
            </div>
        @endif

        <div>
            <x-textfield wire:model="post.description" outlined textarea rows="8" cols="40" maxlength="{{$maxLength}}"
                         id="edit-bio" :label="__('Add a description')"/>
        </div>
        <div class="mdc-dialog__actions">
            @if($this->post->exists)
                <x-button dialog-button icon="delete" :label="__('Delete')" variant="text" wire:click="delete" />
            @endif
            <x-button dialog-button :label="__('Cancel')" variant="text" wire:click="goToProfile" />
            <x-button dialog-button :label="__('OK')" variant="text" type="submit" />
        </div>
    </x-card>
    <script wire:ignore>
        /** @type {HTMLButtonElement} */
        const button = document.querySelector('button#upload-image-button');
        button.addEventListener('click', () => {
          document.querySelector('input#add-image')
            ?.click();
        });
    </script>

    <x-snackbar id="imageError"></x-snackbar>
    @error('image')
        <script wire:key="{{now()}}">
            /** @type{import('@material/snackbar').MDCSnackbar} */
            const snackbar = window.mdc.snackbar.imageError;
            snackbar.labelText = @js($message);
            snackbar.open();
        </script>
    @enderror
</form>
