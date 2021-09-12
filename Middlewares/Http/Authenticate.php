<?php

namespace App\Ship\Middlewares\Http;

use Apiato\Core\Exceptions\AuthenticationException;
use Exception;
use Illuminate\Auth\Middleware\Authenticate as LaravelAuthenticate;
use Illuminate\Support\Facades\Config;

class Authenticate extends LaravelAuthenticate
{
    /**
     * @throws \Illuminate\Auth\AuthenticationException
     * @throws AuthenticationException
     */
    protected function authenticate($request, array $guards): void
    {
        try {
            parent::authenticate($request, $guards);
        } catch (Exception) {
            if ($request->expectsJson()) {
                throw new AuthenticationException();
            } else {
                $this->unauthenticated($request, $guards);
            }
        }
    }

    protected function redirectTo($request): ?string
    {
        return route(Config::get('appSection-authentication.login-page-url'));
    }
}
