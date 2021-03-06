<?php namespace Interfaces;

/**
 * Interface RatingInterface
 * @package Interfaces
 *
 * Defines the basic operations for the rating
 */
interface RatingInterface{

    function hasCustomRatings();

    function rateVolunteers($token);

}
