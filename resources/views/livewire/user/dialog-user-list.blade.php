<div>
    <x-list>
        @foreach($userList as $user)
            <x-list-item text="{{$user->username}}" secondary-text="{{$user->bio}}" href="/profile/{{$user->username}}" :tabindex="$userList->search($user)">
                <x-slot:graphic>
                    @if(!$user->profileImage)
                        <i class="mdi mdi-account-circle mdc-button__icon dialog-icon " aria-hidden="true"></i>
                    @else
                        <img class="mdc-elevation--z4 list-follower-image" src="{{Storage::disk('public')->url('profile/images/' . $user->profileImage)}}"
                             alt="Profile Image">
                    @endif
                </x-slot:graphic>
            </x-list-item>
        @endforeach
    </x-list>
    <div class="mdc-dialog__actions">
        <x-button dialog-button label="Close" variant="text" data-mdc-dialog-action="close"/>
    </div>
</div>
