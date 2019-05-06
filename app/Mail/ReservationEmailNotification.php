<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Auth;
class ReservationEmailNotification extends Mailable
{
    use Queueable, SerializesModels;
    public $reservation;
    public $message;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($reservation, $message)
    {
        //
        $this->reservation = $reservation;
        $this->message = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $reservation = $this->reservation;
        $message = $this->message;

        return $this->view('email.reservation', compact('reservation', 'message'));
    }
}
