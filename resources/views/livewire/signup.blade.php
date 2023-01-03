<div style="text-align: center">
    <div class="mdc-card mdc-card--outlined" id="login-card">
        <div>
            <form wire:submit.prevent="signup">

                <x-textfield :label="__('Name')" type="text" id="name" {{--wire:model="username"--}} />
                <br/>
                @error('name') <span class="error">{{ $message }}</span> @enderror
                <br/>

                <x-textfield :label="__('Surname')" type="text" id="surname" {{--wire:model="username"--}} />
                <br/>
                @error('surname') <span class="error">{{ $message }}</span> @enderror
                <br/>

                <x-textfield :label="__('Email')" type="text" id="email" {{--wire:model="username"--}} />
                <br/>
                @error('email') <span class="error">{{ $message }}</span> @enderror
                <br/>

                <x-textfield :label="__('Date of birth')" type="date" id="dateofbirthsignup" {{--wire:model="username"--}} />
                <br/>
                @error('dateofbirth') <span class="error">{{ $message }}</span> @enderror
                <br/>


                <x-textfield :label="__('Username')" type="text" id="username" {{--wire:model="username"--}} />
                <br/>
                @error('username') <span class="error">{{ $message }}</span> @enderror
                <br/>

                <x-textfield :label="__('Password')" type="password" required id="password"  />
                <br/>
                @error('password') <span class="error">{{ $message }}</span> @enderror
                <br/>

                <x-textfield :label="__('Repeat password')" type="password" required id="repeat-password"  />
                <br/>
                @error('repeat-password') <span class="error">{{ $message }}</span> @enderror
                <br/>

                <x-button :label="__('Signup')" id="signup-button" variant="raised"/>
            </form>
        </div>
    </div>

    @if(session()->has('message'))
        <x-snackbar :message="session('message')" id="signupMessage" open/>
    @endif
</div>
