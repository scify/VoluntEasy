<?php namespace App\Providers;

use App\Models\Descriptions\AvailabilityFrequencies;
use App\Models\Descriptions\AvailabilityTime;
use App\Models\Descriptions\CommunicationMethod;
use App\Models\Descriptions\DriverLicenceType;
use App\Models\Descriptions\EducationLevel;
use App\Models\Descriptions\Gender;
use App\Models\Descriptions\IdentificationType;
use App\Models\Descriptions\Interest;
use App\Models\Descriptions\Language;
use App\Models\Descriptions\LanguageLevel;
use App\Models\Descriptions\MaritalStatus;
use App\Models\Descriptions\WorkStatus;
use App\Models\Unit;
use App\Models\User;
use App\Models\Volunteer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

/**
 * Responsible to send the data needed for certain views
 *
 * Class ViewComposerServiceProvider
 * @package App\Providers
 */
class ViewComposerServiceProvider extends ServiceProvider {



    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot() {

        //Volunteer Search Page requires all the following data for it's dropdowns etc.
        View::composer('main.volunteers.partials._search', function ($view) {
            $identificationTypes = IdentificationType::pluck('description', 'id')->all();
            $driverLicenseTypes = self::withChoose(DriverLicenceType::pluck('description', 'id')->all());
            $maritalStatuses = self::withChoose(MaritalStatus::pluck('description', 'id')->all());
            $languages = Language::pluck('description', 'id')->all();
            $workStatuses = self::withChoose(WorkStatus::pluck('description', 'id')->all());
            $availabilityFreqs = AvailabilityFrequencies::pluck('description', 'id')->all();
            $genders = self::withChoose(Gender::pluck('description', 'id')->all());
            $educationLevels = self::withChoose(EducationLevel::pluck('description', 'id')->all());
            $interests = self::withChoose(Interest::orderBy('description', 'asc')->pluck('description', 'id')->all());
            $units = self::withChoose(Unit::pluck('description', 'id')->all());
            $cities = self::withChoose(Volunteer::whereNotNull('city')->where('city', '!=', '')->distinct()->orderBy('city')->pluck('city', 'city')->all());
            $countries = self::withChoose(Volunteer::whereNotNull('country')->where('country', '!=', '')->distinct()->orderBy('country')->pluck('country', 'country')->all());

            //create the statuses dropdown
            $statuses = [];
            array_push($statuses, trans('entities/search.choose'));
            array_push($statuses, trans('entities/volunteers.new'));
            array_push($statuses, trans('entities/volunteers.pending'));
            array_push($statuses, trans('entities/volunteers.available'));
            array_push($statuses, trans('entities/volunteers.active'));
            array_push($statuses, trans('entities/volunteers.notAvailable'));
            array_push($statuses, trans('entities/volunteers.blacklisted'));

            //create the ratings dropdown
            $ratings = [];

            $view->with('maritalStatuses', $maritalStatuses)
                ->with('identificationTypes', $identificationTypes)
                ->with('driverLicenseTypes', $driverLicenseTypes)
                ->with('languages', $languages)
                ->with('educationLevels', $educationLevels)
                ->with('genders', $genders)
                ->with('statuses', $statuses)
                ->with('interests', $interests)
                ->with('ratings', $ratings)
                ->with('workStatuses', $workStatuses)
                ->with('cities', $cities)
                ->with('countries', $countries)
                ->with('units', $units);
        });

        //Units Search Page requires all the following data for it's dropdowns etc.
        View::composer('main.units.partials._search', function ($view) {
            $units = self::withChoose(Unit::pluck('description', 'id')->all());
            $users = self::withChoose(User::pluck('name', 'id')->all());

            $view->with('units', $units)->with('users', $users);
        });

        //Actions Search Page requires all the following data for it's dropdowns etc.
        View::composer('main.actions.partials._search', function ($view) {

            $units = self::withChoose(Unit::whereDoesntHave('children')->pluck('description', 'id')->all());

            $view->with('units', $units);
        });

        //Users Search Page requires all the following data for it's dropdowns etc.
        View::composer('main.users.partials._search', function ($view) {

            $units = self::withChoose(Unit::pluck('description', 'id')->all());

            $view->with('units', $units);
        });

        //Data used for the tree
        View::composer('main.tree._tree', function ($view) {
            $tree = app(\App\Services\UnitService::class)->getTree();
            $userUnits = app(\App\Services\UserService::class)->userUnits();

            $view->with('userUnits', $userUnits)->with('tree', $tree);
        });

        //Data used for the volunteers table
        //We need to determine if the user is root
        View::composer('main.volunteers.partials._table', function ($view) {
            $root = false;
            if (app(\App\Services\UserService::class)->isAdmin())
                $root = true;

            //also get an array of the permittedVolunteer ids
            $permittedVolunteers = app(\App\Services\UserService::class)->permittedVolunteersIds();

            $view->with('root', $root)
                ->with('permittedVolunteers', $permittedVolunteers);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register() {

    }

    /**
     * Add the "Choose" option with key 0 at the top of a dropdown list.
     *
     * @param  array<int|string, string>  $options
     * @return array<int|string, string>
     */
    private static function withChoose(array $options): array
    {
        $options[0] = trans('entities/search.choose');
        ksort($options);

        return $options;
    }
}
