<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson()
            ? new JsonResponse([
                'error'=>'Unauthenticated',
                'message'=>"Try to login first or create you account if you don't have one",
                'login_url'=>'/login',
                'register_url'=>'/register'
            ],401)
            : route('login');
    }
}
