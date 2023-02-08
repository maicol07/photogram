<div>
    <div class="mdc-card mdc-card--outlined">
        <div class="mdc-layout-grid">
            <div class="mdc-layout-grid__inner">
                <div class="mdc-layout-grid__cell--span-3" id="image-profile">
                    <div>
                        @if(!$user->profileImage)
                            <i class="mdi mdi-account-circle" id="icon-profile" aria-hidden="true"></i>
                        @else
                        <img class="mdc-elevation--z8 image-profile"
                             src="{{Storage::disk('public')->url('profile/images/' . $user->profileImage)}}"
                             alt="image profile" />
                        @endif
                    </div>
                    @if(Auth::user()->id === $user->id)
                        <x-button id="edit-profile-button" label="edit profile" wire:click="openDialog('profile-dialog')"
                                  variant="outlined" icon="pencil" />
                    @elseif(Auth::user()->follows()->where('user_follower', $user->id)->exists())
                        <x-button id="unfollow-button" label="unfollow" variant="outlined" wire:click="unfollow" trailing-icon="true" icon="account-minus" />
                    @else
                        <x-button id="follow-button" label="follow" variant="outlined" wire:click="follow" trailing-icon="true" icon="account-plus" />
                    @endif
                </div>
                <div class="mdc-layout-grid__cell--span-9">
                    <div class="mdc-layout-grid__inner">
                        <div class="mdc-layout-grid__cell--span-4">
                            <div id="count-posts">{{$user->posts->count()}}</div>
                            <div>@lang('Posts')</div>
                        </div>
                        <div class="mdc-layout-grid__cell--span-4">
                            <x-button id="follower-profile" label="{{$user->followers()->count()}}" wire:click="openDialog('list-follower')" />
                            <div>@lang('Followers')</div>
                        </div>
                        <div class="mdc-layout-grid__cell--span-4">
                            <x-button id="follow-profile" label="{{$user->follows()->count()}}" wire:click="openDialog('list-follow')" />
                            <div>@lang('Follows')</div>
                        </div>
                        <div class="mdc-layout-grid__cell--span-12">
                            <div>{{$user->bio}}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <x-dialog id="list-follower" title="Followers">
            <livewire:user.dialog-user-list :userList="$user->followers"/>
        </x-dialog>
        <x-dialog id="list-follow" title="Follows">
            <livewire:user.dialog-user-list :userList="$user->follows"/>
        </x-dialog>
        <x-dialog id="profile-dialog" title="Edit Profile">
            <livewire:user.dialog :user="$user"/>
        </x-dialog>
    </div>

    <x-image-list style="margin-top: 2px">
        @foreach($user->posts as $post)
            <x-image-list-item class="list-posts" wire:click="viewPost({{$post}})" text="{{$post->description}}" src="{{Storage::disk('public')->url('post/images/' . $post->photo)}}" alt="Post image" />
        @endforeach
    </x-image-list>
</div>
