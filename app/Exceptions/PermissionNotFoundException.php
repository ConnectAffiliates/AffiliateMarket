<?php

namespace App\Services\Exceptions;

use Exception;

class PermissionNotFoundException extends Exception
{
    protected $message = 'Permission not found';
    protected $code = 404;
}