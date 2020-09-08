<?php

namespace App\Jobs;

use App\Mail\AlertEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $email, $deposits;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email, $deposits)
    {
        $this->email = $email;
        $this->deposits = $deposits;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->email)->send(new AlertEmail($this->deposits));
    }
}
