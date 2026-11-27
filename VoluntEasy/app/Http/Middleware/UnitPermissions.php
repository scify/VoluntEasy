<?php namespace App\Http\Middleware;

use Closure;

class UnitPermissions {

    private \App\Services\UserService $userService;

    public function __construct(\App\Services\UserService $userService) {
        $this->userService = $userService;
    }

	/**
	 * Handle an incoming request.
     * Check if the requested unit is assigned to the current user.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
        //get user units
        $userUnits = $this->userService->userUnits();

        //if the requested unit is not assigned to user, return error page
        if(!in_array( $request->route()->parameter('id'), $userUnits))
            return response()->view('errors.550', [], 550);

        return $next($request);
	}
}
