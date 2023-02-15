<div id="user-notification" class="mdc-menu-surface--anchor">
    <x-button class="mdc-top-app-bar__action-item" id="notification" outlined iconButton :aria-label="__('open the notifications menu')"
              :icon="$notifications->isEmpty() ? 'bell' : 'bell-badge'" wire:click="openNotification"/>
    <x-menu id="menu-notifications">
            <x-list role="menu" aria-orientation="vertical" aria-hidden="true" tabindex="-1">
                @if($notifications->isEmpty())
                    <x-list-item role="menuitem">@lang('You do not have notifications')</x-list-item>
                @else
                    @foreach($notifications as $notification)
                        @php
                            $user = \App\Models\User::find($notification->data['user_id']);
                            assert($notification instanceof \Illuminate\Notifications\DatabaseNotification);
                        @endphp
                        <x-list-item class="without-ripple" :ripple="false" onclick="event.stopPropagation()" role="menuitem">
                            <x-slot:graphic>
                                @if(!$user->profileImage)
                                    <span class="mdi mdi-account-circle mdc-button__icon dialog-icon" role="img" aria-label="{{__(":user's profile image", ['user' => $user->username])}}"></span>
                                @else
                                    <img class="mdc-elevation--z4 list-follower-image"
                                         src="{{Storage::disk('public')->url('profile/images/' . $user->profileImage)}}"
                                         alt="{{__(":user's profile image", ['user' => $user->username])}}"/>
                                @endif
                            </x-slot:graphic>
                            <x-slot:meta>
                                <x-button iconButton icon="check-circle-outline" :wire:key="$notification->id" wire:click="markAsRead({{$notification}})" :aria-label="__('mark the notification as read')"/>
                            </x-slot:meta>
                            <!--suppress CssUnresolvedCustomProperty (FALSE POSITIVE) -->
                            <a href="{!! route('inside.profile', $user->username) !!}"
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
                @endif
                <x-list-item :href="route('inside.allNotifications')">
                    <x-slot:graphic>
                        <span class="mdi mdi-plus mdc-button__icon dialog-icon" aria-label="{{__('show all notifications')}}" aria-hidden="true" role="listitem" ></span>
                    </x-slot:graphic>
                    @lang('View all')
                </x-list-item>
            </x-list>
    </x-menu>
</div>
