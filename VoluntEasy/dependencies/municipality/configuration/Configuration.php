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

    function getJsonDataPath() {
        return base_path() . '/dependencies/' . $this->folderName . '/database/jsondata/';
    }

    function getExtrasPath() {
        return $this->folderName.'.resources.views.volunteers.extras';
    }

    function getExtras(){
        return [];
    }

    function hasTasks() {
        return false;
    }
}
