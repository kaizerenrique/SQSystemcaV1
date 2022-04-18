<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class notificacion extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    private $nombre;
    private $apellido;
    private $cedula;
    private $code;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject, $nombre, $apellido, $cedula, $code)
    {
        $this->subject = $subject;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->cedula = $cedula;
        $this->code = $code;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mail.notificacion', ['nombre' => $this->nombre, 'apellido' => $this->apellido, 'cedula' => $this->cedula, 'code' =>$this->code ]);
    }
}
