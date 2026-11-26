<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;

/**
 * Sets the locale from the "locale" cookie.
 *
 * A URL that starts with a locale (for example /en/volunteers) stores that
 * locale in the cookie and redirects to the same URL without the prefix.
 */
class Language
{
    private const COOKIE_MINUTES = 60 * 24 * 365;

    public function handle(Request $request, Closure $next): Response
    {
        /** @var array<string, string> $locales */
        $locales = config('app.locales');

        $locale = $request->cookie('locale');
        if (is_string($locale) && array_key_exists($locale, $locales)) {
            App::setLocale($locale);
        } else {
            Cookie::queue('locale', (string) config('app.locale'), self::COOKIE_MINUTES);
        }

        $prefix = $request->segment(1);
        if ($prefix !== null && array_key_exists($prefix, $locales)) {
            App::setLocale($prefix);
            $segments = array_slice($request->segments(), 1);

            return redirect()->to(implode('/', $segments))
                ->withCookie(Cookie::make('locale', $prefix, self::COOKIE_MINUTES));
        }

        return $next($request);
    }
}
