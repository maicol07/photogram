<div style="text-align: center">
    <div class="mdc-card mdc-card--outlined" id="login-card">
        <div>
            <form wire:submit.prevent="login">
                <x-textfield :label="__('Username')" type="text" id="username" wire:model="username" />
                <br/>
                @error('username') <span class="error">{{ $message }}</span> @enderror
                <br/><br/>
                <x-textfield :label="__('Password')" type="password" required id="password" wire:model="password" />
                <br/>
                @error('password') <span class="error">{{ $message }}</span> @enderror
                <br/><br/>
                <x-button :label="__('Login')" id="login-button" variant="raised"/>
            </form>
        </div>
    </div>

    <livewire:ui.language.select style="margin-top: 16px;"/>

    @if(session()->has('message'))
        <x-snackbar :message="session('message')" id="loginMessage" open/>
    @endif
</div>
