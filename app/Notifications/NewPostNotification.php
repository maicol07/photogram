<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;

class NewPostNotification extends BaseNotification
{
    public function toMail(): MailMessage
    {
        return (new MailMessage)
            ->from('noreply@photogram')
            ->subject(__('New Post'))
            ->greeting(__(':user has posted a new photo', ['user' => $this->user->username]))
            ->line(__(':user posted a new photo', ['user' => $this->user->username]));
    }

    public static function getNotificationDescription(): string
    {
        return __('Someone you follow has posted a new photo');
    }
}
