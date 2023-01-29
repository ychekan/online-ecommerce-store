<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;

/**
 * Class RegisterNotification
 * @package App\Notifications
 */
class RegisterNotification extends Notification
{
    use Queueable;

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail(mixed $notifiable): MailMessage
    {
        URL::forceRootUrl(Config::get('app.url_frontend'));
        $link = URL::temporarySignedRoute(
            'verification.verify',
            0,
            ['hash' => $notifiable->getVerificationToken()->token]
        );
        return (new MailMessage())
            ->subject(__('Verify Email Address'))
            ->line(__('Please click the button below to verify your email address.'))
            ->action(
                __('Verify Email Address'),
                $link
            )
            ->line(__('If you did not create an account, no further action is required.'));
    }
}
