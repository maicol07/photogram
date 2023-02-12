<div>
    <span> @lang('To continue please click the link that has been sent to your email.') </span>
    <x-button :label="__('Did not receive an email? Send again')" :href="route('password.reset')"/>
    <x-snackbar id="resendEmail" />
</div>
