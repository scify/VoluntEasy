<?php namespace Dependencies\ekpizo\configuration;


use Interfaces\ConfigurationInterface;

class Configuration implements ConfigurationInterface {

    function getViewsPath() {
        return 'ekpizo.resources.views';
    }

    function getPartialsPath() {
        return 'ekpizo.resources.views.volunteers.partials';
    }

    function getInterestsJsonPath(){
        return base_path().'/dependencies/ekpizo/database/jsondata/interests.json';
    }

    function getRatingsJsonPath(){
        return base_path().'/dependencies/ekpizo/database/jsondata/ratings.json';
    }

    function getAvailabilityFrequenciesJsonPath(){
        return base_path().'/dependencies/ekpizo/database/jsondata/availability_frequencies.json';
    }

    function getHowYouLearnedJsonPath(){
        return base_path().'/dependencies/ekpizo/database/jsondata/how_you_learned.json';
    }
}
