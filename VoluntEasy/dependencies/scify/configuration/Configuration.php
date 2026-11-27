<?php

namespace Dependencies\scify\configuration;

use Interfaces\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    private $folderName = 'scify';

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

    public function hasTasks()
    {
        return true;
    }
}
