<x-card class="container-card" variant="outlined">
    <x-list>
        @foreach(Auth::user()->notifications as $notification)
                @php($user = \App\Models\User::find($notification->data['user_id']))
                <x-list-item class="without-ripple" :ripple="false" :tabindex="Auth::user()->notifications->search($notification) === 0 ? 0 : null">
                    <x-slot:graphic>
                        @if(!$user->profileImage)
                            <span class="mdi mdi-account-circle mdc-button__icon dialog-icon" role="img" aria-label="{{__(":user's profile image", ['user' => $user->username])}}"></span>
                        @else
                            <img class="mdc-elevation--z4 list-follower-image"
                                 src="{{Storage::disk('public')->url('profile/images/' . $user->profileImage)}}"
                                 alt="{{__(":user's profile image", ['user' => $user->username])}}">
                        @endif
                    </x-slot:graphic>
                    <x-slot:meta>
                        @if(!$notification->read())
                            <x-button class="read-notification" iconButton icon="check-circle-outline" wire:click="markAsRead({{$notification}})" :aria-label="__('mark the notification as read')"/>
                        @endif
                    </x-slot:meta>
                    <!--suppress CssUnresolvedCustomProperty (FALSE POSITIVE) -->
                    <a href="{{route('inside.profile', ['username' => $user->username])}}"
                       style="color: var(--mdc-text-button-label-text-color, var(--mdc-theme-primary, #6200EE))">
                        {{$user->username}}
                    </a>
                    @switch($notification->type)
                        @case(\App\Notifications\NewFollowerNotification::class)
                            @lang('started following you')
                            @break
                        @case(\App\Notifications\NewPostNotification::class)
                            @if($notification->data['post_url'] ?? null)
                                <a href="{{$notification->data['post_url']}}">@lang('posted a new photo')</a>
                            @else
                                @lang('posted a new photo')
                            @endif
                            @break
                        @case(\App\Notifications\CommentNotification::class)
                            @lang('commented your post')
                            @break
                        @case(\App\Notifications\LikeNotification::class)
                            @lang('liked your post')
                            @break
                    @endswitch
                </x-list-item>
        @endforeach
    </x-list>
</x-card>

