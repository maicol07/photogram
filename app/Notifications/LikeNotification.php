<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;

class LikeNotification extends BaseNotification
{
    public function toMail(): MailMessage
    {
        return (new MailMessage)
            ->subject(__('New Like'))
            ->greeting(__('You have a new like'))
            ->line(__(':user liked your post', ['user' => $this->user->username]));
    }

    public static function getNotificationDescription(): string
    {
        return __('A new like is added to your photo');
    }
}
