<div>
    {{--<livewire:user.card :numberPosts="$numberPosts" :numberFollowers="$numberFollowers" :numberFollows="$numberFollows"
                        bio="Biografia utente" :imageProfile="$imageProfile" />--}}
    <div class="mdc-card mdc-card--outlined">
        <div class="mdc-layout-grid">
            <div class="mdc-layout-grid__inner">
                <div class="mdc-layout-grid__cell--span-3">
                    <div>
                        <img class="mdc-elevation--z8" src="{{$user->profileImage}}" alt="image profile" />
                    </div>
                    <x-button id="edit-profile-button" label="edit profile" wire:click="openDialog"
                              variant="outlined" trailing-icon="true" icon="pencil" />
                </div>
                <div class="mdc-layout-grid__cell--span-9">
                    <div class="mdc-layout-grid__inner">
                        <div class="mdc-layout-grid__cell--span-4">
                            <div>{{$numberPosts}}</div>
                            <div>posts</div>
                        </div>
                        <div class="mdc-layout-grid__cell--span-4">
                            <div>{{$numberFollowers}}</div>
                            <div>followers</div>
                        </div>
                        <div class="mdc-layout-grid__cell--span-4">
                            <div>{{$numberFollows}}</div>
                            <div>follows</div>
                        </div>
                        <div class="mdc-layout-grid__cell--span-12">
                            <div>{{$user->bio}}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <x-dialog id="profile-dialog" title="Edit Profile" :open="$open">
            <livewire:user.dialog :open="$open" :user="$user"/>
        </x-dialog>
    </div>
    {{--<livewire:user.posts :posts="$user->posts" />--}}
    <x-image-list>
        @foreach($posts as $post)
            <x-image-list-item text="{{$post['text']}}" src="{{$post['img']}}" alt="{{$post['alt']}}" />
        @endforeach
    </x-image-list>

    <script>
        const editProfileButton = document.querySelector('#edit-profile-button');
        editProfileButton.addEventListener('click', () => {
            window.mdc.dialog['profile-dialog'].open();
        });
    </script>
</div>
