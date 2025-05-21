<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifyEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * El usuario.
     *
     * @var \App\Models\User
     */
    public $user;

    /**
     * Create a new message instance.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $verificationUrl = url('/verify-email/' . $this->user->email_verification_token);

        return $this->subject('Verifica tu cuenta')
                    ->view('emails.verify')
                    ->with([
                        'name' => $this->user->name,
                        'verificationUrl' => $verificationUrl
                    ]);
    }
}