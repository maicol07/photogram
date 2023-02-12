<div>
    <x-button class="mdc-top-app-bar__action-item" iconButton icon="magnify" wire:click="openSearch" :aria-label="__('open the search dialog')"/>
    <x-dialog id="dialog-search" :title="__('Search Users')">
        <form wire:submit.prevent="search">
            <x-textfield id="search-user" icon="magnify" :label="__('Search')" list="users-list" type="search" wire:model="username"/>
            <datalist id="users-list">
                @foreach($users as $user)
                    <option value="{{$user}}" />
                @endforeach
            </datalist>
            <div class="mdc-dialog__actions">
                <x-button dialog-button :label="__('Cancel')" data-mdc-dialog-action="close"/>
                <x-button dialog-button :label="__('Search')" type="submit"/>
            </div>
        </form>
    </x-dialog>
</div>
