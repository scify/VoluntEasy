<?php

namespace App\Providers;

use App\Support\Html\FormBuilder;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Interfaces\ConfigurationInterface;
use Interfaces\RatingInterface;
use Interfaces\ReportsInterface;
use Interfaces\VolunteerInterface;
use InvalidArgumentException;

class AppServiceProvider extends ServiceProvider
{
    /**
     * The deployment flavours. Each one has its own configuration, reports,
     * volunteer and rating implementation in the dependencies/ folder.
     */
    public const MODES = ['scify', 'municipality', 'ekpizo'];

    public function register(): void
    {
        $this->app->singleton(FormBuilder::class, fn ($app) => new FormBuilder($app['url'], $app['session.store']));

        $mode = (string) config('app.mode');
        if (! in_array($mode, self::MODES, true)) {
            throw new InvalidArgumentException("Unknown MODE [{$mode}]. Use one of: ".implode(', ', self::MODES).'.');
        }

        $namespace = "Dependencies\\{$mode}";
        $this->app->bind(ConfigurationInterface::class, "{$namespace}\\configuration\\Configuration");
        $this->app->bind(ReportsInterface::class, "{$namespace}\\services\\ReportsService");
        $this->app->bind(VolunteerInterface::class, "{$namespace}\\services\\VolunteerServiceImpl");
        $this->app->bind(RatingInterface::class, "{$namespace}\\services\\RatingServiceImpl");
    }

    public function boot(): void
    {
        // The views generate URLs with action('UnitController@show') etc.
        URL::setRootControllerNamespace('App\\Http\\Controllers');
        // Migrations are kept in year/month sub-folders.
        $this->loadMigrationsFrom(glob(database_path('migrations/*/*'), GLOB_ONLYDIR) ?: []);
    }
}
