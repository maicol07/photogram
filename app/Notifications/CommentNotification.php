<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;

class CommentNotification extends BaseNotification
{
    public function toMail(): MailMessage
    {
        return (new MailMessage)
            ->subject(__('New Comment'))
            ->greeting(__('You have a new comment'))
            ->line(__(':user commented your photo', ['user' => $this->getUserDisplayString()]));
    }

    public static function getNotificationDescription(): string
    {
        return __('A new comment is added to your photo');
    }
}
