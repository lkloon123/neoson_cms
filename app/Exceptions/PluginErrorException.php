<?php

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

class PluginErrorException extends HttpException
{
    public function __construct(string $message = null, \Exception $previous = null, array $headers = [], ?int $code = 0)
    {
        parent::__construct(400, $message, $previous, $headers, $code);
    }
}
