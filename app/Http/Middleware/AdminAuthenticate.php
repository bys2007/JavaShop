<?php

namespace App\Http\Middleware;

use Filament\Http\Middleware\Authenticate as FilamentAuthenticate;
use Illuminate\Http\Request;

class AdminAuthenticate extends FilamentAuthenticate
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo($request): ?string
    {
        return route('admin.login');
    }
}
