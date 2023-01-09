<div class="auth-container">
    <div class="mdc-card mdc-card--outlined auth-card" >
        <div>
            <form wire:submit.prevent="signupButton" class="auth-form">
                <x-textfield :label="__('Name')" type="text" id="name" wire:model="name"/>
                <br/>

                <x-textfield :label="__('Surname')" type="text" id="surname" wire:model="surname" />
                <br/>

                <x-textfield :label="__('Email')" type="text" id="email" wire:model="email" />
                <br/>

                <x-textfield :label="__('Date of birth')" type="date" id="dateofbirthsignup" wire:model="dateOfBirth" />
                <br/>

                <x-textfield :label="__('Username')" type="text" id="username" wire:model="username" />
                <br/>

                <x-textfield :label="__('Password')" type="password" required id="password" wire:model="password" />
                <br/>

                <x-textfield :label="__('Repeat password')" type="password" required id="repeat-password"
                                                  wire:model="repeatPassword" />
                <br/>

                <x-button :label="__('Signup')" variant="raised"/>

            </form>
        </div>
    </div>
    <x-button :label="__('Already have an account? Login')" wire:click="goToLogin"/>
    <livewire:ui.language.select style="margin-top: 16px;"/>

    @if(session()->has('message'))
        <x-snackbar :message="session('message')" id="signupMessage" open/>
    @endif
</div>
