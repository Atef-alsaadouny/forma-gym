<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

abstract class BaseServiceException extends Exception
{
    public function __construct(
        string $message = '',
        int $code = 0,
        ?\Throwable $previous = null,
    ) {
        parent::__construct($message, $code, $previous);
    }

    public function getContext(): array
    {
        return [];
    }

    public function render(): array
    {
        return [
            'success' => false,
            'message' => $this->getMessage(),
        ];
    }
}
