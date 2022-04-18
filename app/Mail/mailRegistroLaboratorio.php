<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class mailRegistroLaboratorio extends Mailable
{
    use Queueable, SerializesModels;

    public $subject = 'Registro de Laboratorio';
    private $name;
    private $email;
    private $password;
    private $token;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $email, $password, $token)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mail.mailRegistroLaboratorio', ['name' => $this->name, 'email' => $this->email, 'password' => $this->password, 'token' =>$this->token ]);
    }
}
