<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailVerification extends Mailable
{
    use Queueable, SerializesModels;

    public $code;
    public $user;

    public function __construct($code, $user = null)
    {
        $this->code = $code;
        $this->user = $user;
    }

    public function build()
    {
        return $this->subject('Your CampusMart Verification Code')
            ->view('emails.verification');
    }
}
