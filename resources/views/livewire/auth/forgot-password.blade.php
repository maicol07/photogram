<div>
    <form wire:submit.prevent="sendReset" class="auth-form">
        <x-textfield icon="email-outline" :label="__('Email')" id="email" wire:model="email" />
        <x-button type="submit" icon="send" trailingIcon :label="__('Send reset Link')" variant="raised"/>
    </form>

    @push('bottom')
        <x-button :label="__('Don\'t have an account? Signup')" :href="route('signup')" />
    @endpush
</div>
