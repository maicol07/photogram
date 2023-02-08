<x-card outlined class="container-card" id="settings">
    <x-list id="categories-list">
        @foreach($this->getCategories() as $slug => $category)
            <x-list-item :text="$category['headline']" :secondary-text="$category['supportingText']"
                         wire:click="openCategory('{{$slug}}')" :data-danger="Arr::get($category, 'danger')">
                <x-slot:graphic>
                    <i class="mdi mdi-{{$category['icon']}} dialog-icon" aria-hidden="true"></i>
                </x-slot:graphic>
                <x-slot:meta>
                    @if(Arr::get($category, 'trailingIcon'))
                        <i class="mdi mdi-{{$category['trailingIcon']}}"></i>
                    @elseif(Arr::get($category, 'trailingIcon') !== false)
                        <i class="mdi mdi-pencil"></i>
                    @endif
                </x-slot:meta>
            </x-list-item>
        @endforeach
    </x-list>

    <x-dialog id="account-dialog" :title="__('Account settings')">
        <form wire:submit.prevent="saveAccountSettings">
            <p>@lang(__('Here you can change your username and email address.'))</p>
            <x-textfield name="username" wire:model="user.username" :label="__('Username')"></x-textfield>
            <x-textfield name="email" wire:model="user.email" type="email" :label="__('Email')"></x-textfield>
            <div class="mdc-dialog__actions">
                <x-button type="submit" :label="__('Save')" dialog-button></x-button>
            </div>
        </form>
    </x-dialog>

    <x-dialog id="security-dialog" :title="__('Security settings')">
        <form wire:submit.prevent="saveSecuritySettings">
            <p>@lang(__('Here you can change your password.'))</p>
            <x-textfield name="current_password" type="password" wire:model="current_password"
                         :label="__('Current password')"></x-textfield>
            <x-textfield name="password" type="password" wire:model="password" :label="__('Password')"></x-textfield>
            <x-textfield name="password_confirmation" type="password" wire:model="password_confirmation"
                         :label="__('Confirm password')"></x-textfield>
            <div class="mdc-dialog__actions">
                <x-button type="submit" :label="__('Save')" dialog-button></x-button>
            </div>
        </form>
    </x-dialog>

    <x-dialog id="notifications-dialog" :title="__('Notifications settings')">
        <form wire:submit.prevent="saveNotificationsSettings">
            <div class="mdc-data-table">
                <div class="mdc-data-table__table-container">
                    <table class="mdc-data-table__table" aria-label="Dessert calories">
                        <thead>
                        <tr class="mdc-data-table__header-row">
                            <th class="mdc-data-table__header-cell" role="columnheader"
                                scope="col">@lang('Notification type')</th>
                            <th class="mdc-data-table__header-cell" role="columnheader" scope="col">@lang('Email')</th>
                            <th class="mdc-data-table__header-cell" role="columnheader" scope="col">@lang('Web')</th>
                        </tr>
                        </thead>
                        <tbody class="mdc-data-table__content">
                        @foreach($this->getNotificationsTypes() as $notificationType => $reflectionClass)
                            @if($reflectionClass->isAbstract())
                                @continue
                            @endif
                            <tr class="mdc-data-table__row">
                                <th class="mdc-data-table__cell"
                                    scope="row">{{$notificationType::getNotificationDescription()}}</th>
                                <td class="mdc-data-table__cell mdc-data-table__cell--checkbox">
                                    <x-checkbox id="{{$notificationType}}-mail" name="{{$notificationType}}-mail" wire:model="notifications.{{$notificationType}}.mail"></x-checkbox>
                                </td>
                                <td class="mdc-data-table__cell mdc-data-table__cell--checkbox">
                                    <x-checkbox id="{{$notificationType}}-database" name="{{$notificationType}}-database" wire:model="notifications.{{$notificationType}}.database"></x-checkbox>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="mdc-dialog__actions">
                <x-button type="submit" :label="__('Save')" dialog-button></x-button>
            </div>
        </form>
    </x-dialog>

    <x-dialog id="google-dialog" :title="__('Link/Unlink your Google account')">
        <form wire:submit.prevent="saveGoogleSettings">
            @if($user->isLinkedToGoogle())
                <p>@lang(__('Here you can unlink your Google account from your account.'))</p>
                <p>
                    <strong>@lang(__('Linked Google account ID')):</strong> {{$user->google_id}}
                </p>
            @else
                <p>@lang(__('Here you can connect your Google account to your account.'))</p>
                <p>@lang(__("Currently you aren't linked to any Google account."))</p>
            @endif

            <div class="mdc-dialog__actions">
                @if($user->isLinkedToGoogle())
                    <x-button type="button" :label="__('Unlink')" wire:click="unlinkGoogleAccount" dialog-button></x-button>
                @else
                    <x-button type="button" :label="__('Link')" :href="route('auth.redirect-provider', 'google')" dialog-button></x-button>
                @endif
            </div>
        </form>
    </x-dialog>

    <x-dialog id="delete-account-dialog" :title="__('Delete account')">
        <form wire:submit.prevent="deleteAccount">
            <p>@lang(__('Are you sure you want to delete your account?'))</p>
            <p>@lang(__('This action cannot be undone. Confirm your password to proceed, you will not be prompted again.'))</p>
            <x-textfield name="password_delete" type="password" wire:model="password_delete" :label="__('Password')"></x-textfield>
            <div class="mdc-dialog__actions">
                <x-button type="submit" :label="__('Delete')" wire:click="deleteAccount" dialog-button></x-button>
            </div>
        </form>
    </x-dialog>

    <x-snackbar id="successMessage"></x-snackbar>
    <x-snackbar id="emailChangeMessage" :timeout="-1"></x-snackbar>

    @if(request('email_changed'))
        <x-snackbar id="email-changed-snackbar"
                    :label="__('Your email address has been changed successfully.')"></x-snackbar>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
              /** @type{import('@material/snackbar').MDCSnackbar} */
              const snackbar = new mdc.snackbar.MDCSnackbar(document.querySelector('#email-changed-snackbar'));
              snackbar.open();
            });
        </script>
    @endif
</x-card>
