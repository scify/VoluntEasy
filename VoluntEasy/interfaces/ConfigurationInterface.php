<?php namespace Interfaces;

/**
 * Interface ConfigurationInterface
 * @package Interfaces
 *
 */
interface ConfigurationInterface {


    /**
     * Get the path for the footer logos partial view
     * displayed at the login page
     *
     * @return mixed
     */
    function getPartialLoginFooterPath();

    function getVolunteerFormPath();

    function getInterestsJsonPath();

    function getRatingsJsonPath();

    function getAvailabilityFrequenciesJsonPath();

    function getHowYouLearnedJsonPath();
}
