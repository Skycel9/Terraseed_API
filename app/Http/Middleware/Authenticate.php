<?php

namespace App\Http\Middleware;

use App\Exceptions\AuthorizationException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{

    protected function unauthenticated($request, array $guards) {
        throw new AuthorizationException("Authentication required", json_encode("You need to be authenticated to access this resource. For more information see the documentation"));
    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : route('login');
    }
}
