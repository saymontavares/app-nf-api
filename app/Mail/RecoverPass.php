<?php

namespace App\Mail;

use App\Usuarios;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RecoverPass extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The users instance.
     *
     * @var Usuarios
     */
    public $usuario;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Usuarios $usuarios)
    {
        $this->usuario = $usuarios;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.login.recoverpass');
    }
}