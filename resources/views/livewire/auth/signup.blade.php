<div class="auth-container">
    <div class="mdc-card mdc-card--outlined auth-card" >
        <div>
            <form wire:submit.prevent="signup" class="auth-form">
                <x-textfield :label="__('Name')" type="text" id="name" required wire:model="name"/>
                <br/>

                <x-textfield :label="__('Surname')" type="text" id="surname" required wire:model="surname" />
                <br/>

                <x-textfield :label="__('Email')" type="text" id="email" required wire:model="email" />
                <br/>

                <x-textfield :label="__('Date of birth')" type="date" required id="dateofbirthsignup" wire:model="dateOfBirth" />
                <br/>

                <x-textfield :label="__('Username')" type="text" required id="username" wire:model="username" />
                <br/>

                <x-textfield :label="__('Password')" type="password" required id="password" wire:model="password" />
                <br/>

                <x-textfield :label="__('Repeat password')" type="password" required id="repeatPassword"
                                                  wire:model="repeatPassword" />
                <br/>

                <x-button :label="__('Signup')" variant="raised"/>

            </form>
        </div>
    </div>
    <x-button :label="__('Already have an account? Login')" wire:click="goToLogin"/>
    <livewire:ui.language.select style="margin-top: 16px;"/>

    <x-snackbar id="signupMessage"/>

</div>
