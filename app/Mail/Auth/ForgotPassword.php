<?php

namespace App\Mail\Auth;

use App\Mail\Traits\Templatable;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Class ForgotPassword
 *
 * @author Vitalii Liubimov <vitalii@liubimov.org>
 * @package App\Mail\Auth
 */
class ForgotPassword extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels, Templatable;

    /**
     * @var string
     */
    public static string $description = "The email is for triggering the forgot password workflow";

    /**
     * @var \App\Models\User
     */
    public User $user;

    /**
     * @var string
     */
    public $view = 'emails.password_reset';

    /**
     * @var string
     */
    public $subject = 'Password reset';


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user->refresh();
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->sendFromTemplate(['user' => $this->user, 'url' => $this->user->resetPasswordLink]);
    }
}
