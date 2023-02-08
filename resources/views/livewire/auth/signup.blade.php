<div>
    <form wire:submit.prevent="signup" class="auth-form">
        <x-textfield :label="__('Name')" type="text" id="name" required wire:model="name"/>
        <br/>

        <x-textfield :label="__('Surname')" type="text" id="surname" required wire:model="surname" />
        <br/>

        <x-textfield :label="__('Email')" type="text" id="email" required wire:model="email" />
        <br/>

        <x-textfield :label="__('Username')" type="text" required id="username" wire:model="username" />
        <br/>

        <x-textfield :label="__('Password')" type="password" required id="password" wire:model="password" />
        <br/>

        <x-textfield :label="__('Repeat password')" type="password" required id="passwordConfirmation"
                                          wire:model="password_confirmation" />
        <br/>

        <x-button type="submit" :label="__('Signup')" variant="raised"/>

    </form>
    @push('bottom')
        <x-button :label="__('Already have an account? Login')" :href="route('login')"/>
    @endpush
    <x-snackbar id="signupMessage"/>

</div>
