<?php
namespace App\Services\Exceptions\Authorization;

use App\Services\Exceptions\ServiceExceptionInterface;
use Exception;

class SessionTokenExpiredException extends Exception implements ServiceExceptionInterface
{
    public function __construct()
    {
        parent::__construct('Сессия не действительна. Авторизируйтесь заново');
    }

    public function getHttpStatusCode(): int
    {
        return 401;
    }

    public function getErrorCode(): string
    {
        return 'service.authorization.token_expired';
    }
}
