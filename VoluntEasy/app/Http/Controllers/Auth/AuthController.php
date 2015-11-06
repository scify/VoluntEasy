<?php namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller {

    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers;

    private $redirectPath = '/';

    private $configuration;

    /**
     * Create a new authentication controller instance.
     *
     * @param  \Illuminate\Contracts\Auth\Guard $auth
     * @param  \Illuminate\Contracts\Auth\Registrar $registrar
     */
    public function __construct() {
        //get an instance of the configuration interface
        $this->configuration = \App::make('Interfaces\ConfigurationInterface');

        $this->middleware('guest', ['except' => 'getLogout']);
    }


    /**
     * View the login page.
     * We override the getLogin() of the trait in order to retrieve
     * the path needed to display the footer logos at the login page
     *
     * @return \Illuminate\View\View
     */
    public function getLogin() {

        $footerLogoPath = $this->configuration->getViewsPath().'._login_footer';

        return view('auth/login', compact('footerLogoPath'));
    }

}
