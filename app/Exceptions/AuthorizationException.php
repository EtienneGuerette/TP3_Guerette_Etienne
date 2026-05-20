<?php

namespace App\Exceptions;

use Exception;

class AuthorizationException extends Exception
{
    public function status()
    {
        return UNAUTHORIZED;
    }

    public function message()
    {
        return "Vous n'êtes pas authentifiés";
    }
}
