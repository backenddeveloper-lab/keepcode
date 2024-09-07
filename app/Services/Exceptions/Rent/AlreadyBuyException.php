<?php
namespace App\Services\Exceptions\Rent;

use App\Services\Exceptions\ServiceExceptionInterface;
use Exception;

class AlreadyBuyException extends Exception implements ServiceExceptionInterface
{
    public function __construct()
    {
        parent::__construct('Этот товар уже куплен.');
    }

    public function getHttpStatusCode(): int
    {
        return 400;
    }

    public function getErrorCode(): string
    {
        return 'service.rent.already_buyed';
    }
}
