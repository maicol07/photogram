<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class EmailChangeNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(protected User $user)
    {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via(mixed $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(AnonymousNotifiable $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject(__('Email Change'))
            ->greeting(__('Your email has been changed'))
            ->line(__('Someone, presumably you, has changed your account email! If you did not do this, you can ignore safely this email. If you did, please verify your new email address by clicking the button below (this link will expire in 1 hour).'))
            ->action('Verify Email', $this->verifyRoute($notifiable));
    }

    /**
     * Returns the Reset URl to send in the Email
     *
     * @param AnonymousNotifiable $notifiable
     * @return string
     */
    protected function verifyRoute(AnonymousNotifiable $notifiable): string
    {
        return URL::temporarySignedRoute('user.email-change-verify', now()->addHour(), [
            'user' => $this->user,
            'email' => $notifiable->routes['mail']
        ]);
    }
}
