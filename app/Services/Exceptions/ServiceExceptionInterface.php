<?php
namespace App\Services\Exceptions;

interface ServiceExceptionInterface
{
    public function getHttpStatusCode(): int;

    public function getErrorCode(): string;
}
