<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification
{
    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }


    public function toMail($notifiable)
    {
        $url = config('app.frontend_url') . '/reset-password?token=' . $this->token . '&email=' . urlencode($notifiable->email);

        return (new MailMessage)
            ->subject('Reset Your Password')
            ->line('You requested a password reset.')
            ->action('Reset Password', $url)
            ->line('If you didn\'t request this, no further action is required.');
    }

}
