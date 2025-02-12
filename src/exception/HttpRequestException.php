<?php

namespace Blerify\Exception;

use Exception;
use Throwable;

class HttpRequestException extends Exception
{
    private array $details;

    public function __construct(string $message = "HTTP request failed", int $code = 500, array $details = [], Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->details = $details;
    }

    public function getDetails(): array
    {
        return $this->details;
    }
}
