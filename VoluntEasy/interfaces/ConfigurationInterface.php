<?php

namespace Interfaces;

/**
 * Interface ConfigurationInterface
 */
interface ConfigurationInterface
{
    /*** Paths for the views ***/
    public function getViewsPath();

    public function getPartialsPath();

    public function getJsonDataPath();

    public function getExtrasPath();

    public function getExtras();

    public function hasTasks();
}
