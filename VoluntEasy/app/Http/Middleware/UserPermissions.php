<?php

namespace App\Http\Middleware;

use App\Services\UserService;
use Closure;
use Illuminate\Http\Request;

class UserPermissions
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Handle an incoming request.
     * Check if the requested user can be edited by the logged in user.
     *
     * @param  Request  $request
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // get user units
        $userUnits = $this->userService->permittedUsersIds();

        // if the requested user cannot be editted ny the logged in user, return error page
        if (! in_array($request->route()->parameter('id'), $userUnits)) {
            return response()->view('errors.550', [], 550);
        }

        return $next($request);
    }
}
