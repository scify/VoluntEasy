<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $this->call('RoleTableSeeder');
        $this->call('UserTableSeeder');
        $this->call('UnitTableSeeder');
        $this->call('DescriptionsTableSeeder');
        // TODO: USE: for already in production municipality and then delete the seeder and the calls below
        //$this->call('InsertOccasionallyOnAvailabilityFreqs');
        //$this->call('InsertNewLicencesOnDriverLicences');
        //$this->call('InsertNewLevelsAndUpdateOldEducationLevels');
        //$this->call('UpdateAvailabiltyTimes');
        //$this->call('UpdateInterests');
    }


}
