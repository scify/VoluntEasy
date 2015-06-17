<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Unit as Unit;

class UnitTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     * Use php artisan db:seed to run the seed files.
     *
     * @return void
     */
    public function run()
    {
        Unit::create([
            'description' => 'SciFY',
            'comments' => 'test@scify.org',
            'password' => Hash::make('1q2w3e'),
            'addr' => '17 Amphiktyonos str & Vassilis',
            'tel' => '123456789',

        ]);
    }

}
