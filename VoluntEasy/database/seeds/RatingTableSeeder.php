<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Unit as Unit;
use App\Models\User as User;
use \App\Services\Facades\UnitService;

class RatingTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     * Use php artisan db:seed to run the seed files.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rating_attributes')->delete();

        $attributes = [
            ['description' => 'Συνέπεια'],
            ['description' => 'Ομαδικότητα'],
            ['description' => 'Εργατικότητα'],
            ['description' => 'Προθυμία'],
            ['description' => 'Ικανότητα/Αποτελεσματικότητα'],
        ];

        DB::table('rating_attributes')->insert($attributes);
    }

}
