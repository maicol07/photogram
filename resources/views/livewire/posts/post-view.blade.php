<article class="post-container">
    <x-card class="post-card">
        <div class="mdc-layout-grid">
            <div class="mdc-layout-grid__inner">
                <div class="mdc-layout-grid__cell--span-8">
                    <a class="namebar" href="{{route('inside.profile', $this->post->user->username)}}">
                        @if($this->post->user->profileImage)
                            <img class="mdc-button__icon user-post-image" aria-hidden="true" id="user-post-image"
                                 src="{{Storage::disk('public')->url('profile/images/' . $this->post->user->profileImage)}}"
                                 alt="@lang(":username's profile image", ['username' => $this->post->user->username ])"/>
                        @else
                            <span class="mdi mdi-account mdc-button__icon user-post-image" id="user-post-image"
                                  aria-hidden="true"
                                  aria-label="@lang(":username's profile image", ['username' => $this->post->user->username ])"></span>
                        @endif
                        <span id="nametag-{{$this->post->id}}" class="nametag">{{$this->post->user->username}}</span>
                    </a>
                    @if($this->post->photo)
                        <img src="{{Storage::disk('public')->url('post/images/' . $this->post->photo )}}"
                             id="post-main-image-{{$this->post->id}}"
                             alt="@lang('Post main image')" class="post-main-image"/>
                    @endif
                    {{--section with number of likes and link shares--}}
                    <div id="post-options-{{$this->post->id}}" class="post-options">

                        <x-button id="post-like-button-{{$this->post->id}}" :aria-label="__('Like this post')"
                                  iconButton wire:click="likeToggle"
                                  :icon="$this->post->likes()->where('user_id', Auth::user()->id)->exists() ? 'thumb-up' : 'thumb-up-outline'"/>

                        <x-button id="post-likes-{{$this->post->id}}" label="{{$this->post->likes()->count()}}"
                                  wire:click="openDialog('list-likes-{{$this->post->id}}')"/>

                        @if(Auth::user()->id === $post->user->id)
                            <x-button id="edit-post-button-{{$this->post->id}}" label="edit post"
                                      :href="route('inside.newPost', $this->post)"
                                      variant="outlined" icon="pencil"/>
                        @endif
                        <x-button id="share-button-{{$post->id}}" iconButton wire:click="share"
                                  icon="share-variant-outline" :aria-label="__('Share this post')"/>

                        <x-menu-surface class='share-menu' id="share-menu-{{$this->post->id}}"
                                        anchor-id="share-button-{{$post->id}}" fixed>
                            <span>@lang('Share link'):&nbsp</span> <a> {{$this->post->getURL()}}</a>
                            <x-button id="copy-share-link-button-{{$this->post->id}}" iconButton icon="content-copy"
                                      :aria-label="__('Copy share link to clipboard')" tabindex="-1"/>
                        </x-menu-surface>

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
                <x-textfield class="add-comment-content" id="add-comment-content-{{$post->id}}"
                             :label="$this->editMode ? (__('Edit comment')) : (__('Add a comment'))"
                             wire:model="commentContent" maxlength="255"/>
            </div>
            <x-button type="submit" id="add-comment-button-{{$this->post->id}}" icon="send-outline" icon-button/>
        </form>

        {{-- --------------------------------------------=----------------------------------------------------------------------------------------------------}}

        <section class="display-comments" id="display-comments-{{$this->post->id}}">
            <x-list data-autoanimate>
                @foreach($this->post->comments as $c)
                    <x-list-item class="comment" :ripple="false" id="comment-list-item-{{$c->id}}" tabindex="0">
                        <x-slot:graphic :href="route('inside.profile', $c->user->username)">
                            @if($c->user->profileImage)
                                <img src="{{Storage::disk('public')->url('profile/images/' . $c->user->profileImage)}}"
                                     alt="@lang(":username's profile image", ['username' => $c->user->username ])"
                                     class="user-comment-image"/>
                            @else
                                <span class="mdi mdi-account user-comment-image"
                                      aria-label="@lang(":username's profile image", ['username' => $c->user->username ])"> </span>
                            @endif
                        </x-slot:graphic>

                        <a class="comment-name" href="{{route('inside.profile', $c->user->username)}}">
                            {{ $c->user->username }}
                        </a>
                        <div class="comment-content">
                            {{$c->content}}
                        </div>
                        <x-slot:meta>
                            <x-button id="comment-menu-button-{{$c->id}}" class="comment-meta" iconButton
                                      icon="dots-vertical"
                                      wire:click="openMenu('comment-option-menu-{{$c->id}}')"
                                      :aria-label="__('Open comment options')"/>
                        </x-slot:meta>
                    </x-list-item>

                    @push('comment-options-' . $this->post->id)
                        <x-dialog id="list-comment-likes-{{$c->id}}" :title="__('Users who liked this comment:')">
                            <livewire:user.dialog-user-list :userList="$c->likes"
                                                            :wire:key="$c->id . $c->likes->count()"/>
                        </x-dialog>

                        <x-menu id="comment-option-menu-{{$c->id}}" anchorId="comment-menu-button-{{$c->id}}" fixed>
                            <x-list role="menu" aria-orientation="vertical" aria-hidden="true" tabindex="-1">
                                <x-list-item id="comment{{$c->id}}-like-button"
                                             wire:click="commentLikeToggle({{$c->id}})"
                                             title="comment like button">
                                    <x-slot:graphic>
                                        <span
                                            class="mdi mdi-{{$c->likes()->where('user_id', Auth::user()->id)->exists() ? 'thumb-up' : 'thumb-up-outline'}}"> </span>
                                    </x-slot:graphic>
                                    <span> @lang('Like') </span>
                                </x-list-item>

                                <x-list-item id="comment{{$c->id}}-likes"
                                             wire:click="openDialog('list-comment-likes-{{$c->id}}')">
                                    <x-slot:graphic>
                                        {{$c->likes()->count()}}
                                    </x-slot:graphic>
                                    <span> @lang('Likes') </span>
                                </x-list-item>

                                @if(Auth::user()->id === $c->user->id)
                                    <x-list-item id="edit-comment{{$c->id}}-button" wire:click="editComment({{$c}})">
                                        <x-slot:graphic>
                                            <span class="mdi mdi-pencil"> </span>
                                        </x-slot:graphic>
                                        <span> @lang('Edit') </span>
                                    </x-list-item>
                                @endif

                                @if(Auth::user()->id === $c->user->id || Auth::user()->id === $this->post->user->id)
                                    <x-list-item class="delete-button" id="delete-comment{{$c->id}}-button"
                                                 wire:click="deleteComment({{$c->id}})" title="delete">
                                        <x-slot:graphic>
                                            <span class="mdi mdi-delete-outline"> </span>
                                        </x-slot:graphic>
                                        <span>
                                @lang('Delete')
                            </span>
                                    </x-list-item>
                                @endif
                            </x-list>
                        </x-menu>
                    @endpush
                @endforeach
            </x-list>
        </section>

        {{------------------------------------------------------------------------------------------------------------------------------}}
    </x-card>
    <x-dialog id="list-likes-{{$this->post->id}}" :title="__('Users who liked this post:')">
        <livewire:user.dialog-user-list :wire:key="$this->post->id . $this->post->likes->count()"
                                        :userList="$this->post->likes"/>
    </x-dialog>

    @stack('comment-options-' . $this->post->id)

    <script wire:ignore>
        window.addEventListener('edit-comment-{{$this->post->id}}', () => {
            document.querySelector('#add-comment-content-{{$this->post->id}}')
                .focus();
        });
        document.querySelector('#copy-share-link-button-{{$this->post->id}}')
            .addEventListener('click', () => {
                navigator.clipboard.writeText(@js(route('inside.viewPost', $this->post->id)));
            });
    </script>
</article>



