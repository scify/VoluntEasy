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
            'name' => 'admin',
            'email' => 'test@scify.org',
            'password' => Hash::make('1q2w3e'),
            'addr' => 'SciFY',
            'tel' => '6666666666',
        ]);
    }

}
