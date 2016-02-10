<?php namespace Dependencies\ekpizo\configuration;


use Interfaces\ConfigurationInterface;

class Configuration implements ConfigurationInterface {

    private $folderName = 'ekpizo';

    function getViewsPath() {
        return $this->folderName.'.resources.views';
    }

    function getPartialsPath() {
        return $this->folderName.'.resources.views.volunteers.partials';
    }

    function getJsonDataPath() {
        return base_path().'/dependencies/'.$this->folderName.'/database/jsondata/';
    }

}
