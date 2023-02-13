<div>
    <x-list>
        @foreach($userList as $user)
            <x-list-item :text="$user->username" :secondary-text="$user->bio" :href="route('inside.profile', $user->username)">
                <x-slot:graphic>
                    @if(!$user->profileImage)
                        <span class="mdi mdi-account-circle mdc-button__icon dialog-icon" role="img" aria-label="{{__(":user's profile image", ['user' => $user->username])}}"></span>
                    @else
                        <img class="mdc-elevation--z4 list-follower-image" src="{{Storage::disk('public')->url('profile/images/' . $user->profileImage)}}"
                             alt="{{__(":user's profile image", ['user' => $user->username])}}">
                    @endif
                </x-slot:graphic>
            </x-list-item>
        @endforeach
    </x-list>
    <div class="mdc-dialog__actions">
        <x-button dialog-button :label="__('Close')" variant="text" data-mdc-dialog-action="close"/>
    </div>
</div>
