<div class="auth-container">
    <div class="mdc-card mdc-card--outlined auth-card" >
        <div>
            <form wire:submit.prevent="login" class="auth-form">
                <x-textfield :label="__('Username')" type="text" id="username" wire:model="username" />
                <br/>
                <x-textfield :label="__('Password')" type="password" required id="password" wire:model="password" />

                <x-checkbox id="remember me" :label="__('Remember me')" wire:model="remember"/>

                <div>
                    <x-button :label="__('Password forgotten?')" wire:click="goToResetPassword"/>
                    <x-button :label="__('Login')" variant="raised"/>
                </div>

            </form>
        </div>
    </div>
    <br/>
    <x-button :label="__('Don\'t have an account? Signup')" wire:click="goToSignup"/>
    <livewire:ui.language.select style="margin-top: 16px;"/>

    <x-snackbar id="loginMessage"/>
</div>
