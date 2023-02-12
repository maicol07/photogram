<div>
    <form wire:submit.prevent="resetPassword" class="auth-form">
        <x-textfield :label="__('Email')" id="email" wire:model="email" />
        <x-textfield :label="__('Password')" id="password" wire:model="password" type="password" />
        <x-textfield :label="__('Password Confirmation')" id="password_confirmation" type="password"
                     wire:model="password_confirmation" />
        <x-button type="submit" icon="check" :label="__('Reset Password')" variant="raised"/>
    </form>
    @push('bottom')
        <x-button :label="__('Don\'t have an account? Signup')" :href="route('signup')" />
    @endpush
</div>

