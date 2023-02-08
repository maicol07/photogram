<div>
    <form wire:submit.prevent="resetPassword" class="auth-form">
        <x-textfield :label="__('Email')" id="email" wire:model="email" />
        <br/>
        <x-textfield :label="__('Password')" id="password" wire:model="password" type="password" />
        <br/>
        <x-textfield :label="__('Password Confirmation')" id="password_confirmation" type="password"
                     wire:model="password_confirmation" />
        <br/>
        <x-button type="submit" :label="__('Reset Password')" variant="raised"/>
    </form>
    @push('bottom')
        <x-button :label="__('Don\'t have an account? Signup')" :href="route('signup')" />
    @endpush
</div>

