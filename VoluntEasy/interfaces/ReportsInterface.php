<?php

namespace Interfaces;

interface ReportsInterface
{
    /**
     * Return the path of the blade view
     * That is the file in resources folder
     */
    public function getViewPath();

    public function volunteersByMonth();

    public function volunteersByAgeGroup();

    public function volunteersBySex();

    public function volunteersByCity();

    public function volunteersByEducationLevel();

    public function volunteerHoursByAction();

    //  function volunteerHoursByMonth();

}
