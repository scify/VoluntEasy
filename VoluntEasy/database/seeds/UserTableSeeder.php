<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\User as User;

class UserTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     * Use php artisan db:seed to run the seed files.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Aris',
            'email' => 'aris.stru@gmail.com',
            'password' => Hash::make('aris.stru@gmail.com'),
            'addr' => 'SciFY',
            'tel' => '6666666666',

        ]);
    }

}
