<div id="user-notification" class="mdc-menu-surface--anchor">
    <x-button class="mdc-top-app-bar__action-item" id="notification" outlined iconButton
              :icon="$notifications->isEmpty() ? 'bell' : 'bell-badge'" wire:click="openNotification"/>
    <x-menu id="menu-notifications">
        <x-list>
            @foreach($notifications as $notification)
                @if($notification->type === \App\Notifications\NewFollowerNotification::class)
                    @php
                        $user = \App\Models\User::find($notification->data['user_id']);
                        assert($notification instanceof \Illuminate\Notifications\DatabaseNotification);
                    @endphp
                    <x-list-item class="without-ripple" :ripple="false">
                        <x-slot:graphic>
                            @if(!$user->profileImage)
                                <i class="mdi mdi-account-circle mdc-button__icon dialog-icon " aria-hidden="true"></i>
                            @else
                                <img class="mdc-elevation--z4 list-follower-image"
                                     src="{{Storage::disk('public')->url('profile/images/' . $user->profileImage)}}"
                                     alt="Profile Image">
                            @endif
                        </x-slot:graphic>
                        <x-slot:meta>
                            <x-button iconButton icon="check-circle-outline" wire:click="markAsRead({{$notification}})"/>
                        </x-slot:meta>
                        <!--suppress CssUnresolvedCustomProperty (FALSE POSITIVE) -->
                        <a href="{{route('inside.profile', ['username' => $user->username])}}"
                           style="color: var(--mdc-text-button-label-text-color, var(--mdc-theme-primary, #6200EE))">
                            {{$user->username}}
                        </a> started following you
                    </x-list-item>
                @endif
            @endforeach
        </x-list>
        <x-button outlined label="+ View All" id="all-notifications-button" wire:click="showAll"/>
    </x-menu>
</div>
