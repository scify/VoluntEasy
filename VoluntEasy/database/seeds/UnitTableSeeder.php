<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Unit as Unit;
use App\Models\User as User;
use \App\Services\Facades\UnitService;

class UnitTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     * Use php artisan db:seed to run the seed files.
     *
     * @return void
     */
    public function run()
    {
        $unit = Unit::create([
            'description' => 'Root',
            'comments' => 'Root unit',
        ]);

        $unit->steps()->saveMany(UnitService::createSteps());

    }

}
