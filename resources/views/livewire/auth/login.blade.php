
<div>
    <form wire:submit.prevent="login" class="auth-form">
        <x-textfield :label="__('Username')" type="text" id="username" wire:model="username" />
        <br/>
        <x-textfield :label="__('Password')" type="password" required id="password" wire:model="password" />

        <x-checkbox id="remember me" :label="__('Remember me')" wire:model="remember"/>

        <div>
            <x-button :label="__('Password forgotten?')" wire:click="goToResetPassword"/>
            <x-button type="submit" :label="__('Login')" variant="raised"/>
        </div>
    </form>

    @push('bottom')
        <x-button :label="__('Don\'t have an account? Signup')" :href="route('signup')" />
    @endpush
    <x-snackbar id="loginMessage"/>
</div>
