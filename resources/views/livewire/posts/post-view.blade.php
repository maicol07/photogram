<div class="post-container">
    <x-card class="post-card">
        <div class="mdc-layout-grid">
            <div class="mdc-layout-grid__inner">
                <div class="mdc-layout-grid__cell--span-8">
                    <a class="namebar" wire:click="goToProfile">
                        @if($this->post->user->profileImage)
                            <img class="mdc-button__icon user-post-image" aria-hidden="true" id="user-post-image"
                                 src="{{Storage::disk('public')->url('profile/images/' . $this->post->user->profileImage)}}"
                                 alt="{{$this->post->user->username}}"/>
                        @else
                            <i class="mdi mdi-account mdc-button__icon user-post-image" id="user-post-image" aria-hidden="true"
                               alt="{{$this->post->user->username}}" ></i>
                        @endif
                        <span id="nametag-{{$this->post->id}}" class="nametag" >{{$this->post->user->username}}</span>
                    </a>
                    @if($this->post->photo)
                        <img src="{{Storage::disk('public')->url('post/images/' . $this->post->photo )}}" id="post-main-image-{{$this->post->id}}"
                             alt="Post main image" class="post-main-image"/>
                    @endif
                    {{--section with number of likes and link shares--}}
                    <div id="post-options-{{$this->post->id}}" class="post-options">

                        <x-button id="post-like-button-{{$this->post->id}}" alt="post like button" iconButton wire:click="likeToggle"
                                  :icon="$this->post->likes()->where('user_id', Auth::user()->id)->exists() ? 'thumb-up' : 'thumb-up-outline'" />

                        <x-button id="post-likes-{{$this->post->id}}" label="{{$this->post->likes()->count()}}"
                                  wire:click="openDialog('list-likes-{{$this->post->id}}')" />

                        @if(Auth::user()->id === $post->user->id)
                            <x-button id="edit-post-button-{{$this->post->id}}" label="edit post" wire:click="editPost"
                                      variant="outlined" icon="pencil" />
                        @endif
                            <x-button id="share-button-{{$post->id}}" iconButton wire:click="share" icon="share-variant-outline"/>
                    </div>
                </div>

                <div class="mdc-layout-grid__cell--span-4 post-description" id="post-description">
                    <span> {{$this->post->description}} </span>
                </div>
            </div>
        </div>

        <hr/>

        <form wire:submit.prevent="addComment" id="add-comment-section-{{$this->post->id}}" class="add-comment-section">
            <div id="comment-textfield-counter-{{$this->post->id}}" class="comment-textfield-counter">
                <x-textfield class="add-comment-content" id="add-comment-content-{{$post->id}}" :label="$this->editMode ? (__('Edit comment')) : (__('Add a comment'))"
                             wire:model="commentContent" maxlength="255"/>
            </div>
            <x-button type="submit" id="add-comment-button-{{$this->post->id}}" icon="send-outline" icon-button />
        </form>

        <div class="display-comments" id="display-comments-{{$this->post->id}}">
            <x-list data-autoanimate>
            @foreach($this->post->comments as $c)
                    <livewire:posts.comment-component :wire:key="$c->id . $c->content" :c="$c" :post="$this->post" ></livewire:posts.comment-component>
            @endforeach
            </x-list>
        </div>
    </x-card>

    <x-dialog id="list-likes-{{$this->post->id}}" :title="__('Users who liked this post:')">
        <livewire:user.dialog-user-list :wire:key="$this->post->id . $this->post->likes->count()" :userList="$this->post->likes"/>
    </x-dialog>

    <x-menu-surface class='share-menu' id="share-menu-{{$this->post->id}}" anchor-id="share-button-{{$post->id}}" fixed>
        <span>@lang('Share link'):&nbsp</span> <a> {{route('inside.viewPost', $this->post->id)}}</a>
        <x-button id="copy-share-link-button-{{$this->post->id}}" iconButton icon="content-copy" />
    </x-menu-surface>

    <script wire:ignore>
        window.addEventListener('edit-comment-{{$this->post->id}}', () => {
          document.querySelector('#add-comment-content-{{$this->post->id}}').focus();
        });
        document.querySelector('#copy-share-link-button-{{$this->post->id}}').addEventListener('click', () =>{
            navigator.clipboard.writeText(@js(route('inside.viewPost', $this->post->id)));
        });
    </script>
</div>



