<?php namespace App\Http\Middleware;

use App\Services\Facades\UserService;
use Closure;

class UnitPermissions {

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
        $userUnits = UserService::userUnits();

        //if the requested unit is not assigned to user, return error page
        if(!in_array( $request->route()->getParameter('id'), $userUnits))
            return response()->view('errors.550', [], 550);

        return $next($request);
	}
}
