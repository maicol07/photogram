<?php

namespace App\Http\Livewire\User;

use App\Http\Livewire\InsidePage;
use App\Http\Livewire\Traits\MDCDialogFeatures;
use App\Http\Livewire\Traits\MDCSnackbarFeatures;
use App\Models\User;
use App\Notifications\BaseNotification;
use App\Notifications\EmailChangeNotification;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Kcs\ClassFinder\Finder\Psr4Finder;

class Settings extends InsidePage
{
    use MDCDialogFeatures;
    use MDCSnackbarFeatures;

    public User $user;
    public string $current_password = '';
    public string $password;
    public string $password_confirmation;
    public array $notifications = [];
    public string $password_delete;

    public $rules = [
        'user.name' => 'required|string',
        'user.surname' => 'required|string',
        'user.email' => 'required|email|unique:App\Models\User,email',
        'user.username' => 'required|max:20|min:4|string|unique:App\Models\User,username',
        'current_password' => 'required|max:24|min:8|string|current_password',
        'password' => 'required|max:24|min:8|string',
        'password_confirmation' => 'required|same:password',
        'password_delete' => 'required|max:24|min:8|string|current_password',
    ];

    public function mount(): void
    {
        $this->user = auth()->user();
    }

    public function getTitle(): string
    {
        return __('Settings');
    }

    public function page(): View
    {
        return view('livewire.user.settings');
    }

    public function openCategory(string $slug): void
    {
        $this->openDialog("$slug-dialog");
    }

    public function saveAccountSettings(): void
    {
        if (!$this->user->originalIsEquivalent('email')) {
            $this->validateOnly('user.email');
            // Send the email to the user
            Notification::route('mail', $this->user->email)
                ->notify(new EmailChangeNotification($this->user));
            $this->user->email = $this->user->getOriginal('email');
            $this->openSnackbar('emailChangeMessage', __('An email has been sent to your new email address. Please follow the instructions to complete the email change.'), 'emailChange');
        }
        if (!$this->user->originalIsEquivalent('username')) {
            $this->validateOnly('user.username');
        }

        $this->user->save();
        $this->closeDialog('account-dialog');
        $this->openSnackbar('successMessage', __('Username updated successfully.'));
    }

    public function saveSecuritySettings(): void
    {
        if ($this->user->password) {
            $this->validateOnly('current_password');
        }
        $this->validateOnly('password');
        $this->validateOnly('password_confirmation');
        $this->user->password = Hash::make($this->password);
        $this->user->save();
        $this->closeDialog('security-dialog');
        $this->openSnackbar('successMessage', __('Password updated successfully.'));
    }

    public function saveNotificationsSettings(): void
    {
        foreach ($this->notifications as $key => $value) {
            $arr = [];
            foreach ($value as $k => $v) {
                if ($v) {
                    $arr[] = $k;
                }
            }
            $this->user->settings()->set("notifications.$key", $arr);
        }
        $this->closeDialog('notifications-dialog');
        $this->openSnackbar('successMessage', __('Notifications settings updated successfully.'));
    }

    public function deleteAccount(): void
    {
        $this->validateOnly('password_delete');
        $this->user->delete();
        auth()->logout();
        session()->flash('message', __('Your account has been deleted successfully. We are sorry to see you go.'));
        $this->redirectRoute('inside.home');
    }

    public function updated(string $propertyName): void
    {
        if (($this->beforeFirstDot($propertyName) === 'user') && $this->getPropertyValue($propertyName) === $this->user->getOriginal($this->afterFirstDot($propertyName))) {
            return;
        }
        $this->validateOnly($propertyName);
    }

    public function linkGoogleAccount(): void
    {
        session()->put('from', 'inside.settings');
        $this->redirectRoute('auth.redirect-provider', 'google');
    }

    public function unlinkGoogleAccount(): void
    {
        $this->user->google_id = null;
        $this->user->save();
        $this->closeDialog('google-dialog');
        $this->openSnackbar('successMessage', __('Google account unlinked successfully.'));
    }

    public function getCategories(): array
    {
        return [
            'account' => [
                'icon' => 'account-circle',
                'headline' => __('Account'),
                'supportingText' => __('Edit your account details, such as your personal details and your contact information.'),
            ],
            'security' => [
                'icon' => 'shield-lock-outline',
                'headline' => __('Security'),
                'supportingText' => __('Manage your account security, such as your password.'),
            ],
            'notifications' => [
                'icon' => 'bell-ring-outline',
                'headline' => __('Notifications'),
                'supportingText' => __('Manage your notifications settings: choose which notifications to receive and how you want to receive them.'),
            ],
            'google' => [
                'icon' => 'google',
                'headline' => __('Google'),
                'supportingText' => __('Link or unlink your Google account with your Photogram account.'),
                'trailingIcon' => 'link-variant',
            ],
            'delete-account' => [
                'icon' => 'delete-outline',
                'headline' => __('Delete account'),
                'supportingText' => __('Delete your account permanently.'),
                'danger' => true,
                'trailingIcon' => false
            ],
        ];
    }

    public function getNotificationsTypes(): Psr4Finder
    {
        $this->user->settings()->temporarilyDisableCache();
        $notificationTypes = (new Psr4Finder('App\\Notifications', app_path('Notifications')))
            ->subclassOf(BaseNotification::class);
        $notificationMethods = ['mail', 'database'];
        foreach ($notificationTypes as $notificationType => $reflectionClass) {
            $user_settings = $this->user->settings()->get("notifications.$notificationType") ?? $notificationMethods;
            foreach ($notificationMethods as $notificationMethod) {
                if (!Arr::has($this->notifications, "$notificationType.$notificationMethod")) {
                    Arr::set($this->notifications, "$notificationType.$notificationMethod", in_array($notificationMethod, $user_settings, true));
                }
            }
        }
        return $notificationTypes;
    }
}
