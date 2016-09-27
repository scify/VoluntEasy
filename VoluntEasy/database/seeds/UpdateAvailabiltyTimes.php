<?php

use Illuminate\Database\Seeder;

class UpdateAvailabiltyTimes extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('availability_time')->where('description', 'evening')->update(['description' => 'weekend']);
        DB::table('availability_time')->where('description', 'afternoon')->update(['description' => 'evening']);
    }
}
