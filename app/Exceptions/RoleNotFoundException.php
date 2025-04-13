<?php

namespace App\Services\Exceptions;

use Exception;

class RoleNotFoundException extends Exception
{
    protected $message = 'Role not found';
    protected $code = 404;
}