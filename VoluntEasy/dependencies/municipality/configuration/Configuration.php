<?php namespace Dependencies\municipality\configuration;


use Interfaces\ConfigurationInterface;

class Configuration implements ConfigurationInterface {


    function getViewsPath() {
        return 'municipality.resources.views';
    }

    function getPartialsPath() {
        return 'municipality.resources.views.volunteers.partials';
    }

    function getInterestsJsonPath(){
        return base_path().'/dependencies/municipality/database/jsondata/interests.json';
    }

    function getRatingsJsonPath(){
        return base_path().'/dependencies/municipality/database/jsondata/ratings.json';
    }

    function getAvailabilityFrequenciesJsonPath(){
        return base_path().'/dependencies/municipality/database/jsondata/availability_frequencies.json';
    }

    function getHowYouLearnedJsonPath(){
        return '';
    }
}
