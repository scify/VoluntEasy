<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Unit as Unit;
use App\Models\User as User;

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
            'description' => 'root',
            'comments' => 'Root unit',
        ]);


        $unit->users()->attach(User::first()->id);
    }

}
