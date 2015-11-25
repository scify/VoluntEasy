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

    /*** Paths for the json files ***/
    function getInterestsJsonPath();

    function getActionRatingsJsonPath();

    function getRatingsJsonPath();

    function getAvailabilityFrequenciesJsonPath();

    function getDriverLicenceTypesJsonPath();

    function getHowYouLearnedJsonPath();
}
