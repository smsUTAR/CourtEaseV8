<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class ResetTokenMail extends Mailable
{
    public $verificationCode;

    // Constructor to pass data
    public function __construct($verificationCode)
    {
        $this->verificationCode = $verificationCode;
    }

    public function build()
    {
        return $this->view('\auth\sendEmail')  // Create the email view
                    ->with([
                        'verificationCode' => $this->verificationCode,
                    ]);
    }
}
