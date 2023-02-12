<div>
    <form wire:submit.prevent="signup" class="auth-form">
        <x-textfield :label="__('Name')" type="text" id="name" required wire:model="name"
                     icon="account-outline" icon-textfield/>

        <x-textfield :label="__('Surname')" type="text" id="surname" required wire:model="surname"
                     icon="account-outline" icon-textfield/>

        <x-textfield :label="__('Email')" type="text" id="email" required wire:model="email"
                     icon="email-outline" icon-textfield/>

        <x-textfield :label="__('Username')" type="text" required id="username" wire:model="username"
                     icon="account-outline" icon-textfield/>

        <x-textfield :label="__('Password')" type="password" required id="password" wire:model="password"
                     icon="key-outline" icon-textfield/>

        <x-textfield :label="__('Repeat password')" type="password" required id="passwordConfirmation"
                                          wire:model="password_confirmation" icon="shield-key" icon-textfield/>

        <x-button type="submit" :label="__('Signup')" variant="raised" class="auth-button"
                  icon="arrow-right-bold-box-outline"/>

    </form>
    @push('bottom')
        <x-button :label="__('Already have an account? Login')" :href="route('login')"/>
    @endpush
    <div class="oauth">
        <div>@lang('Signup with'):</div>
        @php($google = (config('services.google.client_id') && config('services.google.redirect') && config('services.google.client_secret')))
        <x-button icon="google" variant="outlined" label="Google" wire:click="authGoogle" :disabled="!$google"/>
    </div>
    <x-snackbar id="signupMessage"/>
</div>
