<div>
    <span> @lang('To continue please click the link that has been sent to your email.') </span>
    <x-button :label="__('Did not receive an email? Send again')" wire:click="resendEmail"/>
    <x-snackbar id="resendEmail" />
</div>
