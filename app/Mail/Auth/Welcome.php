<?php

namespace App\Mail\Auth;

use App\Models\User;

/**
 * Class Welcome
 *
 * @author Vitalii Liubimov <vitalii@liubimov.org>
 * @package App\Mail\Auth
 */
class Welcome extends ForgotPassword
{
    /**
     * @var string
     */
    public static string $description = "The email is for triggering the new user created event";

    /**
     * @var \App\Models\User
     */
    public User $user;

    /**
     * @var string
     */
    public $view = 'emails.welcome';

    /**
     * @var string
     */
    public $subject = 'Welcome to Way2Ocean\'s team';
}
