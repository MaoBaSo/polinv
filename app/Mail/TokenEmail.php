<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TokenEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $TOKEN_public;
    public $usuario;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($TOKEN_public, $usuario)
    {
        $this->TOKEN_public = $TOKEN_public;
        $this->usuario = $usuario;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.send-token');
    }
}
