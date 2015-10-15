<?php namespace Interfaces;

/**
 * Interface ConfigurationInterface
 * @package Interfaces
 *
 */
interface ConfigurationInterface {


    /*** Paths for the views ***/
    function getPartialLoginFooterPath();

    function getVolunteerFormPath();

    /*** Paths for the json files ***/
    function getInterestsJsonPath();

    function getRatingsJsonPath();

    function getAvailabilityFrequenciesJsonPath();

    function getHowYouLearnedJsonPath();
}
