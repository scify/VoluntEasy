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
use App\Services\Facades\UnitService;
use App\Services\Facades\UserService;
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
            $identificationTypes = IdentificationType::lists('description', 'id')->all();
            $driverLicenseTypes = DriverLicenceType::lists('description', 'id')->all();
            $maritalStatuses = MaritalStatus::lists('description', 'id')->all();
            $languages = Language::lists('description', 'id')->all();
            $langLevels = LanguageLevel::lists('description', 'id')->all();
            $workStatuses = WorkStatus::lists('description', 'id')->all();
            $availabilityFreqs = AvailabilityFrequencies::lists('description', 'id')->all();
            $availabilityTimes = AvailabilityTime::lists('description', 'id')->all();
            $genders = Gender::lists('description', 'id')->all();
            $commMethod = CommunicationMethod::lists('description', 'id')->all();
            $educationLevels = EducationLevel::lists('description', 'id')->all();
            //$interests = Interest::orderBy('description', 'asc')->lists('description', 'id')->all();
            $interests = Interest::orderBy('description', 'asc')->lists('description', 'id')->all();
            $units = Unit::lists('description', 'id')->all();


            $maritalStatuses[0] = trans('entities/search.choose');
            $educationLevels[0] = trans('entities/search.choose');
            $genders[0] = trans('entities/search.choose');
            $interests[0] = trans('entities/search.choose');
            $units[0] = trans('entities/search.choose');
            ksort($maritalStatuses);
            ksort($educationLevels);
            ksort($genders);
            ksort($interests);
            ksort($units);

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
                ->with('units', $units);
        });


        //Units Search Page requires all the following data for it's dropdowns etc.
        View::composer('main.units.partials._search', function ($view) {
            $units = Unit::lists('description', 'id')->all();
            $users = User::lists('name', 'id')->all();

            $units[0] = trans('entities/search.choose');
            ksort($units);
            $users[0] = trans('entities/search.choose');
            ksort($users);

            $view->with('units', $units)->with('users', $users);
        });

        //Actions Search Page requires all the following data for it's dropdowns etc.
        View::composer('main.actions.partials._search', function ($view) {

            $units = Unit::whereDoesntHave('children')->lists('description', 'id')->all();

            $units[0] = trans('entities/search.choose');
            ksort($units);

            $view->with('units', $units);
        });

        //Users Search Page requires all the following data for it's dropdowns etc.
        View::composer('main.users.partials._search', function ($view) {

            $units = Unit::lists('description', 'id')->all();

            $units[0] = trans('entities/search.choose');
            ksort($units);

            $view->with('units', $units);
        });

        //Data used for the tree
        View::composer('main.tree._tree', function ($view) {
            $tree = UnitService::getTree();
            $userUnits = UserService::userUnits();

            $view->with('userUnits', $userUnits)->with('tree', $tree);
        });

        //Data used for the volunteers table
        //We need to determine if the user is root
        View::composer('main.volunteers.partials._table', function ($view) {
            $root = false;
            if (UserService::isAdmin())
                $root = true;

            //also get an array of the permittedVolunteer ids
            $permittedVolunteers = UserService::permittedVolunteersIds();


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

}
