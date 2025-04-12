<?php

namespace App\Services\Exceptions;

use Exception;

class UserNotFoundException extends Exception
{
    protected $message = 'User not found';
    protected $code = 404;
}