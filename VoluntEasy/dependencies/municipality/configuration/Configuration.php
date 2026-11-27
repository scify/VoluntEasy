<?php

namespace Dependencies\municipality\configuration;

use Interfaces\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    private $folderName = 'municipality';

    public function getViewsPath()
    {
        return $this->folderName.'.resources.views';
    }

    public function getPartialsPath()
    {
        return $this->folderName.'.resources.views.volunteers.partials';
    }

    public function getJsonDataPath()
    {
        return base_path().'/dependencies/'.$this->folderName.'/database/jsondata/';
    }

    public function getExtrasPath()
    {
        return $this->folderName.'.resources.views.volunteers.extras';
    }

    public function getExtras()
    {
        return [];
    }

    public function hasTasks()
    {
        return false;
    }
}
