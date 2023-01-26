<x-card variant="elevated" id="card-notifications">
    <x-list>
        @foreach(Auth::user()->notifications as $notification)
            @if($notification->type === \App\Notifications\NewFollowerNotification::class)
                @php($user = \App\Models\User::find($notification->data['user_id']))
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
                        @if(!$notification->read())
                            <x-button class="read-notification" iconButton icon="check-circle-outline" wire:click="markAsRead({{$notification}})"/>
                        @endif
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
</x-card>
