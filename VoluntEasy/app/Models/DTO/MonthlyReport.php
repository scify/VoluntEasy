<?php namespace App\Models\DTO;


class MonthlyReport {

    private $month;
    private $volunteers;


    public function __construct($month, $volunteers = null) {
        $this->month = $month;
        $this->volunteers = $volunteers;
    }


    public function getMonth() {
        return $this->month;
    }

    public function getVolunteers() {
        return $this->volunteers;
    }

    public function setMonth($month) {
        $this->month = $month;
    }

    public function setVolunteers($volunteers) {
        $this->volunteers = $volunteers;
    }


}
