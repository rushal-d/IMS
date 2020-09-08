<?php

namespace App\Mail;

use App\Deposit;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AlertEmail extends Mailable
{
    use Queueable, SerializesModels;
    protected $deposits;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($deposits)
    {
        $this->deposits = $deposits;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.alert')->with([
            'deposits' => $this->deposits
        ]);
    }
}
