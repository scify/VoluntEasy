<?php

use Illuminate\Database\Seeder;

class InsertNewLevelsAndUpdateOldEducationLevels extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('education_levels')->insert([
            array('description' => 'phd'),
            array('description' => 'other')
        ]);

        DB::table('education_levels')->where('description', 'tei')->update(['description' => 'teiA']);
        DB::table('education_levels')->where('description', 'university')->update(['description' => 'aei']);
        DB::table('education_levels')->where('description', 'masters')->update(['description' => 'master']);
    }
}
