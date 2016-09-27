<?php

use Illuminate\Database\Seeder;
use \App\Models\Descriptions\AvailabilityFrequencies;

class InsertOccasionallyOnAvailabilityFreqs extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $occasionally = AvailabilityFrequencies::create([
            'description' => 'occasionally',
        ]);
        $occasionally->save();
    }
}
