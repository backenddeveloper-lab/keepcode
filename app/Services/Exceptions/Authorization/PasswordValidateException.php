<?php
namespace App\Services\Exceptions\Authorization;

use App\Services\Exceptions\ServiceExceptionInterface;
use Exception;

class PasswordValidateException extends Exception implements ServiceExceptionInterface
{
    public function __construct()
    {
        parent::__construct('Пароль должен быть не менее 8-ми символов, но и не более 250-ти символов.');
    }

    public function getHttpStatusCode(): int
    {
        return 400;
    }

    public function getErrorCode(): string
    {
        return 'service.authorization.signup.email_validate_password';
    }
}
