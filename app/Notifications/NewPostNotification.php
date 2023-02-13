<?php

namespace App\Notifications;

use App\Models\Post;
use Illuminate\Notifications\Messages\MailMessage;

class NewPostNotification extends BaseNotification
{
    public function __construct(public Post $post)
    {
        parent::__construct($post->user);
    }

    public function toMail(): MailMessage
    {
        return (new MailMessage)
            ->subject(__('New Post'))
            ->greeting(__(':user has posted a new photo', ['user' => $this->getUserDisplayString()]))
            ->line(__(':user posted a new photo', ['user' => $this->getUserDisplayString()]))
            ->action(__('View post'), $this->post->getURL());
    }

    public static function getNotificationDescription(): string
    {
        return __('Someone you follow has posted a new photo');
    }

    public function toArray(): array
    {
        return [...parent::toArray(), 'post_url' => $this->post->getURL()];
    }
}
