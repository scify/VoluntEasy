<?php namespace Dependencies\ekpizo\configuration;


use Interfaces\ConfigurationInterface;

class Configuration implements ConfigurationInterface {

    private $folderName = 'ekpizo';

    function getViewsPath() {
        return $this->folderName . '.resources.views';
    }

    function getPartialsPath() {
        return $this->folderName . '.resources.views.volunteers.partials';
    }

    function getJsonDataPath() {
        return base_path() . '/dependencies/' . $this->folderName . '/database/jsondata/';
    }


    function getExtrasPath() {
        return $this->folderName . '.resources.views.volunteers.extras';
    }

    function getExtras() {
        return [
            'knows_office',
            'knows_excel',
            'knows_powerpoint',
            'has_previous_volunteer_experience',
            'has_previous_work_experience',
            'volunteering_work_extra',
            'availability',
            'afm',
        ];
    }

    function hasTasks() {
        return true;
    }

    function getServiceForInterface($interfaceName, $default)
    {
        // TODO: Implement getServiceForInterface() method.
    }
}
