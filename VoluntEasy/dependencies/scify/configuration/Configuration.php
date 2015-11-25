<?php namespace Dependencies\scify\configuration;


use Interfaces\ConfigurationInterface;

class Configuration implements ConfigurationInterface {

    private $folderName = 'scify';
    
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
        return null;
    }

    function getAvailabilityFrequenciesJsonPath(){
        return base_path().'/dependencies/'.$this->folderName.'/database/jsondata/availability_frequencies.json';
    }

    function getHowYouLearnedJsonPath(){
        return null;
    }

    function getDriverLicenceTypesJsonPath() {
        return '';
    }
}
