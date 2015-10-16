<?php namespace Dependencies\ekpizo\configuration;


use Interfaces\ConfigurationInterface;

class Configuration implements ConfigurationInterface {

/*
    function getPartialLoginFooterPath() {
        return 'ekpizo.resources.views._login_footer';
    }

    function getVolunteerFormPath() {
        return 'ekpizo.resources.views.volunteers._form';
    }
*/
    function getViewsPath() {
        return 'ekpizo.resources.views.volunteers';
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
