<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AuthenticateCheck;
use App\Http\Controllers\Api\Rent;
use App\Http\Controllers\Api\Auth;


Route::post('/login', [Auth::class, 'login']);
Route::post('/register', [Auth::class, 'register']);
Route::post('/logout', [Auth::class, 'logout'])->middleware(AuthenticateCheck::class);

Route::post('/items/{item}/buy', [Rent::class, 'buy'])->middleware(AuthenticateCheck::class);
Route::post('/items/{item}/rent', [Rent::class, 'rent'])->middleware(AuthenticateCheck::class);
Route::get('/items/{item}/status', [Rent::class, 'itemStatus'])->middleware(AuthenticateCheck::class);
Route::get('/user/transactions', [Rent::class, 'transactionHistory'])->middleware(AuthenticateCheck::class);


