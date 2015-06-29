<?php namespace App\Http\Middleware;

use App\Services\Facades\UnitService;
use App\Services\Facades\UserService;
use Closure;
use Illuminate\Http\RedirectResponse;

class UnitPermissions {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
        $userUnits = UserService::userUnits();

        if(!in_array( $request->route()->getParameter('id'), $userUnits))
            return response()->view('errors.550', [], 550);

        return $next($request);
	}

}
