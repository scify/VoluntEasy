<?php

use App\Models\Roles\Role;
use App\Models\User as User;
use Illuminate\Database\Seeder;

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

        $rootUnit = \App\Models\Unit::first();
        $rootUnit->users()->attach([$admin->id]);

        if (env('APP_ENV') == 'demo') {
            $demoUser = new User([
                'name' => 'demo',
                'last_name' => 'demo',
                'email' => 'demo@scify.org',
                'password' => Hash::make('demo1234'),
                'addr' => 'demo',
                'tel' => 'demo',
            ]);
            $demoUser->save();
            $demoUser->roles()->attach($adminRole->id);
            $rootUnit->users()->attach([$demoUser->id]);
        }




    }
}
