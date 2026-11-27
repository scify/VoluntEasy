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

        // The application services keep state for one request (for example the
        // unit ids of the current user), so there is one instance of each.
        $services = array_merge(glob(app_path('Services/*.php')) ?: [], glob(app_path('Services/Volunteers/*.php')) ?: []);
        foreach ($services as $file) {
            $class = 'App\\Services\\'.str_replace(['/', '.php'], ['\\', ''], substr($file, strlen(app_path('Services/'))));
            $this->app->singleton($class);
        }

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
