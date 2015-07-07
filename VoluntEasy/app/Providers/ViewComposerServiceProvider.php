<?php namespace App\Providers;

use App\Models\Descriptions\AvailabilityFrequencies;
use App\Models\Descriptions\AvailabilityTime;
use App\Models\Descriptions\CommunicationMethod;
use App\Models\Descriptions\DriverLicenceType;
use App\Models\Descriptions\EducationLevel;
use App\Models\Descriptions\Gender;
use App\Models\Descriptions\IdentificationType;
use App\Models\Descriptions\Language;
use App\Models\Descriptions\LanguageLevel;
use App\Models\Descriptions\MaritalStatus;
use App\Models\Descriptions\VolunteerStatus;
use App\Models\Descriptions\WorkStatus;
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
            $edLevel = EducationLevel::all()->lists('description', 'id');

            $volunteerStatuses = VolunteerStatus::all()->lists('description', 'id');

            $view->with('maritalStatuses', $maritalStatuses)
                ->with( 'identificationTypes', $identificationTypes)
                ->with('driverLicenseTypes', $driverLicenseTypes)
                ->with('languages', $languages)
                ->with('volunteerStatuses', $volunteerStatuses);
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
