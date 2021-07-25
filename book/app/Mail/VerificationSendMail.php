<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerificationSendMail extends Mailable
{
    use Queueable, SerializesModels;
    
    public $user;
    public $reference;

    public function __construct(User $user, $reference)
    {
        $this->user         = $user;
        $this->reference    = $reference;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Email Verifikasi')
            ->view('mail.SendVerificationMail');
    }
}
