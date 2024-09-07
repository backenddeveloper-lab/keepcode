<?php
namespace App\Services\Exceptions\Authorization;

use App\Services\Exceptions\ServiceExceptionInterface;
use Exception;

class EmailAlreadyExistException extends Exception implements ServiceExceptionInterface
{
    public function __construct()
    {
        parent::__construct('Пользователь с таким почтовым ящиком уже существует.');
    }

    public function getHttpStatusCode(): int
    {
        return 400;
    }

    public function getErrorCode(): string
    {
        return 'service.authorization.signup.email_already_exist';
    }
}
