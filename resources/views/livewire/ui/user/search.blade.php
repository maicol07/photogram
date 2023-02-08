<div>
    <x-button class="mdc-top-app-bar__action-item" iconButton icon="magnify" wire:click="openSearch"/>
    <x-dialog id="dialog-search" title="Search Users">
        <form wire:submit.prevent="search">
            <x-textfield id="search-user" label="Search" list="users-list" type="search" wire:model="username"/>
            <datalist id="users-list">
                @foreach($users as $user)
                    <option value="{{$user}}" />
                @endforeach
            </datalist>
            <div class="mdc-dialog__actions">
                <x-button dialog-button label="Cancel" variant="outlined" data-mdc-dialog-action="close"/>
                <x-button dialog-button label="Search" variant="outlined" type="submit"/>
            </div>
        </form>
    </x-dialog>
</div>
