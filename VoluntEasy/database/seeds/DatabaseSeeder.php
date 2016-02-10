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
    }


}
