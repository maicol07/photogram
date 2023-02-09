<div style="width:{{$width}}%" >
    <x-card id="post-card" >
        <div class="mdc-layout-grid">
            <div class="mdc-layout-grid__inner">
                <div class="mdc-layout-grid__cell--span-8">
                    <a class="namebar" wire:click="goToProfile">
                        @if($this->post->user->profileImage)
                            <img class="mdc-button__icon" aria-hidden="true" id="user-post-image"
                                 src="{{Storage::disk('public')->url('profile/images/' . $this->post->user->profileImage)}}"
                                 alt="{{$this->post->user->username}}"/>
                        @else
                            <i class="mdi mdi-account mdc-button__icon" id="user-post-image" aria-hidden="true"
                               alt="{{$this->post->user->username}}" ></i>
                        @endif
                        <span id="nametag" >{{$this->post->user->username}}</span>
                    </a>
                    <br/>
                    @if($this->post->photo)
                        <img src="{{Storage::disk('public')->url('post/images/' . $this->post->photo )}}" id="post-main-image"
                             alt="Post main image"/>
                    @endif
                    <br/>
                    {{--section with number of likes and link share--}}
                    <div id="post-options" >

                        <x-button id="post-like-button" alt="post like button" iconButton wire:click="likeToggle"
                                  :icon="$this->post->likes()->where('user_id', Auth::user()->id)->exists() ? 'thumb-up' : 'thumb-up-outline'" />

                        <x-button id="post-likes" label="{{$this->post->likes()->count()}}"
                                  wire:click="openDialog('list-likes')" />

                        @if(Auth::user()->id === $post->user->id)
                            <x-button id="edit-post-button" label="edit post" wire:click="editPost"
                                      variant="outlined" icon="pencil" />
                        @endif


                        <span class="mdc-menu-surface--anchor">
                            <x-button id="share-button" iconButton wire:click="share" icon="share-variant-outline"  />

                            <x-menu-surface class='share-menu' id="share-menu-{{$this->post->id}}" >
                                <span> share link:&nbsp </span> <a> {{route('inside.viewPost', $this->post->id)}}</a>
                                <x-button id="copy-share-link-button" iconButton icon="content-copy" />
                            </x-menu-surface>
                        </span>
                    </div>
                </div>

                <div class="mdc-layout-grid__cell--span-4" id="post-description" >
                    <span> {{$this->post->description}} </span>
                </div>
            </div>
        </div>

        <hr/>

        <form wire:submit.prevent="addComment"  id="add-comment-section" >
            <div id="comment-textfield-counter">
                <x-textfield id="add-comment-content" :label="$this->editMode ? (__('Edit comment')) : (__('Add a comment'))"
                             wire:model="commentContent" maxlength="255"/>
            </div>
            <x-button type="submit" id="add-comment-button" icon="send-outline" icon-button />
        </form>

        <div id="display-comments">
            <x-list data-autoanimate>
            @foreach($this->post->comments as $c)
                    <livewire:posts.comment-component :wire:key="$c->id . $c->content" :c="$c" :post="$this->post" ></livewire:posts.comment-component>
            @endforeach
            </x-list>
        </div>
    </x-card>
    <x-dialog id="list-likes" :title="__('Users who liked this post:')">
        <livewire:user.dialog-user-list :userList="$this->post->likes"/>
    </x-dialog>

    <script wire:ignore>
        window.addEventListener('edit-comment', () => {
          document.querySelector('#add-comment-content').focus();
        });
        document.querySelector('#copy-share-link-button').addEventListener('click', () =>{
            navigator.clipboard.writeText(@js(route('inside.viewPost', $this->post->id)));
        });
    </script>
</div>



