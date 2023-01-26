
{{--TODO non credo sia accessibile--}}

<div class="mdc-menu-surface--anchor">
    <x-button class="mdc-top-app-bar__action-item" id="user-top-app-bar" outlined iconButton
              :icon="!empty(auth()->user()->profileImage) ? '' : 'account'"
              wire:click="openLogoutMenu" >

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
        <br/>
        @if(auth()->user()->profileImage)
            <img aria-hidden="true" id="user-logout-menu-image"
                 src="{{Storage::disk('public')->url('profile/images/' . auth()->user()->profileImage)}}"
                 alt="{{auth()->user()->username}}"
                 style="border-radius: 50%;"/>
        @endif
        @if(auth()->user()->profileImage === null)
          <i class="mdi mdi-account mdc-button__icon" id="user-logout-menu-image" aria-hidden="true"></i>
        @endif
        <br/>

        {{--button that redirects to user profile--}}
        <x-button id="menu-user-button" :label="__('Il tuo profilo')"
            wire:click="goToProfile"/>
        <br/>

        {{--button to logout--}}
        <x-button id="user-profile-menu" :label="__('Logout')" wire:click="goToLogout"/>

    </x-menu-surface>
</div>


