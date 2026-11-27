<?php

namespace App\Http\Middleware;

use App\Services\UserService;
use Closure;
use Illuminate\Http\Request;

class UnitPermissions
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Handle an incoming request.
     * Check if the requested unit is assigned to the current user.
     *
     * @param  Request  $request
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // get user units
        $userUnits = $this->userService->userUnits();

        // if the requested unit is not assigned to user, return error page
        if (! in_array($request->route()->parameter('id'), $userUnits)) {
            return response()->view('errors.550', [], 550);
        }

        return $next($request);
    }
}
