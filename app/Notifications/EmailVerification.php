<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EmailVerification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $code;

    public function __construct($code)
    {
        $this->code = $code;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Verify Your Email - CampusMartBD')
            ->markdown('emails.verify-email', [
                'code' => $this->code
            ]);
    }
}
