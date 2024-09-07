<?php
namespace App\Services\Exceptions\Authorization;

use App\Services\Exceptions\ServiceExceptionInterface;
use Exception;

class EmailValidateException extends Exception implements ServiceExceptionInterface
{
    public function __construct()
    {
        parent::__construct('Почтовый ящик введен не корректно.');
    }

    public function getHttpStatusCode(): int
    {
        return 400;
    }

    public function getErrorCode(): string
    {
        return 'service.authorization.signup.email_validate_error';
    }
}
