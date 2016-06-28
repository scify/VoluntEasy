<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Routing\Redirector;
use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use Illuminate\Contracts\Routing\Middleware;

class Language implements Middleware {

    public function __construct(Application $app, Redirector $redirector, Request $request) {
        $this->app = $app;
        $this->redirector = $redirector;
        $this->request = $request;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        $locale = \Cookie::get('locale');
        if (array_key_exists($locale, $this->app->config->get('app.locales'))) {
            $this->app->setLocale($locale);
        } else {
            \Cookie::queue('locale', 'en', 60 * 24 * 365);
        }

        $locale = $request->segment(1);

        if (array_key_exists($locale, $this->app->config->get('app.locales'))) {
            $cookie = \Cookie::make('locale', $locale, 60 * 24 * 365);
            $this->app->setLocale($locale);
            $segments = $request->segments();
            unset($segments[0]);
            return $this->redirector->to(implode('/', $segments))->withCookie($cookie);
        }
        return $next($request);
    }

}
