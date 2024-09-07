<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AuthorizationService;

class Auth extends Controller
{
    protected $authService;

    public function __construct(AuthorizationService $authService)
    {
        $this->authService = $authService;
    }

    public function register(Request $request)
    {
        return $this->send([
            'token' => $this->authService->register(
                $request->email,
                $request->password
            )
        ]);
    }

    public function login(Request $request)
    {
        return $this->send([
            'token' => $this->authService->login(
                $request->email,
                $request->password
            )
        ]);
    }

    public function logout(Request $request)
    {
        $this->authService->logout($request->bearerToken());
        return $this->send([]);
    }
}
