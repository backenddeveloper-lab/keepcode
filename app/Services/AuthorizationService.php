<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserToken;
use App\Services\Exceptions\Authorization\EmailAlreadyExistException;
use App\Services\Exceptions\Authorization\EmailValidateException;
use App\Services\Exceptions\Authorization\LoginException;
use App\Services\Exceptions\Authorization\PasswordValidateException;
use App\Services\Exceptions\Authorization\SessionTokenExpiredException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthorizationService
{
    public function register($email, $password)
    {
        $this->emailValidate($email);
        $this->emailExistCheck($email);
        $this->passwordValidate($password);

        $user = User::create([
            'name' => 'JustUser'.rand(1000, 9999),
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        return $this->generateToken($user);
    }

    public function login($email, $password)
    {
        $user = User::where('email', $email)->first();

        if (!$user || !Hash::check($password, $user->password)) {
            throw new LoginException();
        }

        $token = bin2hex(random_bytes(64) . $user->id . time());

        UserToken::create([
            'user_id' => $user->id,
            'token' => hash('sha256', $token),
            'expires_at' => now()->addHours(2),
        ]);

        return $token;
    }

    public function verifyToken($token)
    {
        if(empty($token)){
            throw new SessionTokenExpiredException();
        }

        $userToken = UserToken::where('token', hash('sha256', $token))
            ->where('expires_at', '>', now())
            ->first();

        if($userToken){
            return $userToken->user;
        }else{
            throw new SessionTokenExpiredException();
        }
    }

    public function logout(string $token)
    {
        return UserToken::where('token', hash('sha256', $token))->delete();
    }

    protected function generateToken(User $user)
    {
        $token = bin2hex(random_bytes(64));

        UserToken::create([
            'user_id' => $user->id,
            'token' => hash('sha256', $token),
            'expires_at' => now()->addHours(2),
        ]);

        return $token;
    }

    private function emailExistCheck($email){
        $user = User::where('email', $email)->first();
        if(!is_null($user)){
            throw new EmailAlreadyExistException();
        }
    }

    private function emailValidate($email){
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            throw new EmailValidateException();
        }
    }

    private function passwordValidate($password){
        if(strlen($password) < 8 || strlen($password) > 250){
            throw new PasswordValidateException();
        }
    }
}
