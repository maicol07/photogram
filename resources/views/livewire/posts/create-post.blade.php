<form wire:submit.prevent="upload" class="post-create-container">
    <div class="mdc-card mdc-card--outlined post-create-card" id="post-create-card" >
        <div>
            <span>
                    @lang('Add an image to your post'):
            </span>
            <div>
                <x-button id="attachment-btn" outlined :label="__('Upload File')" icon="upload" type="button" />
            </div>
            <input wire:model="image" id="add-image" name="image" type="file"
                   accept=".jpg,.jpeg,.png,.gif,.bmp,.svg,.webp" />
        </div>
        @error('image')<span>{{ $message }}</span>@enderror

        @if ($image && !$errors->has('image'))
            <div>
                @lang('Uploaded file'): {{($image instanceof \Livewire\TemporaryUploadedFile)? $image->getClientOriginalName() : $image}}
            </div>
            <br/>
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
            <x-button dialog-button :label="__('Delete')" variant="text" wire:click="delete" />
            <x-button dialog-button :label="__('Cancel')" variant="text" wire:click="goToProfile" />
            <x-button dialog-button :label="__('OK')" variant="text" type="submit" />
        </div>
    </div>
    <script wire:ignore>
        /** @type {HTMLButtonElement} */
        const button = document.querySelector('button#attachment-btn');
        button.addEventListener('click', () => {
            document.querySelector('input#add-image')
                ?.click();
        });
    </script>
</form>
