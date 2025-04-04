<?php

namespace App\Mail;

use App\Mail\Auth\ForgotPassword;
use App\Mail\Traits\Templatable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class JustTesting extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels, Templatable;

    /**
     * @var string
     */
    public static $description = "Email for testing email system";

    /**
     * @var string
     */
    public $view = 'emails.test';

    /**
     * @var string
     */
    public $subject = 'Test email';


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->sendFromTemplate([]);
    }

}
