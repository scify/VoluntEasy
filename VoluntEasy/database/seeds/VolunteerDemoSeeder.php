<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Volunteer as Volunteer;

class VolunteerDemoSeeder extends Seeder {

    /**
     * Run the database seeds.
     * Use php artisan db:seed to run the seed files.
     *
     * @return void
     */
    public function run()
    {
        Volunteer::create([
            'name' => 'George',
            'fathers_name' => 'John',
            'last_name' => 'George',
            'identification_num' => 'AK 1234567',
	        'identification_type_id' => 1,
            'birth_date' => '1970-01-01',
            'gender_id' => 1,
            'participation_reason' => 'Just because',
            'extra_lang' => 'Japanese, Chinese',
            'comments' => 'This is a comment',
            'identification_type_id' => 1,
            'marital_status_id' => 1,
            'driver_license_type_id' => 1,
            /*'availability_time_id' => 1,*/
            'availability_freqs_id' => 1,
            'work_status_id' => 1,
	    'email' => 'george@example.com',
	    'education_level_id' => '2',
        ]);


        Volunteer::create([
            'name' => 'Trolli',
            'fathers_name' => 'John',
            'last_name' => 'Trollini',
            'identification_num' => 'fddfd',
            'identification_type_id' => 1,
            'birth_date' => '1970-01-01',
            'gender_id' => 2,
            'participation_reason' => 'I like saving cats',
            'extra_lang' => 'Cat Language',
            'comments' => 'This is a comment',
            'identification_type_id' => 1,
            'marital_status_id' => 1,
            'driver_license_type_id' => 1,
            /*'availability_time_id' => 1,*/
            'availability_freqs_id' => 1,
            'work_status_id' => 1,
	    'email' => 'trolli@example.com',
	    'education_level_id' => '2',
        ]);


        Volunteer::create([
            'name' => 'Mary',
            'fathers_name' => 'John',
            'last_name' => 'Doe',
            'identification_num' => 'AK fdsfdsf',
            'identification_type_id' => 1,
            'birth_date' => '1970-01-01',
            'gender_id' => 2,
            'participation_reason' => 'Just because',
            'extra_lang' => 'Japanese, Chinese',
            'comments' => 'This is a comment',
            'identification_type_id' => 1,
            'marital_status_id' => 1,
            'driver_license_type_id' => 1,
            /*'availability_time_id' => 1,*/
            'availability_freqs_id' => 1,
            'work_status_id' => 1,
	    'email' => 'mary@example.com',
	    'education_level_id' => '2',
        ]);


        Volunteer::create([
            'name' => 'John',
            'fathers_name' => 'John',
            'last_name' => 'Doe',
            'identification_num' => 'AK 1234567',
            'identification_type_id' => 1,
            'birth_date' => '1970-01-01',
            'gender_id' => 1,
            'participation_reason' => 'Just because',
            'extra_lang' => 'Japanese, Chinese',
            'comments' => 'This is a comment',
            'identification_type_id' => 1,
            'marital_status_id' => 1,
            'driver_license_type_id' => 1,
            /*'availability_time_id' => 1,*/
            'availability_freqs_id' => 1,
            'work_status_id' => 1,
	    'email' => 'john@example.com',
	    'education_level_id' => '2',
        ]);
    }

}
