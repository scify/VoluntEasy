<?php namespace Dependencies\municipality\configuration;


use Interfaces\ConfigurationInterface;

class Configuration implements ConfigurationInterface {

    private $folderName = 'municipality';

    function getViewsPath() {
        return $this->folderName.'.resources.views';
    }

    function getPartialsPath() {
        return $this->folderName.'.resources.views.volunteers.partials';
    }

    function getInterestsJsonPath(){
        return base_path().'/dependencies/'.$this->folderName.'/database/jsondata/interests.json';
    }

    function getActionRatingsJsonPath(){
        return base_path().'/dependencies/'.$this->folderName.'/database/jsondata/action_ratings.json';
    }

    function getRatingsJsonPath(){
        return base_path().'/dependencies/'.$this->folderName.'/database/jsondata/ratings.json';
    }

    function getAvailabilityFrequenciesJsonPath(){
        return base_path().'/dependencies/'.$this->folderName.'/database/jsondata/availability_frequencies.json';
    }

    function getDriverLicenceTypesJsonPath(){
        return base_path().'/dependencies/'.$this->folderName.'/database/jsondata/driver_license_types.json';
    }

    function getHowYouLearnedJsonPath(){
        return '';
    }
}
