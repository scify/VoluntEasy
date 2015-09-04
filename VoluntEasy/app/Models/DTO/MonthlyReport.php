<?php namespace App\Models\DTO;


class MonthlyReport {

    public $month;
    public $volunteers;


    public function __construct($month) {
        $this->month = $month;

        $this->volunteers = 0;
    }

}
