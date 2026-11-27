<?php

namespace Database\Seeders;

use App\Models\Roles\Role;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Use php artisan db:seed to run the seed files.
     *
     * @return void
     */
    public function run()
    {

        // The first administrator (config/app.php "admin"). Without a
        // password a random one is generated and printed once.
        $email = (string) config('app.admin.email');
        $password = (string) config('app.admin.password');
        if ($password === '') {
            $password = Str::password(16, symbols: false);
            $this->command?->warn("Administrator: {$email} / {$password} (change the password after the first login)");
        }

        $admin = new User([
            'name' => 'admin',
            'email' => $email,
            'password' => Hash::make($password),
            'addr' => '',
            'tel' => '',
        ]);

        $admin->save();
        $adminRole = Role::where('name', 'admin')->first();
        $admin->roles()->attach($adminRole->id);

        $rootUnit = Unit::first();
        $rootUnit->users()->attach([$admin->id]);

        if (config('app.env') == 'demo') {
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
