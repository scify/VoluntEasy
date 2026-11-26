<?php

use App\Http\Middleware\Language;
use App\Http\Middleware\UnitPermissions;
use App\Http\Middleware\UserPermissions;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Global, so that /el/... and /en/... (the language links) are handled
        // before routing. It runs before cookie decryption, so the "locale"
        // cookie (only "en" or "el") is not encrypted.
        $middleware->append(Language::class);
        $middleware->encryptCookies(except: ['locale']);

        // The JSON API is called from other sites, so it has no CSRF token.
        $middleware->validateCsrfTokens(except: [
            'api/*',
        ]);

        $middleware->redirectGuestsTo('/auth/login');
        $middleware->redirectUsersTo('/');

        $middleware->alias([
            'permissions.unit' => UnitPermissions::class,
            'permissions.user' => UserPermissions::class,
        ]);
    })
    ->withSchedule(function (Schedule $schedule): void {
        $schedule->command('checkActions')->daily();
        $schedule->command('checkVolunteers')->daily();
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );

        // An expired CSRF token sends the user back to the form with the old input.
        $exceptions->render(function (HttpException $e, Request $request) {
            if ($e->getStatusCode() === 419 && ! $request->expectsJson()) {
                return back()->withInput($request->except('password', '_token'))
                    ->with('error', 'Your session was expired');
            }

            return null;
        });
    })->create();
