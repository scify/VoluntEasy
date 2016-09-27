<?php

use Illuminate\Database\Seeder;

class InsertNewLicencesOnDriverLicences extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('driver_license_types')->insert([
            array('description' => 'motoDriverLicence'),
            array('description' => 'ixeDriverLicence'),
            array('description' => 'eightPlusOneDriverLicence'),
            array('description' => 'vanDriverLicence'),
            array('description' => 'truckDriverLicence')
        ]);
    }
}
