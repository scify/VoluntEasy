<?php namespace Interfaces;

/**
 * Interface ConfigurationInterface
 * @package Interfaces
 *
 */
interface ConfigurationInterface {

    /*** Paths for the views ***/
    function getViewsPath();

    function getPartialsPath();

    function getJsonDataPath();
}
