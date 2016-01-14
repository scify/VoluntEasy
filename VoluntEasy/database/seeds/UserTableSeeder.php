<?php

use App\Models\User as User;
use Illuminate\Database\Seeder;
use App\Models\Roles\Role;

class UserTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     * Use php artisan db:seed to run the seed files.
     *
     * @return void
     */
    public function run() {

        $admin = new User([
            'name' => 'admin',
            'email' => 'test@scify.org',
            'password' => Hash::make('1q2w3e'),
            'addr' => 'Αμφικτύονος 17, Θησείο, 11851, Αθήνα',
            'tel' => '2114004192',
        ]);

        $admin->save();

        $adminRole = Role::where('name', 'admin')->first();

        $admin->roles()->attach($adminRole->id);

    }

}
