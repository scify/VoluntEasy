<?php namespace Interfaces;

/**
 * Interface VolunteerInterface
 * @package Interfaces
 *
 * Defines the basic operations for the Volunteer
 */
interface VolunteerInterface{

    function store();

    function update($volunteer);

    function apiStore();

}
