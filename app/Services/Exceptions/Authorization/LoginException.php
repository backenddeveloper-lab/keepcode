<?php
namespace App\Services\Exceptions\Authorization;

use App\Services\Exceptions\ServiceExceptionInterface;
use Exception;

class LoginException extends Exception implements ServiceExceptionInterface
{
    public function __construct()
    {
        parent::__construct('Логин или пароль введены неверно.');
    }

    public function getHttpStatusCode(): int
    {
        return 400;
    }

    public function getErrorCode(): string
    {
        return 'service.authorization.login_error';
    }
}
