<?php namespace App\Http\Middleware;

use App\Services\Facades\UserService;
use Closure;

class UserPermissions {

	/**
	 * Handle an incoming request.
     * Check if the requested user can be edited by the logged in user.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
        //get user units
        $userUnits = UserService::permittedUsersIds();

        //if the requested user cannot be editted ny the logged in user, return error page
        if(!in_array( $request->route()->getParameter('id'), $userUnits))
            return response()->view('errors.550', [], 550);

        return $next($request);
	}
}
