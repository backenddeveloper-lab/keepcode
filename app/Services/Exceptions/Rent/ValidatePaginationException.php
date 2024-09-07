<?php
namespace App\Services\Exceptions\Rent;

use App\Services\Exceptions\ServiceExceptionInterface;
use Exception;

class ValidatePaginationException extends Exception implements ServiceExceptionInterface
{
    public function __construct()
    {
        parent::__construct('Колличество записей на одной странице должно быть целым числом и не должно быть меньше 1.');
    }

    public function getHttpStatusCode(): int
    {
        return 400;
    }

    public function getErrorCode(): string
    {
        return 'service.rent.pagination_error';
    }
}
