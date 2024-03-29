<div>
    <form wire:submit.prevent="login" class="auth-form">
        <x-textfield :label="__('Username')" type="text" required id="username" wire:model="username"
            icon="account-outline" icon-textfield />
        <x-textfield :label="__('Password')" type="password" required id="password" wire:model="password"
            icon="key-outline" icon-textfield/>

        <x-checkbox id="remember me" :label="__('Remember me')" wire:model="remember"/>

        <div>
            <x-button icon="help" :label="__('Password forgotten?')" :href="route('password.request')"/>
            <x-button type="submit" :label="__('Login')" variant="raised" icon="arrow-right-bold-box-outline"/>
        </div>
    </form>

    @push('bottom')
        <x-button :label="__('Don\'t have an account? Signup')" :href="route('signup')" />
    @endpush
    <div class="oauth">
        <div>@lang('Login with:')</div>
        @php($google = (config('services.google.client_id') && config('services.google.redirect') && config('services.google.client_secret')))
        <x-button icon="google" variant="outlined" label="Google" wire:click="authGoogle" :disabled="!$google"/>
    </div>
    <x-snackbar id="loginMessage"/>
</div>
