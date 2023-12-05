<?php

namespace App\Exceptions\Api\Auth;

use App\Traits\JsonRenderException;
use Exception;

class AuthException extends Exception
{
    use JsonRenderException;
}
