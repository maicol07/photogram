<div class="mdc-menu-surface--anchor">
    <x-button class="mdc-top-app-bar__action-item" id="user-top-app-bar" outlined iconButton
              :icon="!empty(auth()->user()->profileImage) ? '' : 'account'"
              wire:click="openLogoutMenu" :aria-label="__('Open Logout menu')" >

        @if(auth()->user()->profileImage)
            <x-slot:image>
                <img class="mdc-button__icon" aria-hidden="true"
                     src="{{Storage::disk('public')->url('profile/images/' . auth()->user()->profileImage)}}"
                     alt="{{auth()->user()->username}}"
                     style="border-radius: 50%;"/>
            </x-slot:image>
        @endif
    </x-button>

    <x-menu-surface id="user-logout-menu" >
        {{--user image or icon--}}
        @if(auth()->user()->profileImage)
            <img aria-hidden="true" id="user-logout-menu-image"
                 src="{{Storage::disk('public')->url('profile/images/' . auth()->user()->profileImage)}}"
                 alt="{{auth()->user()->username}}"
                 style="border-radius: 50%;"/>
        @endif
        @if(auth()->user()->profileImage === null)
          <span class="mdi mdi-account" id="user-logout-menu-image" role="img" aria-hidden="true"></span>
        @endif

        {{--button that redirects to user profile--}}
        <x-button id="menu-user-button" icon="account-outline" :label="__('Your profile')" tabindex="-1"
                  :href="route('inside.profile')"/>

        {{--button to logout--}}
        <x-button id="user-profile-menu" icon="logout" :label="__('Logout')" :href="route('logout')" tabindex="-1"/>
    </x-menu-surface>
</div>


