<div>
    <section class="mdc-card mdc-card--outlined">
        <div class="mdc-layout-grid">
            <div class="mdc-layout-grid__inner">
                <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-3-desktop mdc-layout-grid__cell--span-4-phone container-profile">
                    <div>
                        @if(!$user->profileImage)
                            <span class="mdi mdi-account-circle" id="icon-profile" role="img" aria-label="{{__(":user's profile image", ['user' => $user->username])}}"></span>
                        @else
                        <img class="mdc-elevation--z8 image-profile"
                             src="{{Storage::disk('public')->url('profile/images/' . $user->profileImage)}}"
                             alt="{{__(":user's profile image", ['user' => $user->username])}}" />
                        @endif
                    </div>
                    @if(Auth::user()->id === $user->id)
                        <x-button id="edit-profile-button" :label="__('Edit profile')" wire:click="openDialog('profile-dialog')"
                                  variant="outlined" icon="pencil" />
                    @elseif(Auth::user()->follows()->where('user_follower', $user->id)->exists())
                        <x-button id="unfollow-button" :label="__('Unfollow')" variant="outlined" wire:click="unfollow" trailing-icon="true" icon="account-minus" />
                    @else
                        <x-button id="follow-button" :label="__('Follow')" variant="outlined" wire:click="follow" trailing-icon="true" icon="account-plus" />
                    @endif
                </div>
                <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-9-desktop mdc-layout-grid__cell--span-8-phone container-profile">
                    <div id="profile-buttons">
                        <div>
                            <div id="count-posts">{{$user->posts->count()}}</div>
                            <div>@lang('Posts')</div>
                        </div>
                        <div>
                            <x-button id="follower-profile" label="{{$user->followers()->count()}}" wire:click="openDialog('list-follower')" />
                            <div>@lang('Followers')</div>
                        </div>
                        <div>
                            <x-button id="follow-profile" label="{{$user->follows()->count()}}" wire:click="openDialog('list-follow')" />
                            <div>@lang('Follows')</div>
                        </div>
                    </div>
                    <div class="mdc-layout-grid__inner">
                        <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-12 mdc-layout-grid__cell--span-4-phone">
                            <div id="bio">{{$user->bio}}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <x-dialog id="list-follower" :title="__('Followers')">
            <livewire:user.dialog-user-list :userList="$user->followers"/>
        </x-dialog>
        <x-dialog id="list-follow" :title="__('Follows')">
            <livewire:user.dialog-user-list :userList="$user->follows"/>
        </x-dialog>
        <x-dialog id="profile-dialog" :title="__('Edit Profile')">
            <livewire:user.dialog :user="$user"/>
        </x-dialog>
    </section>
    <section>
        <x-image-list style="margin-top: 2px">
            @foreach($user->posts as $number => $post)
                <x-image-list-item class="list-posts" wire:click="viewPost({{$post}})" text="{{$post->description}}" src="{{Storage::disk('public')->url('post/images/' . $post->photo)}}" alt="{{__(':number° post image', ['number' => $number + 1])}}" />
            @endforeach
        </x-image-list>
    </section>
</div>
