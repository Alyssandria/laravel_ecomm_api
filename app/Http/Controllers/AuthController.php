<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;


class AuthController extends Controller
{
    public function register(RegisterRequest $request, AuthService $auth) {
        return $auth->register($request->validated());
    }
}
