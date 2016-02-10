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

    function getJsonDataPath() {
        return base_path().'/dependencies/'.$this->folderName.'/database/jsondata/';
    }
}
