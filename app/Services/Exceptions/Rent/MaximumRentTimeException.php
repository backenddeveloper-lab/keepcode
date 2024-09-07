<?php
namespace App\Services\Exceptions\Rent;

use App\Services\Exceptions\ServiceExceptionInterface;
use Exception;

class MaximumRentTimeException extends Exception implements ServiceExceptionInterface
{
    public function __construct()
    {
        parent::__construct('Максимальный период аренды не может превышать 24 часа.');
    }

    public function getHttpStatusCode(): int
    {
        return 400;
    }

    public function getErrorCode(): string
    {
        return 'service.rent.maximum_rent_time';
    }
}
