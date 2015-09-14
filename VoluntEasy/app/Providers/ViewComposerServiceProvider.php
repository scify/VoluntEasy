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
use App\Models\Descriptions\VolunteerStatus;
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
            $identificationTypes = IdentificationType::all()->lists('description', 'id');
            $driverLicenseTypes = DriverLicenceType::all()->lists('description', 'id');
            $maritalStatuses = MaritalStatus::all()->lists('description', 'id');
            $languages = Language::all()->lists('description', 'id');
            $langLevels = LanguageLevel::all()->lists('description', 'id');
            $workStatuses = WorkStatus::all()->lists('description', 'id');
            $availabilityFreqs = AvailabilityFrequencies::all()->lists('description', 'id');
            $availabilityTimes = AvailabilityTime::all()->lists('description', 'id');
            $genders = Gender::all()->lists('description', 'id');
            $commMethod = CommunicationMethod::all()->lists('description', 'id');
            $educationLevels = EducationLevel::all()->lists('description', 'id');
            $interests = Interest::orderBy('description', 'asc')->lists('description', 'id');
            $units = Unit::all()->lists('description', 'id');


            $maritalStatuses[0] = '[- επιλέξτε -]';
            $educationLevels[0] = '[- επιλέξτε -]';
            $genders[0] = '[- επιλέξτε -]';
            $interests[0] = '[- επιλέξτε -]';
            $units[0] = '[- επιλέξτε -]';
            ksort($maritalStatuses);
            ksort($educationLevels);
            ksort($genders);
            ksort($interests);
            ksort($units);

            //create the statuses dropdown
            $statuses = [];
            array_push($statuses, '[- επιλέξτε -]');
            array_push($statuses, 'Νέος');
            array_push($statuses, 'Υπό ένταξη');
            array_push($statuses, 'Διαθέσιμος');
            array_push($statuses, 'Ενεργός');
            array_push($statuses, 'Μη Διαθέσιμος');
            array_push($statuses, 'Blacklisted');

            //create the ratings dropdown
            //TODO: change descriptions
            $ratings = [];
            array_push($ratings, '[- επιλέξτε -]');
            array_push($ratings, 'Συνέπεια αύξουσα');
            array_push($ratings, 'Συνέπεια φθίνουσα');
            array_push($ratings, 'Στυλ αύξουσα');
            array_push($ratings, 'Στυλ φθίνουσα');
            array_push($ratings, 'Αγάπη για γάτες αύξουσα');
            array_push($ratings, 'Αγάπη για γάτες φθίνουσα');

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
            $units = Unit::all()->lists('description', 'id');
            $users = User::all()->lists('name', 'id');

            $units[0] = '[- επιλέξτε -]';
            ksort($units);
            $users[0] = '[- επιλέξτε -]';
            ksort($users);

            $view->with('units', $units)->with('users', $users);
        });

        //Actions Search Page requires all the following data for it's dropdowns etc.
        View::composer('main.actions.partials._search', function ($view) {

            $units = Unit::whereDoesntHave('children')->lists('description', 'id');

            $units[0] = '[- επιλέξτε -]';
            ksort($units);

            $view->with('units', $units);
        });

        //Users Search Page requires all the following data for it's dropdowns etc.
        View::composer('main.users.partials._search', function ($view) {

            $units = Unit::all()->lists('description', 'id');

            $units[0] = '[- επιλέξτε -]';
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
