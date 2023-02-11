<div role="listitem">
    <x-list-item class="comment" :ripple="false" id="comment-list-item-{{$c->id}}">
        <x-slot:graphic>
            @if($c->user->profileImage)
                <img src="{{Storage::disk('public')->url('profile/images/' . $c->user->profileImage)}}"
                     alt="{{$c->user->username}}"
                     class="user-comment-image"
                     wire:click="goToProfile"/>
            @else
                <i class="mdi mdi-account user-comment-image"
                   wire:click="goToProfile"
                   alt="{{$c->user->username}}" ></i>
            @endif
        </x-slot:graphic>

        <span class="comment-name" wire:click="goToProfile">
            {{ $c->user->username }}
        </span>
        <div class="comment-content">
            {{$c->content}}
        </div>
        <x-slot:meta>
            <x-button id="comment-menu-button-{{$c->id}}" class="comment-meta" iconButton icon="dots-vertical" wire:click="openMenu('comment-option-menu-{{$c->id}}')" />
        </x-slot:meta>
    </x-list-item>

    <x-dialog id="list-comment-likes-{{$c->id}}" :title="__('Users who liked this comment:')">
        <livewire:user.dialog-user-list :userList="$c->likes" :wire:key="$c->id . $c->likes->count()"/>
    </x-dialog>

    <x-menu id="comment-option-menu-{{$c->id}}" anchorId="comment-menu-button-{{$c->id}}" fixed>
        <x-list>
            <x-list-item id="comment{{$c->id}}-like-button" wire:click="commentLikeToggle({{$c->id}})"
                         title="comment like button">
                <x-slot:graphic>
                    <i class="mdi mdi-{{$c->likes()->where('user_id', Auth::user()->id)->exists() ? 'thumb-up' : 'thumb-up-outline'}}"> </i>
                </x-slot:graphic>
                <span> @lang('Like') </span>
            </x-list-item>

            <x-list-item id="comment{{$c->id}}-likes" wire:click="openDialog('list-comment-likes-{{$c->id}}')">
                <x-slot:graphic>
                    {{$c->likes()->count()}}
                </x-slot:graphic>
                <span> @lang('Likes') </span>
            </x-list-item>

            @if(Auth::user()->id === $c->user->id)
                <x-list-item id="edit-comment{{$c->id}}-button" wire:click="editComment">
                    <x-slot:graphic>
                        <i class="mdi mdi-pencil"> </i>
                    </x-slot:graphic>
                    <span> @lang('Edit') </span>
                </x-list-item>
            @endif

            @if(Auth::user()->id === $c->user->id || Auth::user()->id === $this->post->user->id)
            <x-list-item class="delete-button" id="delete-comment{{$c->id}}-button" wire:click="deleteComment({{$c->id}})" title="delete">
                <x-slot:graphic>
                    <i class="mdi mdi-delete-outline"> </i>
                </x-slot:graphic>
                <span>
                    @lang('Delete')
                </span>
            </x-list-item>
            @endif
        </x-list>
    </x-menu>
</div>
