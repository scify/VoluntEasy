<?php namespace Interfaces;


interface ReportsInterface{

    /**
     * Return the path of the blade view
     * That is the file in resources folder
     */
    function getViewPath();

    function volunteersByMonth();


    /*TODO: Refactor*/
    function volunteersByAgeGroup();

    function volunteersBySex();

    function volunteersByCity();

    function volunteersByEducationLevel();

    function volunteerHoursByAction();

  //  function volunteerHoursByMonth();


}
