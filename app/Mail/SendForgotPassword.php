<?php

namespace App\Mail;

use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendForgotPassword extends Mailable
{
    use Queueable, SerializesModels;

    private $token;
    private $email;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($token, $email)
    {
        $this->token = $token;
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('waggner.447@gmail.com', 'WHI')
            ->subject('WHI, Recuperação de senha')
            ->view('emails.forgot-password', [
                'token'=> $this->token
            ]); 
    }
}
