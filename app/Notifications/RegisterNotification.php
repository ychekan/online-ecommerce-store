<?php
declare(strict_types=1);

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;

/**
 * Class RegisterNotification
 * @package App\Notifications
 */
class RegisterNotification extends Notification implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via(mixed $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return MailMessage
     */
    public function toMail(mixed $notifiable): MailMessage
    {
        $mailMessage = new MailMessage();

        URL::forceRootUrl(Config::get('app.url_frontend'));
        $link = URL::temporarySignedRoute(
            'verify-email',
            now()->addSeconds(env('EXP_TIME_FOR_CONFIRM_EMAIL')),
            ['token' => $notifiable->getVerificationToken()->token, 'id' => $notifiable->id]
        );

        $mailMessage->subject('Verify Email Address');
        $mailMessage->line('Please click the button below to verify your email address.');
        $mailMessage->action('Verify Email Address', $link);

        return $mailMessage;
    }
}
