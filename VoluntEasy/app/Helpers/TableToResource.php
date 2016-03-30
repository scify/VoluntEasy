<?php namespace App\Helpers;

class TableToRersource {

    private $tables = [];
    private $path;

    public function __construct() {
        $this->path = base_path('resources/lang/' . env('LOCALE') . '/database/');
    }


    public function transform() {


        foreach ($this->tables as $table) {

            $data =  \DB::table($table)->select('description')->get();

        }


    }

}



