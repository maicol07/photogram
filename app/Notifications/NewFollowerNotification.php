<?php

namespace App\Notifications;


use Illuminate\Notifications\Messages\MailMessage;

class NewFollowerNotification extends BaseNotification
{
    public function toMail(): MailMessage
    {
        return (new MailMessage)
            ->subject(__('New Follower'))
            ->greeting(__('You have a new follower'))
            ->line(__(':user started following you!', ['user' => $this->user->username]));
    }

    public static function getNotificationDescription(): string
    {
        return __('Someone started following you');
    }
}
