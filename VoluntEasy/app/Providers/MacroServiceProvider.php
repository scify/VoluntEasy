<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class MacroServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap the application services.
     * Load all macros from appropriate folder.
	 *
	 * @return void
	 */
	public function boot()
	{
        require base_path() . '/resources/macros/formInput.php';
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}

}
